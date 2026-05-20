<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'field_id',
        'tanggal_main',
        'jam_mulai',
        'jam_selesai',
        'total_harga',
        'status'
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function field()
    {
        return $this->belongsTo(Fields::class);;
    }

    public function payment()
    {
        return $this->hasOne(payments::class);
    }
}
