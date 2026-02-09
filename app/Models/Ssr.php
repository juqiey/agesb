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

    protected $casts = [
        'date'=>'datetime',
        'verified_at'=>'datetime',
        'approved_at'=>'datetime',
        'pro_at'=>'datetime'
    ];

    public function ssr_items(){
        return $this->hasMany(SsrItem::class, 'ssr_id', 'id');
    }

    public function users(){
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function verifiedBy(){
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function approvedBy(){
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function proBy(){
        return $this->belongsTo(User::class, 'pro_by');
    }
}
