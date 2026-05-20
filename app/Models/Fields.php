<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fields extends Model
{
    protected $fillable = [
        'nama_lapangan',
        'tipe_lapangan',
        'ukuran_lapangan',
        'harga_per_jam',
        'image_url',
        'deskripsi'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class,'field_id');
    }
}
