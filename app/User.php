<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Casts\AccessLevel;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $fillable = ['username', 'email', 'access_level'];
    protected $hidden = ['password', 'api_token'];
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

    public function generateToken()
    {
        return Str::random(80);
    }

    public static function authenticate($data)
    {
        if (!isset($data['email']) && !isset($data['username'])) {
            return response(
                [
                    'errors' => [
                        'message' => ['Credentials do not match our records.'],
                    ],
                ],
                401
            );
        }
        if (isset($data['email'])) {
            $user = self::where('email', $data['email'])
                ->with('detail')
                ->with('detail')
                ->with('role')
                ->with('profile_picture')
                ->with('cover_photo')
                ->first();
            if (!$user) {
                return response(
                    [
                        'errors' => [
                            'email' => ['Email does not match our records.'],
                        ],
                    ],
                    401
                );
            }
        } elseif (isset($data['username'])) {
            $user = self::where('username', $data['username'])
                ->with('detail')
                ->with('detail')
                ->with('role')
                ->with('profile_picture')
                ->with('cover_photo')
                ->first();
            if (!$user) {
                return response(
                    [
                        'errors' => [
                            'username' => [
                                'Username does not match our records.',
                            ],
                        ],
                    ],
                    401
                );
            }
        }
        if (Hash::check($data['password'], $user->password)) {
            $request = request();
            Login::create([
                'user_id' => $user->id,
                'user_agent' => $request->userAgent(),
                'ip_address' => $request->ip(),
            ]);
            $token = $user->createToken('normal')->plainTextToken;
            return ['data' => $user, 'token' => $token];
        }
        return response(
            ['errors' => ['password' => ['Password is incorrect.']]],
            401
        );
    }

    public static function confirm($data)
    {
        if (
            (!isset($data['email']) && !isset($data['username'])) ||
            !isset($data['password'])
        ) {
            return [
                'status' => false,
                'response' => response(
                    ['errors' => ['No credentials provided.']],
                    403
                ),
            ];
        }
        if (isset($data['email'])) {
            $user = User::where('email', $data['email'])->first();
        }
        if (!$user) {
            $user = User::where('username', $data['username'])->first();
        }
        if (!$user) {
            return [
                'status' => false,
                'response' => response(
                    ['errors' => ['Credentials do not exist in records.']],
                    403
                ),
            ];
        }
        if (Hash::check($data['password'], $user->password)) {
            return ['status' => true, 'response' => response('', 204)];
        }
        return [
            'status' => false,
            'response' => response(
                ['errors' => ['Incorrect credentials.']],
                403
            ),
        ];
    }

    public function canPostToClassroom($class_id)
    {
        if ($this->isStudent()) {
            return $this->role()
                ->subscriptions()
                ->where('classroom_id', $class_id)
                ->first()
                ? true
                : false;
        } elseif ($this->isFaculty()) {
            return $this->role()
                ->classrooms()
                ->find($class_id)
                ? true
                : false;
        } else {
            // Admin
            return true;
        }
    }

    public function canCommentToPost($post_id): bool
    {
        $post = Post::find($post_id);
        return $this->canPostToClassroom($post->classroom_id);
    }

    public function canCommentToTask($task_id): bool
    {
        $task = Task::find($task_id);
        return $this->canPostToClassroom($task->classroom_id);
    }

    public function canSubmitToTask($task_id): bool
    {
        return $this->isStudent() && $this->canCommentToTask($task_id);
    }

    /**
     * @param App\TaskComment $comment
     * or
     * @param App\Postcomment $comment
     */
    public function ownsComment($comment): bool
    {
        return $this->id === $comment->user_id;
    }

    public function ownsClassroom($class_id): bool
    {
        return $this->isFaculty() && $this->canPostToClassroom($class_id);
    }

    public function ownsPost(Post $post): bool
    {
        return $this->id = $post->user_id;
    }

    public function ownsTask(Task $task): bool
    {
        return $this->isFaculty() &&
            $this->canPostToClassroom($task->classroom_id);
    }

    public function ownsGrade(Grade $grade): bool
    {
        return $this->ownsClassroom($grade->classroom_id);
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

    public function grades()
    {
        return $this->hasManyThrough(
            Grade::class,
            Student::class,
            'user_id',
            'student_id'
        );
    }

    public function classroomSubscriptions()
    {
        return $this->hasManyThrough(
            ClassroomSubscription::class,
            Student::class,
            'user_id',
            'student_id'
        );
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
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
        return $this->belongsTo(File::class, 'profile_picture_id');
    }

    public function cover_photo()
    {
        return $this->belongsTo(File::class, 'cover_photo_id');
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
