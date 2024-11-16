<?php

namespace App\Repositories;

use App\Models\UserGroupMember;
use App\Repositories\Interfaces\UserGroupMemberRepositoryInterface;
use App\Repositories\BaseRepository;

/**
 * Class UserService
 * @package App\Services
 */
class UserGroupMemberRepository extends BaseRepository implements UserGroupMemberRepositoryInterface
{
    protected $model;

    public function __construct(
        UserGroupMember $model
    ){
        $this->model = $model;
    }
    
}
