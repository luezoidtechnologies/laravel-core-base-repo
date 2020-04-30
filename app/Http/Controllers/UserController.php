<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Luezoid\Laravelcore\Http\Controllers\ApiController;

class UserController extends ApiController
{
    protected $repository = UserRepository::class;
}
