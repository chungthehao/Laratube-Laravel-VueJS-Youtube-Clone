<?php

namespace Laratube;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Str;

class Model extends BaseModel
{
    public $incrementing = false;
    protected $guarded = [];

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
}
