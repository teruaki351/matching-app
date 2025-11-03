<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Account extends Model
{
    protected $table = 'account';  // 単数名テーブルなので明示
    protected $fillable = [
        'user_id','display_name','bio','birthday','gender',
        'location_pref','lat','lng','avatar_path','height_cm','age_years','blood_type','residence','hometown','education',
    ];

    // --- ここから追加 ---
    public function getAgeAttribute()
    {
        if (!$this->birthday) {
            return null;
        }
        return Carbon::parse($this->birthday)->age;
    }

     protected $casts = ['birthday'=>'date','lat'=>'float','lng'=>'float','height_cm' => 'integer',
        'age_years' => 'integer',];
    public function user() { return $this->belongsTo(User::class); }


    public function photos(){ return $this->hasMany(\App\Models\Photo::class); }
    public function primaryPhoto(){
        return $this->hasOne(\App\Models\Photo::class)->where('is_primary', true);
    }
}
