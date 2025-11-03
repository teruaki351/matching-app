<?php

// app/Models/Photo.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['account_id','path','sort_order','is_primary'];

    public function account(){ return $this->belongsTo(Account::class); }
}
