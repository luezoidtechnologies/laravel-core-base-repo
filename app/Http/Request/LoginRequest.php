<?php


namespace App\Http\Request;


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
