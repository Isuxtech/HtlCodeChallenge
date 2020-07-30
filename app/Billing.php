<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $fillable=['billed', 'billing_date'];


    public function scopeNotBilled($query){
        return $query->where('billed', 0)->select('username','amount_to_bill');
    }
}
