<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SsaItem extends Model
{
    protected $fillable = [
        'description',
        'model_no',
        'remedial',
        'assistance',
        'doc_url',
        'remark',
        'status',
        'ssa_id',
    ];

    public function ssa(){
        return $this->belongsTo(Ssa::class);
    }

    public function delivery_order(){
        return $this->belongsTo(DeliveryOrder::class);
    }
}
