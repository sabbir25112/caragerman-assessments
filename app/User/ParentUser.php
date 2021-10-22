<?php namespace App\User;

use App\Models\User;
use App\Models\UserType;

class ParentUser extends User
{
    const UserType = UserType::Parent;
}
