<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'quantity',
        'unit',
        'remark',
        'pr_id',
        'status',
        'doc_url',
        'do_id',
        'unit_price',
        'total_price',
        'quantity_pro'
    ];

    public function delivery_orders(){
        return $this->belongsTo(DeliveryOrder::class, 'do_id','id');
    }

    public function purchase_requests(){
        return $this->belongsTo(PurchaseRequest::class, 'pr_id', 'id');
    }

}
