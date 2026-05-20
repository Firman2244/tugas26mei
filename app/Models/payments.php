<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class payments extends Model
{
    protected $fillable = [
        'booking_id', 'metode_bayar', 'jumlah_bayar', 
        'bukti_transfer', 'status_pembayaran'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
