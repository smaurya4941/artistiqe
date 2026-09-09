<?php

namespace App\Services;

use App\Models\BusinessSetting;
use App\Models\User;
use App\Utility\EmailUtility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Creates a `users` account + its art-community profile row for an
 * artist / collector / gallery registration.
 *
 * The account is created in a "pending" state — it cannot be used to log in
 * until an admin approves it from the panel.
 */
class ArtCommunityRegistrar
{
    /**
     * @param  string  $userType       'artist' | 'collector' | 'gallery'
     * @param  string  $name           display name for the users row
     * @param  string|null $email
     * @param  string|null $phone
     * @param  string  $plainPassword
     * @param  class-string<Model>  $profileModel   e.g. \App\Models\CollectorRegister::class
     * @param  array   $profileData    columns for the profile row (without user_id / status)
     */
    public function register(
        string $userType,
        string $name,
        ?string $email,
        ?string $phone,
        string $plainPassword,
        string $profileModel,
        array $profileData
    ): User {
        return DB::transaction(function () use ($userType, $name, $email, $phone, $plainPassword, $profileModel, $profileData) {
            $verifyEmail = $email
                && optional(BusinessSetting::where('type', 'email_verification')->first())->value == 1;

            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->phone = $phone;
            $user->password = Hash::make($plainPassword);
            $user->user_type = $userType;
            // Approval — not email verification — is the real gate, so auto-verify the
            // email unless the store explicitly wants email verification too.
            $user->email_verified_at = $verifyEmail ? null : now();
            $user->save();

            /** @var Model $profile */
            $profile = new $profileModel();
            $profile->fill($profileData);
            $profile->user_id = $user->id;
            $profile->email = $email;
            $profile->phone = $phone;
            $profile->status = 'pending';
            $profile->save();

            if ($verifyEmail) {
                try {
                    EmailUtility::email_verification($user, 'customer');
                } catch (\Throwable $e) {
                    // non-fatal — admin can still approve; user can request verification later
                }
            }

            // Notify admin of the pending registration (reuses the generic template).
            try {
                if (get_email_template_data('customer_reg_email_to_admin', 'status') == 1) {
                    EmailUtility::customer_registration_email('customer_reg_email_to_admin', $user, null);
                }
            } catch (\Throwable $e) {
                // non-fatal
            }

            return $user;
        });
    }
}
