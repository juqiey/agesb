<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SsrItem extends Model
{
    protected $fillable = [
        'description',
        'unit',
        'quantity_req',
        'balance',
        'quantity_app',
        'impa_code',
        'remark',
        'status',
        'quantity_pro',
        'unit_price',
        'total_price',
        'ssr_id',
        'do_id'
    ];

    public function ssr(){
        return $this->belongsTo(Ssr::class);
    }

    public function delivery_order(){
        return $this->belongsTo(DeliveryOrder::class);
    }
}
