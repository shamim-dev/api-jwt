<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeGroup extends Model
{
    use SoftDeletes;
    //


    public function attribute()
    {
        return $this->hasMany('App\Attribute');
       // return $this->hasMany(Attribute::class);
    }

}
