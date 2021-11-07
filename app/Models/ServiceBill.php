<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceBill extends Model
{
    use HasFactory;

    protected $table = 'service_bills';
    protected $fillable = ['service_id', 'user_id', 'order_code', 'phone_number', 'code_otp', 'expired_time', 'content', 
    'price', 'checked_status', 'status', 'code_status'];

    public function service_bill()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Services::class,'service_id', 'id');
    }
}
