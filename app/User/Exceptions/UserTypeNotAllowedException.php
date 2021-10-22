<?php namespace App\User\Exceptions;

class UserTypeNotAllowedException extends \Exception
{
    protected $message = "You Can't Set UserType Manually";
}
