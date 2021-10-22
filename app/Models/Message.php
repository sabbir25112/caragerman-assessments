<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'text',
        'created_at',
        'type',
    ];

    const System = 1;
    const Manual = 2;

    const MessageTypes = [self::System, self::Manual];
}
