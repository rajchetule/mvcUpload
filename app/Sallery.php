<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sallery extends Model
{
    protected $fillable = [
        'person_id', 'date', 'product', 'price',
    ];



}
