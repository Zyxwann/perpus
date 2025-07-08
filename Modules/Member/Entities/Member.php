<?php

namespace Modules\Member\Entities;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = ['nama', 'email', 'alamat',];
}
