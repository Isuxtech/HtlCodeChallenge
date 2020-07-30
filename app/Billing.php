<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $fillable=['billed', 'bill_date'];

    /**
     * @param $query
     * this scope filters all records that was marked as 'not billed' (0) in the billings table
     */
    public function scopeNotBilled($query){
        $query->where('billed', 0);
    }
}
