<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/4/20
 * Time: 1:26 AM
 */

namespace App\Repositories;

use App\Models\User;
use Luezoid\Laravelcore\Repositories\EloquentBaseRepository;

class UserRepository extends EloquentBaseRepository
{
    public $model = User::class;
}
