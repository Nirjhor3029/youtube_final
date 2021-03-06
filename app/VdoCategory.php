<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VdoCategory extends Model
{
    //
    protected $table = 'vdo_categories';


    public function vdoSubCategory(){
        return $this->hasMany('App\VdoSubCategory','VdoCategory_id');
    }

    public function video(){
        return $this->hasMany(Video::class,'category_id');
    }
}
