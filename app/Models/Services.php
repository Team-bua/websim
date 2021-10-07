<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    protected $table = 'services';

    public function service()
    {
        return $this->belongsTo(ServiceBill::class,'service_id', 'id');
    }
}
