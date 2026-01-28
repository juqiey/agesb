<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ssr extends Model
{

    protected $fillable = [
        'ssr_no',
        'location',
        'vessel',
        'date',
        'item',
        'department',
        'doc_url',
        'status',
        'verified_at',
        'verified_by',
        'verified_status',
        'verified_remark',
        'approved_by',
        'approved_at',
        'approved_status',
        'approved_remark',
        'pro_by',
        'pro_at',
        'pro_status',
        'pro_remark',
        'requested_by'
    ];

    public function ssr_items(){
        return $this->hasMany(SsrItem::class, 'ssr_id', 'id');
    }

    public function users(){
        return $this->belongsTo(User::class, 'requested_by');
    }
}
