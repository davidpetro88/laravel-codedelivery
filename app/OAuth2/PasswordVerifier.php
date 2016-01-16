<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 12/29/15
 * Time: 8:02 AM
 */

namespace CodeDelivery\OAuth2;


use Illuminate\Support\Facades\Auth;


class PasswordVerifier
{
    public function verify($username, $password)
    {
        $credentials = [
            'email'    => $username,
            'password' => $password,
        ];

        if (Auth::once($credentials)) {
            return Auth::user()->id;
        }

        return false;
    }
}