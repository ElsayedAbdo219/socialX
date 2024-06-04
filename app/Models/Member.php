<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

use Laravel\Sanctum\HasApiTokens;

use Illuminate\Notifications\Notifiable;




class Member extends Authenticatable
{
    use HasFactory,HasApiTokens,Notifiable;



    protected $guarded=[];






}
