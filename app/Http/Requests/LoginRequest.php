<?php


namespace App\Http\Requests;


use Luezoid\Laravelcore\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string'
        ];
    }
}
