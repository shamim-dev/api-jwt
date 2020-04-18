<?php
namespace App\Http\Helper;

use Illuminate\Database\Schema\Blueprint;

class CustomBlueprint extends Blueprint
{
    public function commonFields()
    {
       // $this->timestamp('created_at')->nullable();
        $this->tinyInteger('status')->default(0);
        $this->timestamp('created_at')->useCurrent();
        $this->unsignedBigInteger('created_by')->nullable();
        $this->timestamp('updated_at')->nullable();;
        $this->unsignedBigInteger('updated_by')->nullable();
        $this->timestamp('deleted_at')->nullable();;
       // $this->boolean('isActive')->default(0);
    }

}

?>