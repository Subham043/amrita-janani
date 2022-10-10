<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uuid;
use Carbon\Carbon;
use File;
use Auth;
use App\Models\AudioAccess;
use App\Models\AudioFavourite;
use App\Models\LanguageModel;

class AudioModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table="audios";

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

    public function getAdminName(){
        if(!empty($this->User) && $this->User->count()>0){
            return $this->User->name;
        }
        return "";
    }

    public function AudioFavourite()
    {
        return $this->hasMany('App\Models\AudioFavourite', 'audio_id');
    }
    
    public function AudioAccess()
    {
        return $this->hasMany('App\Models\AudioAccess', 'audio_id');
    }
    
    public function AudioReport()
    {
        return $this->hasMany('App\Models\AudioReport', 'audio_id');
    }

    public function Languages()
    {
        return $this->belongsToMany(LanguageModel::class, 'audio_languages', 'audio_id', 'language_id');
    }

    public function GetLanguagesId(){
        return $this->Languages()->pluck('languages.id')->toArray();
    }

    public function GetLanguagesName(){
        return $this->Languages()->pluck('languages.name');
    }

    public function file_format(){
        return File::extension($this->audio);
    }
    
    public function time_elapsed(){

        $dt = Carbon::parse($this->created_at);
        return $dt->diffForHumans();

    }

    public function contentVisible(){
        try {
            $audioAccess = AudioAccess::where('audio_id', $this->id)->where('user_id', Auth::user()->id)->first();
        } catch (\Throwable $th) {
            //throw $th;
            $audioAccess = null;
        }

        if($this->restricted==0 || Auth::user()->userType!=2){
            return true;
        }else{
            if(empty($audioAccess) || $audioAccess->status==0){
                return false;
            }else{
                return true;
            }
        }
    }

    public function markedFavorite(){
        try {
            $audioFav = AudioFavourite::where('audio_id', $this->id)->where('user_id', Auth::user()->id)->first();
        } catch (\Throwable $th) {
            //throw $th;
            $audioFav = null;
        }
        if(!empty($audioFav)){
            if($audioFav->status == 1){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }

    }

    public function getTagsArray() {
        if($this->tags){
            $arr = explode(",",$this->tags);
            return $arr;
        }
        return array();
    }

}
