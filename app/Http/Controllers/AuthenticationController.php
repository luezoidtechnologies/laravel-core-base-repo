<?php


namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Request\LoginRequest;
use Luezoid\Laravelcore\Constants\ErrorConstants;
use Luezoid\Laravelcore\Exceptions\InvalidCredentialsException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AuthenticationController extends BaseController
{
    public function doLogin(LoginRequest $request)
    {
        $validator = $request->getValidator();

        if ($validator->fails()) {
            return $this->standardResponse(null, $validator->errors()->messages(), 400, ErrorConstants::TYPE_BAD_REQUEST_ERROR);
        }
        $email = $request->json('email');
        $password = $request->json('password');

        /** @var User $user */
        $user = User::where('email', '=', $email)->first();
        if (!$user) {
            throw new BadRequestHttpException(__('User not found'));
        }

        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            throw new InvalidCredentialsException(__('Invalid Credentials'), 401);
        }

        $result = [
            'user' => $user,
            'token' => $user->createToken('App Personal Access Client')->accessToken
        ];
        return $this->standardResponse($result);
    }
}
