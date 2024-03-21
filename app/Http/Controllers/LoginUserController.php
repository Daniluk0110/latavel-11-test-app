<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Client;

class LoginUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $client = Client::query()->where('password_client', true)->latest()->first();
            dump($client->toArray());

            $response = Http::asForm()
                ->withOptions(['verify' => false])
                ->post('laravel.test/oauth/token', [
                    'client_id' => $client->id,
                    'client_secret' => $client->secret,
                    'username' => $request->get('email'),
                    'password' => $request->get('password'),
                    'grant_type' => 'password',
                    'scope' => ''
                ]);

            $body = json_decode($response->body());
            dd($body);


            return response()->json([
                'status' => 'success',
                'user' => Auth::user(),
            ]);
        }

        return response()->json([
            'error' => true,
            'validationException' => [
                'email' => 'Неверные учетные данные.'
            ],
        ], 422);
    }
}
