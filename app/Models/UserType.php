<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name'
    ];

    const Parent = 1;
    const Teacher = 2;
    const Student = 3;
}
