<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SocialAuthRequest;
use App\Http\Resources\UserResource;
use App\Models\SocialAuth;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SocialAuthController extends Controller
{
    public function login(SocialAuthRequest $request)
    {
        $provider = $request->auth_type;
        $user = UserRepository::socialAuthCheckOrCreate($request, $provider);

        return $this->json('Login successfully', [
            'user' => new UserResource($user),
            'access' => UserRepository::getAccessToken($user),
        ]);

        return view('social-auth.index');
    }

    /**
     * Handle token exchange for a given provider (e.g. Google, Facebook, Twitter).
     *
     * @param  string  $provider
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleTokenExchange($provider, Request $request)
    {
        $request->validate([
            'code' => 'required',
        ]);

        $socialAuth = SocialAuth::where('provider', $provider)->first();

        if (! $socialAuth) {
            return $this->json('Invalid provider', [], Response::HTTP_BAD_REQUEST);
        }

        switch ($provider) {
            case 'google':
                return $this->googleTokenExchange($request->code, $socialAuth);
            case 'facebook':
                return $this->facebookTokenExchange($request->code, $socialAuth);
            case 'apple':
                return $this->appleAccessControl($request, $socialAuth);
            default:
                return $this->json('Invalid provider', [], Response::HTTP_BAD_REQUEST);
        }
    }

    private function googleTokenExchange($code, $socialAuth)
    {
        // Exchange the authorization code for an access token
        $response = \Illuminate\Support\Facades\Http::post('https://oauth2.googleapis.com/token', [
            'code' => $code,
            'client_id' => $socialAuth->client_id,
            'client_secret' => $socialAuth->client_secret,
            'redirect_uri' => 'postmessage',
            'grant_type' => 'authorization_code',
        ]);

        if ($response->failed()) {
            return $this->json('Error: ' . ($response->json('error_description') ?? $response->json('error') ?? 'Failed to exchange token'), [], Response::HTTP_BAD_REQUEST);
        }

        $accessToken = $response->json('access_token');

        // Retrieve user information with the access token
        $userResponse = \Illuminate\Support\Facades\Http::withToken($accessToken)
            ->get('https://www.googleapis.com/oauth2/v3/userinfo');

        if ($userResponse->failed()) {
            return $this->json('Error: Failed to retrieve user information', [], Response::HTTP_BAD_REQUEST);
        }

        $userInfo = $userResponse->json();

        $data = [
            'name' => $userInfo['name'] ?? null,
            'email' => $userInfo['email'] ?? null,
            'phone' => $userInfo['phone'] ?? null,
            'provider' => 'google',
            'id' => $userInfo['sub'] ?? null,
            'profile_url' => $userInfo['picture'] ?? null,
            'gender' => $userInfo['gender'] ?? null,
        ];

        $user = UserRepository::socialAuthCheckOrCreate($data, 'google');

        return $this->json('Login successfully', [
            'user' => new UserResource($user),
            'access' => UserRepository::getAccessToken($user),
        ]);
    }

    private function facebookTokenExchange($code, $socialAuth) {}

    private function appleAccessControl($request, $socialAuth)
    {
        $data = [
            'name' => $request->data['name'] ?? 'Apple User',
            'email' => $request->data['email'] ?? null,
            'phone' => $request->data['phone'] ?? null,
            'provider' => 'apple',
            'id' => $request->data['sub'],
            'profile_url' => null,
            'gender' => null,
        ];

        $user = UserRepository::socialAuthCheckOrCreate($data, 'google');

        return $this->json('Login successfully', [
            'user' => new UserResource($user),
            'access' => UserRepository::getAccessToken($user),
        ]);
    }
}
