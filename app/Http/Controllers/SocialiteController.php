<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProvideCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Failed to get data from Google.');
        }

        // Hanya login jika user sudah ada, tanpa membuat akun baru
        $authUser = $this->findUser($user, $provider);

        if (!$authUser) {
            return redirect()->route('login')->with('error', 'This Google account is not registered.');
        }

        // Login user
        Auth::login($authUser, true);

        // Redirect ke dashboard setelah login
        return redirect()->route('dashboard');
    }

    public function findUser($socialUser, $provider)
    {
        // Cari akun sosial berdasarkan Google ID
        $socialAccount = SocialAccount::where('provider_id', $socialUser->getId())
            ->where('provider_name', $provider)
            ->first();

        if ($socialAccount) {
            return $socialAccount->user;
        }

        // Jika tidak ada, cek apakah email sudah ada di database
        $user = User::where('email', $socialUser->getEmail())->first();

        // Jika user tidak ditemukan, langsung return null (tidak buat akun baru)
        if (!$user) {
            return null;
        }

        // Jika user ditemukan, pastikan akun sosialnya terdaftar
        $user->socialAccounts()->create([
            'provider_id'   => $socialUser->getId(),
            'provider_name' => $provider
        ]);

        return $user;
    }
}
