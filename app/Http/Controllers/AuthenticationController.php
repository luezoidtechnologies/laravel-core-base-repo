<?php


namespace App\Http\Controllers;


use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Request\LoginRequest;
use Luezoid\Laravelcore\Exceptions\InvalidCredentialsException;
use Luezoid\Laravelcore\Jobs\BaseJob;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AuthenticationController extends BaseController
{

    protected $repository = UserRepository::class;

    public function doLogin(LoginRequest $request)
    {
        $validator = $request->getValidator();

        if ($validator->fails()) {
            return $this->standardResponse(null, $validator->errors()->messages(), 400, "");
        }
        $username = $request->json('email');
        $password = $request->json('password');

        $user = User::where('email', '=', $username)->first();
        if (!$user) {
            throw new BadRequestHttpException(__('User not found'));
        }

        if (!Auth::attempt(['email' => $username, 'password' => $password])) {
            throw new InvalidCredentialsException(__('Invalid Credentials'), 401);
        }

        $result = [
            'user' => $user,
            'token' => $user->createToken('App Personal Access Client')->accessToken
        ];
        return $this->standardResponse($result);
    }
}
