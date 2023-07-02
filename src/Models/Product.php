<?php

namespace App\Models;

use App\Core\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable =  ['title','price','description','image'];

    public function hello()
    {
        return 'this hello method from product model';
    }
}