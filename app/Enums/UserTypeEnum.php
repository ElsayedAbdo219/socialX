<?php
namespace App\Enums;

enum UserTypeEnum: string
{
    case ADMIN = 'admin';
    case Employee = 'employee';
    case COMPANY = 'company';

}