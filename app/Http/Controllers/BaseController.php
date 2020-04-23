<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Luezoid\Laravelcore\Http\Controllers\ApiController;
use Luezoid\Laravelcore\Services\EnvironmentService;
use Luezoid\Laravelcore\Services\UtilityService;

class BaseController extends ApiController
{

    /**
     * @return mixed|null
     * @throws \Exception
     */
    public function getLoggedInUser()
    {
        return EnvironmentService::getLoggedInUser();
    }

    /**
     * @return null
     * @throws \Exception
     */
    public function getLoggedInUserId()
    {
        return EnvironmentService::getLoggedInUserId();
    }

    public function getUserByToken()
    {
        $user = Auth::user();
        if (!$user) {
            return $this->standardResponse(null, "user not found", 403);
        }
        return $user;
    }

    public function standardResponse($data, $message = null, $httpCode = 200, $type = null)
    {
        if ($httpCode == 200 && $data && $this->isSnakeToCamel) {
            $data = UtilityService::fromSnakeToCamel(json_decode(json_encode($data), true));
        }
        $data = $data && method_exists($data, 'toArray') ? $data->toArray() : $data;
        return response()->json([
            "message" => $message,
            "data" => request('stringify') ? json_encode($data) : $data,
            "type" => $type
        ], $httpCode);
    }
}
