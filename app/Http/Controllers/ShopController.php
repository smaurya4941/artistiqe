<?php

namespace App\Http\Controllers;

use App\Models\AffiliateConfig;
use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\User;
use App\Models\BusinessSetting;
use App\Models\RegistrationVerificationCode;
use App\Models\SmsTemplate;
use App\Services\SendSmsService;
use Auth;
use Hash;
use App\Utility\EmailUtility;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\OTPVerificationController;
use Cookie;
use Illuminate\Support\Facades\Session;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('user', ['only' => ['index']]);
    }

    public function index()
    {
        $shop = Auth::user()->shop;
        return view('seller.shop', compact('shop'));
    }

    public function create()
    {
        if(get_setting('seller_registration_verify') === '1' ){
            abort(404);
        }

        $email = null;
        $phone = null;
        if (Auth::check()) {
            if ((Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'customer')) {
                flash(translate('Admin or Customer cannot be a seller'))->error();
                return back();
            }
            if (Auth::user()->user_type == 'seller') {
                flash(translate('This user already a seller'))->error();
                return back();
            }
        } else {
            return view('auth.'.get_setting('authentication_layout_select').'.seller_registration', compact('email','phone'));
        }
    }

    public function store(Request $request)
{
    $rules = [
        'type' => 'required|in:artist,gallery',

        // Contact
        'email' => [
            'required',
            'email',
            'unique:users,email',
            'regex:/^[\w\.\-]+@([\w\-]+\.)+com$/i', // must end with .com (your original rule)
        ],
        'phone' => ['nullable','digits:10','unique:users,phone'],

        // Security
        'password' => [
            'required',
            'confirmed',
            'min:8',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/'
        ],

        // Location (all optional now)
        'country' => ['nullable','string','max:100'],
        'city'    => ['nullable','string','max:100'],
        'state'   => ['nullable','string','max:100'],
        'pincode' => ['nullable','digits:6'],
    ];

    // Personal / Gallery fields
    if ($request->type === 'artist') {
        $rules['first_name'] = ['required','string','max:100'];
        $rules['last_name']  = ['nullable','string','max:100'];
    } else {
        $rules['gallery_name']     = ['required','string','max:150'];
        $rules['gallery_location'] = ['nullable','string','max:150'];
    }

    $validated = $request->validate($rules);

    // Create user
    $user = new User();
    $user->name = $request->type === 'artist'
        ? trim(($request->first_name ?? '').' '.($request->last_name ?? ''))
        : ($request->gallery_name ?? '');
    $user->email = $request->email;
    $user->phone = $request->phone; // may be null
    $user->user_type = "seller";
    $user->password = Hash::make($request->password);
    $user->email_verified_at = now();

    if ($user->save()) {
        // Create shop
        $shop = new Shop();
        $shop->user_id = $user->id;
        $shop->type = $request->type;
        $shop->first_name = $request->first_name;
        $shop->last_name = $request->last_name; // may be null
        $shop->gallery_name = $request->gallery_name;
        $shop->gallery_location = $request->gallery_location; // may be null

        // Normalize casing if provided
        $shop->country = $request->filled('country') ? ucwords(strtolower($request->country)) : null;
        $shop->city    = $request->filled('city')    ? ucwords(strtolower($request->city))    : null;
        $shop->state   = $request->filled('state')   ? ucwords(strtolower($request->state))   : null;
        $shop->pincode = $request->pincode ?: null;

        $shop->name = $user->name;

        // Address: prefer explicit gallery_location, else join non-empty city/state
        $locationParts = array_filter([$shop->city, $shop->state], fn($v) => !empty($v));
        $shop->address = $shop->gallery_location ?: (count($locationParts) ? implode(', ', $locationParts) : null);

        $shop->slug = preg_replace('/\s+/', '-', str_replace("/", " ", $user->name));
        $shop->description = $request->input('description');

        $shop->save();

        auth()->login($user, true);

        // Emails (kept as-is)
        if ((get_email_template_data('registration_email_to_seller', 'status') == 1)) {
            try { EmailUtility::selelr_registration_email('registration_email_to_seller', $user, null); } catch (\Exception $e) {}
        }
        if ((get_email_template_data('seller_reg_email_to_admin', 'status') == 1)) {
            try { EmailUtility::selelr_registration_email('seller_reg_email_to_admin', $user, null); } catch (\Exception $e) {}
        }

        flash(translate('Your Shop has been created successfully!'))->success();
        return redirect()->route('seller.shop.index');
    }

    flash(translate('Sorry! Something went wrong.'))->error();
    return back();
}



    public function show($id) { }

    public function edit($id) { }

    public function destroy($id) { }

    public function verifyRegEmailorPhone(){
        $type = 'seller';
        if (Auth::check()) {
            if ((Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'customer')) {
                flash(translate('Admin or Customer cannot be a seller'))->error();
                return back();
            }
            if (Auth::user()->user_type == 'seller') {
                flash(translate('This user already a seller'))->error();
                return back();
            }
        } else {
            return view('auth.'.get_setting('authentication_layout_select').'.reg_verification', compact('type'));
        }
    }

    public function sendRegVerificationCode(Request $request){
        $email = $request->email ?? null;
        $phone = $request->phone != null ? '+'.$request->country_code.$request->phone : null;

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if(User::where('email', $email)->first() != null){
                flash(translate('Email already exists.'))->error();
                return back();
            }
        }
        elseif (User::where('phone', $phone)->first() != null) {
            flash(translate('Phone already exists.'))->error();
            return back();
        }

        $verificationCode = rand(100000, 999999);
        $sellerVerification = RegistrationVerificationCode::updateOrCreate(
            ['email' => $email, 'phone' => $phone], 
            ['code' => $verificationCode]
        );
        $success = 1;

        if ($email) {
            try {
                EmailUtility::email_verification_for_registration_seller('email_verification_for_registration_seller', $email, $verificationCode);
            } catch (\Exception $e) {
                $success = 0;
            }
        }
        else {
            if (addon_is_activated('otp_system')){
                $sms_template   = SmsTemplate::where('identifier', 'phone_number_verification')->first();
                $sms_body       = $sms_template->sms_body;
                $sms_body       = str_replace('[[code]]', $verificationCode, $sms_body);
                $sms_body       = str_replace('[[site_name]]', env('APP_NAME'), $sms_body);
                $template_id    = $sms_template->template_id;
                
                (new SendSmsService())->sendSMS($phone, env('APP_NAME'), $sms_body, $template_id);
            }
        }

        if($success){
            return redirect()->route('shop-reg.verify_code', encrypt($sellerVerification->id));
        }
        else {
            flash(translate('Something went wrong!'))->error();
            return back();
        }
    }

    public function regVerifyCode($id){
        $sellerVerification = RegistrationVerificationCode::whereId(decrypt($id))->first();
        return view('auth.'.get_setting('authentication_layout_select').'.seller_verify_confirmation', compact('sellerVerification'));
    }

    public function regVerifyCodeConfirmation(Request $request){
        $email = isset($request->email) ? $request->email : null;
        $phone = isset($request->phone) ? $request->phone  : null;

        $sellerVerification = RegistrationVerificationCode::where('code', $request->verification_code);
        $sellerVerification = $request->email != null ? 
                                $sellerVerification->where('email', $email) :
                                $sellerVerification->where('phone', $phone);
        $sellerVerification = $sellerVerification->first();
        if($sellerVerification == null){
            flash(translate('Verification code do not matched'))->error();
            return back();
        }
        else {
            $sellerVerification->is_verified = 1;
            $sellerVerification->save();
            return view('auth.'.get_setting('authentication_layout_select').'.seller_registration', compact('sellerVerification','email','phone'));
        }
    }
}
