<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Menu_Items extends Model
{
    //
    public function user_privileges()
    {
        return $this->belongsTo('App\Model\User_Privileges');
    }
}
