<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderDetail extends Model
{
    use HasFactory;
    protected $table = 'work_order_details';
    protected $fillable = ['item','qty','unit_code','unit_type','egi','workorder_id'];
    public function workorder(){
        return $this->belongsTo(WorkOrder::class,'workorder_id');
    }
}
