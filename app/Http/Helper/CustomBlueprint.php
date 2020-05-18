<?php
namespace App\Http\Helper;

use Illuminate\Database\Schema\Blueprint;

class CustomBlueprint extends Blueprint
{
    public function commonFields()
    {
       // $this->timestamp('created_at')->nullable();
        $this->tinyInteger('status')->default(0);
        $this->unsignedBigInteger('created_by')->nullable();
        $this->unsignedBigInteger('updated_by')->nullable();
        $this->timestamp('deleted_at')->nullable();
        $this->timestamp('created_at')->useCurrent();
        $this->timestamp('updated_at')->nullable();;
        $this->ipAddress('ip_address')->nullable();
       // $this->boolean('isActive')->default(0);
    }

}

?>