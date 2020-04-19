<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'attribute_group_id','ip_address','status'
    ];

    public function attributeGroup()
    {
        return $this->belongsTo('App\AttributeGroup');
        //return $this->belongsTo(AttributeGroup::class);
    }
}

