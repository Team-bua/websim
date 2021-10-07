<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBill extends Model
{
    use HasFactory;

    protected $table = 'user_bills';

    public function user_bill()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }
}
