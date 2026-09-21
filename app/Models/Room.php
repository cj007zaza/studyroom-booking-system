<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';
    protected $primaryKey = 'id';

    protected $fillable = [
        'building',
        'room_name',
        'capacity',
        'facilities',
        'image',
        'status',
    ];

    // ความสัมพันธ์แบบ 1:M ห้อง 1 ห้อง มีการจองได้หลายรายการ (Chapter 9)
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
