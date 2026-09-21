<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $building = $request->query('building');

        $roomsQuery = Room::where('status', 'available');
        if ($building) {
            $roomsQuery->where('building', $building);
        }
        $rooms = $roomsQuery->orderBy('building')->orderBy('room_name')->get();
        $allRooms = Room::orderBy('building')->orderBy('room_name')->get();
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $todayBookings = Booking::where('booking_date', date('Y-m-d'))
            ->whereIn('status', ['approved', 'pending'])
            ->count();

        $myPendingBookings = 0;
        if (Auth::check()) {
            $myPendingBookings = Booking::where('user_id', Auth::id())
                ->where('status', 'pending')
                ->count();
        }

        // ดึงข้อมูลการจองสำหรับแสดงผลบนปฏิทิน (FullCalendar)
        $bookings = Booking::with(['room', 'user'])
            ->whereIn('status', ['pending', 'approved'])
            ->get();

        $calendarEvents = $bookings->map(function ($b) {
            $parts = explode('-', $b->time_slot);
            $startTime = trim($parts[0] ?? '08:30');
            $endTime = trim($parts[1] ?? '10:30');

            $cleanStart = preg_replace('/[^0-9:]/', '', $startTime);
            $cleanEnd = preg_replace('/[^0-9:]/', '', $endTime);
            if (!str_contains($cleanStart, ':')) {
                $cleanStart = '08:30';
            }
            if (!str_contains($cleanEnd, ':')) {
                $cleanEnd = '10:30';
            }

            // สีตามสถานะ: สีน้ำเงินเมื่ออนุมัติแล้ว (#2563eb), สีส้มเมื่อรอการอนุมัติ (#f59e0b)
            $bgColor = $b->status === 'approved' ? '#2563eb' : '#f59e0b';

            $roomTitle = $b->room ? $b->room->room_name : 'ห้อง';

            return [
                'id' => $b->id,
                'roomId' => (string)$b->room_id,
                'title' => $roomTitle . ' ' . $b->time_slot,
                'start' => $b->booking_date . 'T' . ($cleanStart ?: '08:30') . ':00',
                'end' => $b->booking_date . 'T' . ($cleanEnd ?: '10:30') . ':00',
                'backgroundColor' => $bgColor,
                'borderColor' => $bgColor,
                'textColor' => '#ffffff',
                'extendedProps' => [
                    'room_name' => $b->room ? $b->room->room_name : '-',
                    'building' => $b->room ? $b->room->building : '-',
                    'time_slot' => $b->time_slot,
                    'booking_date' => date('d/m/Y', strtotime($b->booking_date)),
                    'raw_date' => $b->booking_date,
                    'user_name' => $b->user ? $b->user->name : 'ไม่ระบุ',
                    'student_id' => $b->user ? ($b->user->student_id ?? '-') : '-',
                    'faculty' => $b->user ? ($b->user->faculty ?? '-') : '-',
                    'major' => $b->user ? ($b->user->major ?? '-') : '-',
                    'year_level' => $b->user ? ($b->user->year_level ?? '-') : '-',
                    'participant_count' => $b->participant_count,
                    'purpose' => $b->purpose,
                    'status' => $b->status,
                    'status_label' => $b->status === 'approved' ? 'อนุมัติแล้ว' : 'รอการอนุมัติ',
                    'status_badge' => $b->status === 'approved' ? 'bg-success' : 'bg-warning text-dark',
                ],
            ];
        });

        return view('home', compact(
            'rooms', 
            'allRooms',
            'building', 
            'totalRooms', 
            'availableRooms', 
            'todayBookings', 
            'myPendingBookings',
            'calendarEvents'
        ));
    }
}
