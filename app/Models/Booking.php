<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'room_id',
        'booking_date',
        'time_slot',
        'participant_count',
        'purpose',
        'status',
        'admin_note',
    ];

    // ความสัมพันธ์แบบ N:1 การจองเป็นของห้อง 1 ห้อง (Chapter 9)
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // ความสัมพันธ์แบบ N:1 การจองเป็นของนักศึกษา/ผู้ใช้ 1 คน (Chapter 9)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
