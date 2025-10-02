<?php

namespace App\Helpers;

class ValidateHelp
{
    public static function login(): array
    {
        return [
            'nip'       => 'required|string|max:255',
            'captcha' => 'required|captcha',
            'password'  => 'required|min:6'
        ];
    }

    public static function register(): array
    {
        return [
            'name'      => 'required|string|max:255',
            'nip'       => 'required|string|max:255',
            'satker'    => 'required|string|max:255',
            'role'      => 'required',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:8',
        ];
    }

    public static function update($id): array
    {
        return [
            'name' => 'required|string|max:255',
            'nip' => 'required|string|max:255',
            'satker' => 'required|string|max:255',
            'role' => 'required',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
        ];
    }
}
