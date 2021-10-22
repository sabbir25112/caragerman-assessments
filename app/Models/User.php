<?php namespace App\Models;

use App\User\Exceptions\InvalidUserInformationException;
use App\User\Exceptions\UserTypeNotAllowedException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class User extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'salutation',
        'first_name',
        'last_name',
        'email',
        'profile_photo',
        'user_type_id',
    ];

    const DefaultAvatar = 'default_avatar.jpg';

    public function getFullNameAttribute()
    {
        $fullname = "";
        if ($this->salutation) {
            $fullname .= $this->salutation . " ";
        }
        $fullname .= $this->first_name . " " . $this->last_name;

        return $fullname;
    }

    public function save(array $options = [])
    {
        if ($this->user_type_id != null && $this->user_type_id != static::UserType) {
            throw new UserTypeNotAllowedException();
        }

        $validator = Validator::make($this->toArray(), [
            'email'         => 'required|email',
            'profile_photo' => 'sometimes|ends_with:.jpg',
        ]);

        if ($validator->fails()) {
            throw new InvalidUserInformationException();
        }

        return parent::save($options);
    }


    public function getAvatar()
    {
        if ($this->profile_photo == null) return static::DefaultAvatar;

        return $this->profile_photo;
    }
}
