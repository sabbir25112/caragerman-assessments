<?php namespace App\User;

use App\Models\User;
use App\Models\UserType;

class Student extends User
{
    const UserType = UserType::Student;
    const DefaultAvatar = "default_student.jpg";

    function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }
}
