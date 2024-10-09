<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    use HasFactory;

    public function categories() {
        return $this->hasMany('App\Models\Category', 'section_id')->where(['parent_id'=>'ROOT', 'status'=>1])->with('subcategories');
    }
}
