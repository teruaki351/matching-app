<?php

// app/Models/Conversation.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['user_one_id','user_two_id'];

    public function messages()
    {
        // return $this->hasMany(Message::class);
        
        // 時系列順で取りたいので orderBy しておくと便利
        return $this->hasMany(Message::class)->orderBy('created_at');
    }

    public function userOne() { return $this->belongsTo(User::class,'user_one_id'); }
    public function userTwo() { return $this->belongsTo(User::class,'user_two_id'); }

    // 参加者に含まれるか
    public function hasUser(int $userId): bool
    {
        return $this->user_one_id === $userId || $this->user_two_id === $userId;
    }

    // 2者のペアを正規化（小さいID→user_one）
    public static function normalizePair(int $a, int $b): array
    {
        return $a < $b ? [$a,$b] : [$b,$a];
    }
}
