<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Operations extends Model
{
    //
    protected $fillable = [
        'name',
    ];
    public function user_privileges()
    {
        return $this->belongsTo('App\Model\User_Privileges');
    }
}
