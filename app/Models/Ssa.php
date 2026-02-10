<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ssa extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'ssa_no',
        'location',
        'vessel',
        'date',
        'item',
        'department',
        'doc_url',
        'status',
        'ssa_raised',
        'created_by',
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

    public function ssa_items(){
        return $this->hasMany(SsaItem::class, 'ssa_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'created_by');
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
