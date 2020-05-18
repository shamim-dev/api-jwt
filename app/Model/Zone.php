<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zone extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['country_id', 'name','code','status'];

    public function country()
    {
        return $this->belongsTo('App\Model\Country');
    }
}
