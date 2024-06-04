<?php

namespace App\Enum;

enum UserTypeEnum: string
{
    public const ADMIN = 'admin';
    public const CLIENT = 'client'; //عميل
    public const EMPLOYEE = 'employee';
    public const COMPANY = 'company'; // شركة
    public const SUPPLIER = 'supplier'; // مورد
    public const MAKHZANY = 'مخزني'; // مخزني

    
    
}
