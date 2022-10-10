<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\AudioModel;
use App\Models\DocumentModel;
use App\Models\VideoModel;

class LanguageModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table="languages";

    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function Audios()
    {
        return $this->belongsToMany(AudioModel::class, 'audio_languages', 'audio_id', 'language_id');
    }
    
    public function Videos()
    {
        return $this->belongsToMany(VideoModel::class, 'video_languages', 'video_id', 'language_id');
    }
    
    public function Documents()
    {
        return $this->belongsToMany(DocumentModel::class, 'document_languages', 'document_id', 'language_id');
    }
    

}
