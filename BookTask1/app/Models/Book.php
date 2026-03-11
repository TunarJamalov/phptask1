<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title','category_id','price'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
