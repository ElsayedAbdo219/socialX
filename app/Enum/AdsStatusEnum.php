<?php

namespace App\Enum;

enum AdsStatusEnum: string
{

  public const PENDING = 'pending';
  public const APPROVED = 'approved';
  public const CANCELLED = 'cancelled';
  public static function toArray()
  {
    return [
      self::PENDING => 'pending',
      self::APPROVED => 'approved',
      self::CANCELLED => 'cancelled',
    ];
  }

  public static function ApprovedAndCancelled()
  {
    return [
      self::APPROVED => 'approved',
      self::CANCELLED => 'cancelled',
    ];
  }

    public static function PendingAndCancelled()
  {
    return [
      self::PENDING => 'pending',
      self::CANCELLED => 'cancelled',
    ];
  }


  
  public static function Cancelled()
  {
    return [
      self::CANCELLED => 'cancelled',
    ];
  }


}
