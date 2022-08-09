<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uuid;
use File;
use Carbon\Carbon;

class DocumentModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table="documents";

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

    public function DocumentFavourite()
    {
        return $this->hasMany('App\Models\DocumentFavourite', 'document_id');
    }
    
    public function DocumentAccess()
    {
        return $this->hasMany('App\Models\DocumentAccess', 'document_id');
    }
    
    public function DocumentReport()
    {
        return $this->hasMany('App\Models\DocumentReport', 'document_id');
    }

    public function file_format(){
        return File::extension($this->document);
    }
    
    public function time_elapsed(){

        $dt = Carbon::parse($this->created_at);
        return $dt->diffForHumans();

    }

}
