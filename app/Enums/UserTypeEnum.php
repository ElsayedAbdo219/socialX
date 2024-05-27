<?php
namespace App\Enums;

enum UserTypeEnum: string
{
   public const ADMIN = 'admin';
   public const Employee = 'employee';
   public  const COMPANY = 'company';

}