<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'do_no',
        'job_no',
        'vessel',
        'do_recipient',
        'location',
        'total',
        'date'
    ];

    protected $casts = [
        'date'=>'datetime'
    ];

    public function ssr_items(){
        return $this->hasMany(SsrItem::class, 'do_id', 'id');
    }

    public function pr_items(){
        return $this->hasMany(PrItem::class, 'do_id', 'id');
    }

    public function users(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
