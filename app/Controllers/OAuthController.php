<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Provider\Facebook;

class OAuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function redirectGoogle()
    {
        $provider = new Google([
            'clientId'     => env('GOOGLE_CLIENT_ID'),
            'clientSecret' => env('GOOGLE_CLIENT_SECRET'),
            'redirectUri'  => env('GOOGLE_REDIRECT_URI'),
        ]);

        $authUrl = $provider->getAuthorizationUrl([
            'scope' => ['email', 'profile']
        ]);

        session()->set('oauth2state', $provider->getState());
        return redirect()->to($authUrl);
    }

    public function callbackGoogle()
    {
        $provider = new Google([
            'clientId'     => env('GOOGLE_CLIENT_ID'),
            'clientSecret' => env('GOOGLE_CLIENT_SECRET'),
            'redirectUri'  => env('GOOGLE_REDIRECT_URI'),
        ]);

        $state = $this->request->getGet('state');
        $code  = $this->request->getGet('code');

        if (!$state || $state !== session()->get('oauth2state')) {
            session()->remove('oauth2state');
            return redirect()->to('login')->with('failed', 'Invalid state. Silakan coba lagi.');
        }

        try {
            $token   = $provider->getAccessToken('authorization_code', ['code' => $code]);
            $user    = $provider->getResourceOwner($token);
            $email   = $user->getEmail();
            $name    = $user->getName();

            return $this->loginOrRegister($email, $name, 'google');
        } catch (\Exception $e) {
            return redirect()->to('login')->with('failed', 'Login Google gagal: ' . $e->getMessage());
        }
    }

    public function redirectFacebook()
    {
        $provider = new Facebook([
            'clientId'        => env('FACEBOOK_APP_ID'),
            'clientSecret'    => env('FACEBOOK_APP_SECRET'),
            'redirectUri'     => env('FACEBOOK_REDIRECT_URI'),
            'graphApiVersion' => 'v18.0',
        ]);

        $authUrl = $provider->getAuthorizationUrl([
            'scope' => ['email', 'public_profile']
        ]);

        session()->set('oauth2state', $provider->getState());
        return redirect()->to($authUrl);
    }

    public function callbackFacebook()
    {
        $provider = new Facebook([
            'clientId'        => env('FACEBOOK_APP_ID'),
            'clientSecret'    => env('FACEBOOK_APP_SECRET'),
            'redirectUri'     => env('FACEBOOK_REDIRECT_URI'),
            'graphApiVersion' => 'v18.0',
        ]);

        $state = $this->request->getGet('state');
        $code  = $this->request->getGet('code');

        if (!$state || $state !== session()->get('oauth2state')) {
            session()->remove('oauth2state');
            return redirect()->to('login')->with('failed', 'Invalid state. Silakan coba lagi.');
        }

        try {
            $token = $provider->getAccessToken('authorization_code', ['code' => $code]);
            $user  = $provider->getResourceOwner($token);
            $email = $user->getEmail();
            $name  = $user->getName();

            return $this->loginOrRegister($email, $name, 'facebook');
        } catch (\Exception $e) {
            return redirect()->to('login')->with('failed', 'Login Facebook gagal: ' . $e->getMessage());
        }
    }

    private function loginOrRegister($email, $name, $provider)
    {
        $existing = $this->userModel->where('email', $email)->first();

        if ($existing) {
            session()->set([
                'username'   => $existing['username'],
                'role'       => $existing['role'],
                'isLoggedIn' => true,
            ]);
        } else {
            $username = strtolower(str_replace(' ', '', $name)) . rand(100, 999);
            $this->userModel->insert([
                'username'   => $username,
                'email'      => $email,
                'password'   => password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT),
                'role'       => 'user',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            session()->set([
                'username'   => $username,
                'role'       => 'user',
                'isLoggedIn' => true,
            ]);
        }

        return redirect()->to('/');
    }
}
