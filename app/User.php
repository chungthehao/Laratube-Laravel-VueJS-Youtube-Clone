<?php

namespace Laratube;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    // Tắt việc tự động tăng id (mặc định ở class cha Illuminate\Database\Eloquent\Model nó là true)
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        // * Register model hook
        // - Vì xài uuid, ko xài id tự tăng nữa, nên mỗi lần insert record phải c/c uuid
        static::creating(function ($model) {
            // $model->id = (string) Str::uuid();

            // Flexible cho trường hợp bảng đó ko dùng 'id' làm primary key mà dùng tên khác bất kỳ.
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }

    public function channel()
    {
        return $this->hasOne(Channel::class);
    }
}
