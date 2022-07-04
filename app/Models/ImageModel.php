<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Uuid;

class ImageModel extends Model
{
    use HasFactory;
    protected $table="images";

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }
}
