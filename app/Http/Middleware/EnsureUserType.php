<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Gate a route to one or more user_type values.
 *
 *   ->middleware('user_type:artist')
 *   ->middleware('user_type:collector,gallery')
 *
 * For art-community types the linked profile must also be `approved`,
 * and the user must not be banned.
 */
class EnsureUserType
{
    public function handle(Request $request, Closure $next, string ...$types)
    {
        $user = Auth::user();

        if (! $user) {
            session(['link' => url()->current()]);
            return redirect()->route('user.login');
        }

        if (! in_array($user->user_type, $types, true) || $user->banned) {
            abort(404);
        }

        if (in_array($user->user_type, User::ART_COMMUNITY_TYPES, true) && ! $user->artCommunityApproved()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            flash(translate('Your account is awaiting admin approval.'))->warning();
            return redirect()->route('user.login');
        }

        return $next($request);
    }
}
