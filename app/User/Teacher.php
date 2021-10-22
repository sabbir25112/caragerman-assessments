<?php namespace App\User;

use App\Models\User;
use App\Models\UserType;

class Teacher extends User
{
    const UserType = UserType::Teacher;
}
