<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['name','code'];
    public function zone()
    {
        return $this->hasMany('App\Model\Zone');
    }
}
