<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NRProduct extends Model
{
    //
    protected $fillable = [
        'sku','non_returnable_code'
    ];
    public function scopeFilter($q)
    {
      
        if (request('query')) {
            $q->where('sku','LIKE','%'.request('query').'%');
        }
        return $q;
    }
}
