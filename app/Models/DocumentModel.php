<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Uuid;

class DocumentModel extends Model
{
    use HasFactory;
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
        return $this->belongsTo('App\Models\LanguageModel', 'language');
    }

    public function url(){
        $url = UrlSigner::sign(url('file/'.$this->image), Carbon::now()->addSeconds(10));
        return $url;
    }
}
