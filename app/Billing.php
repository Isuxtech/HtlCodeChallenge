<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $fillable=['billed', 'bill_date'];


    public function scopeNotBilled($query){
        $query->where('billed', 0);
    }
}
