<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    public function category() {
        return $this->belongsTo('App\Models\category', 'category_id');
    }

    public function section() {
        return $this->belongsTo('App\Models\Sections', 'section_id');
    }
}
