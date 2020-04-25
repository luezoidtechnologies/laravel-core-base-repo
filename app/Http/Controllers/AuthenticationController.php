<?php


namespace App\Http\Controllers;


use App\Constants\AppConstants;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Luezoid\Laravelcore\Constants\ErrorConstants;
use Luezoid\Laravelcore\Exceptions\InvalidCredentialsException;
use Luezoid\Laravelcore\Http\Controllers\ApiController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AuthenticationController extends ApiController
{
    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidCredentialsException
     */
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
            'token' => $user->createToken(AppConstants::DEFAULT_PASSPORT_TOKEN_NAME)->accessToken
        ];
        return $this->standardResponse($result);
    }
}
