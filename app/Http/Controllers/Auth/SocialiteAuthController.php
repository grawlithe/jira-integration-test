<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialiteAuthController extends Controller
{
    public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(string $provider)
    {

        // dd("something");

        try {
            // Get the user information from the provider
            $socialiteUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            // Handle error, such as user denied access or invalid state
            return redirect('/login')->withErrors(['social_login' => 'Could not authenticate with ' . ucfirst($provider) . '.']);
        }

        // Find user by email or by provider-specific ID
        $user = User::where('email', $socialiteUser->getEmail())->first();

        // If the user exists, log them in
        if ($user) {
            Auth::login($user);
            return redirect('/dashboard');
        }

        // If the user doesn't exist, create a new user and log them in
        // NOTE: For better security/integration, you may want to prompt the user
        // to link this new account with an existing local account if the email matches.

        // Check if the provider gave us a name, otherwise use a default
        $name = $socialiteUser->getName() ?? $socialiteUser->getNickname() ?? 'New User';

        $user = User::create([
            'name' => $name,
            'email' => $socialiteUser->getEmail(),
            'email_verified_at' => now(),
            // Store the provider ID and the token for future API calls if needed
            "{$provider}_id" => $socialiteUser->getId(),
            'access_token' => $socialiteUser->token, // Store the token securely if you need to make API calls later
            'password' => \Hash::make(\Str::random(24)), // Create a dummy/random password as they're using social login
        ]);

        Auth::login($user);
        return redirect('/dashboard');
    }
}
