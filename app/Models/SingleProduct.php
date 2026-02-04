<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SingleProduct extends Model
{
    //
    protected $hidden = ['pivot'];
    
    protected $fillable = [
        'tb_id','gi_id','os_id','plytix_id', 'sku', 'tb_url','tb_price','gi_url','os_url'
    ]; 
    protected $table = 'single_products';

    public function includedIn()
    {
        return $this->belongsToMany('App\SetProduct','set_single');
    }
}
