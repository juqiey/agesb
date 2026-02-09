<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'pr_no',
        'date',
        'item_req',
        'vessel',
        'confirmed_at',
        'confirmed_by',
        'confirmed_status',
        'confirmed_remark',
        'approved_by',
        'approved_at',
        'approved_status',
        'approved_remark',
        'pro_by',
        'pro_at',
        'pro_status',
        'pro_remark',
        'requested_by',
        'status',
        'title'
    ];

    public $casts = [
      'date'=>'datetime',
        'requested_at'=>'datetime',
        'confirmed_at'=>'datetime',
        'approved_at'=>'datetime',
        'pro_at'=>'datetime'
    ];

    public function requestedBy(){
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function pr_items(){
        return $this->hasMany(PrItem::class, 'pr_id','id');
    }

    public function confirmedBy(){
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function approvedBy(){
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function proBy(){
        return $this->belongsTo(User::class, 'pro_by');
    }

    //Function to generate PR No.
    public static function generatePRNo($vessel){
        $company='AGESB';
        $department = 'OPE';

        //Extract last 2 digits of year
        $year = date('y');

        //Check last running number
        $lastPRNo = self::where('vessel', $vessel)
                        ->whereYear('created_at', date('Y'))
                        ->orderBy('id', 'desc')
                        ->first();

        //Generate running number
        if(!$lastPRNo){
            $running = 1;
        } else {
            $lastRunningStr = substr($lastPRNo->pr_no, strrpos($lastPRNo->pr_no, '-')+1);
            $lastRunning = (int) $lastRunningStr;
            $running = $lastRunning + 1;
        }

        $runningPadded = str_pad($running, 3, '0', STR_PAD_LEFT);

        return "{$company}/{$department}({$vessel})/{$year}-{$runningPadded}";
    }
}
