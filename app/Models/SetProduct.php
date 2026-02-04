<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SetProduct extends Model
{
    //
    protected $hidden = ['pivot'];
    
    protected $fillable = [
        'tb_id','gi_id','os_id','plytix_id', 'sku', 'tb_url','tb_price','gi_url','os_url' 
    ];

    public function contains()
    {
        return $this->belongsToMany('App\SingleProduct' , 'set_single');
    }
}
