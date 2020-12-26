<?php


namespace App\Core;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model as BaseModel;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Support\Str;

abstract class UuidModel extends BaseModel
{
    use Uuid;

//    public static function boot(): void
//    {
//        parent::boot();
//
//        static::creating(function ($model) {
//            $model->{$model->getKeyName()} = (string) Str::uuid();
//        });
//    }

}
