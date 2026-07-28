<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserCanAccessPanel
{
    /**
     * Filament aborts with a raw 403 when an authenticated user's
     * canAccessPanel() returns false - it doesn't redirect. That's what a
     * deactivated user sees if a "remember me" cookie silently logs them
     * back in after their session rows were cleared.
     *
     * This middleware catches that case earlier: it logs the user out
     * properly, invalidates the session, and sends them to the login page
     * with an explanatory notification instead of a bare 403 page.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $panel = Filament::getCurrentPanel();
        $user = Auth::user();

        if ($panel && $user && ! $user->canAccessPanel($panel)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            Notification::make()
                ->warning()
                ->title('You have been signed out')
                ->body('Your account is inactive. Please contact an administrator if you believe this is a mistake.')
                ->persistent()
                ->send();

            return redirect()->route('filament.'.$panel->getId().'.auth.login');
        }

        return $next($request);
    }
}