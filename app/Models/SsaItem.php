<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SsaItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'description',
        'model_no',
        'remedial',
        'assistance',
        'doc_url',
        'remark',
        'status',
        'ssa_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'service_url'
    ];
    protected $dates = ['deleted_at'];
    public function ssa(){
        return $this->belongsTo(Ssa::class);
    }
    public function delivery_order(){
        return $this->belongsTo(DeliveryOrder::class);
    }
}
