<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdersWebhook extends Model
{
    //
    protected $fillable = [
        'store_hash', 'order_id', 'tremendous_processed'
    ];
}
