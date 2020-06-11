<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Casts\AccessLevel;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['username', 'email', 'access_level'];
    protected $hidden = ['password'];
    protected $casts = [
        'access_level' => AccessLevel::class,
    ];

    const ADMIN = 3;
    const FACULTY = 2;
    const STUDENT = 1;

    const PROVIDER_SELF = 'CampusKid';
    const PROVIDER_FACEBOOK = 'Facebook';
    const PROVIDER_GOOGLE = 'Google';
    const PROVIDER_GITHUB = 'GitHub';

    public static $access_levels = [
        self::ADMIN => 'Administrator',
        self::FACULTY => 'Faculty',
        self::STUDENT => 'Student',
    ];

    public static function authenticate($data)
    {
        if (!isset($data['email']) && !isset($data['username'])) {
            return response('Credentials do not match our records.', 401);
        }
        if (isset($data['email'])) {
            $user = self::where('email', $data['email'])->first();
            if (!$user) {
                return response(
                    ['errors' => ['Credentials do not match our records.']],
                    401
                );
            }
        } elseif (isset($data['username'])) {
            $user = self::where('username', $data['username'])->first();
            if (!$user) {
                return response(
                    ['errors' => ['Credentials do not match our records.']],
                    401
                );
            }
        }
        if (Hash::check($data['password'], $user->password)) {
            $token = Str::random(80);
            $user->api_token = $token;
            $user->save();
            return $user;
        }
        return response(
            ['errors' => ['Credentials do not match our records.']],
            401
        );
    }

    public function setProviderAsSelf()
    {
        $this->attributes['provider_type'] = self::PROVIDER_SELF;
        $this->attributes['provider_id'] = Str::random(20);
        return $this;
    }

    public function setPasswordAttribute(string $value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function detail()
    {
        return $this->hasOne(Detail::class);
    }

    public function role()
    {
        return $this->morphTo();
    }

    public function profile_picture()
    {
        return $this->hasOne(File::class, 'profile_picture_id');
    }

    public function cover_photo()
    {
        return $this->hasOne(File::class, 'cover_photo_id');
    }

    public function delete()
    {
        $this->role->delete();
        $this->detail->delete();
        $this->profile_picture->delete();
        $this->cover_photo->delete();
        return parent::delete();
    }

    public function isAdministrator()
    {
        return $this->access_level === self::ADMIN ||
            $this->access_level === self::$access_levels[self::ADMIN];
    }

    public function isFaculty()
    {
        return $this->access_level === self::FACULTY ||
            $this->access_level === self::$access_levels[self::FACULTY];
    }

    public function isStudent()
    {
        return $this->access_level === self::STUDENT ||
            $this->access_level === self::$access_levels[self::STUDENT];
    }
}
