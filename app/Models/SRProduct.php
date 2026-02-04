<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SRProduct extends Model
{
    //
    protected $fillable = [
        'sku','state_code'
    ];
    public function scopeFilter($q)
    {
      
        if (request('query')) {
            $q->where('sku','LIKE','%'.request('query').'%');
        }
        return $q;
    }
}
