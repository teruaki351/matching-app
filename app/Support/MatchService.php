<?php

// app/Support/MatchService.php（ファイル名は任意）
namespace App\Support;

use App\Models\Like;

class MatchService
{
    public static function isMutualLike(int $a, int $b): bool
    {
        $ab = Like::where('from_user_id',$a)->where('to_user_id',$b)->exists();
        $ba = Like::where('from_user_id',$b)->where('to_user_id',$a)->exists();
        return $ab && $ba;
    }
}
