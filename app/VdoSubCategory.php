<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VdoSubCategory extends Model
{
    protected $table = 'vdo_sub_categories';
    //
    public function vdoCategory(){
        return $this->belongsTo('App\VdoCategory','VdoCategory_id');
    }

    public function video(){
        return $this->hasMany(Video::class,'sub_category_id');
    }

}
