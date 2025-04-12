<?php

namespace App\Enum;

enum ReactTypeEnum: string
{
    public const LIKE = 'like';
    public const DISLIKE = 'dislike'; 
    public const LOVE = 'love'; 
    public const STAR = 'star'; 
    public const FUNNY = 'funny'; 

    public static function toArray() 
    {
        return [
            self::LIKE => 'like' ,
            self::DISLIKE => 'dislike' ,
            self::LOVE => 'love' ,
            self::STAR => 'star' ,
            self::FUNNY => 'funny', 
        ];
      
    }
}
