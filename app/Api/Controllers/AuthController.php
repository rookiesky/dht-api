<?php
/**
 * File name:AuthController.php
 * User: rookie
 * Url : PTP5.Com
 * Date: 2018/8/9
 * Time: 19:19
 */

namespace App\Api\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends BaseController
{
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('username', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $expiration = (int) env('JWT_TTL');

        $token = [
            'expiration' => strtotime('+' . $expiration .'minute'),
            'token' => $token,
            'minute' => $expiration
        ];
        // all good so return the token
        return response()->json($token);
    }
}