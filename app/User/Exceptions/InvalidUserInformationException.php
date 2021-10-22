<?php namespace App\User\Exceptions;

class InvalidUserInformationException extends \Exception
{
    protected $message = "You didn't provide enough information to create a new user";
}
