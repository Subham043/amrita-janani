<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Uuid;
use File;

class ImageModel extends Model
{
    use HasFactory, SoftDeletes;
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

    public function LanguageModel()
    {
        return $this->belongsTo('App\Models\LanguageModel', 'language_id');
    }

    public function ImageFavourite()
    {
        return $this->hasMany('App\Models\ImageFavourite', 'image_id');
    }
    
    public function ImageAccess()
    {
        return $this->hasMany('App\Models\ImageAccess', 'image_id');
    }
    
    public function ImageReport()
    {
        return $this->hasMany('App\Models\ImageReport', 'image_id');
    }

    public function file_format(){
        return File::extension($this->image);
    }
    
    public function time_elapsed(){

        $dt = Carbon::parse($this->created_at);
        return $dt->diffForHumans();

    }

}
