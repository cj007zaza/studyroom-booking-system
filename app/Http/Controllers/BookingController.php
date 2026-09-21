<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    // แสดงประวัติการจองของนักศึกษาคนนั้นๆ (Chapter 9: with eager loading)
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('room')
            ->orderBy('booking_date', 'desc')
            ->orderBy('time_slot', 'asc')
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    // หน้าแบบฟอร์มการจองห้อง
    public function create(Request $request)
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.bookings')->with('error', 'บัญชีผู้ดูแลระบบไม่สามารถทำการจองห้องได้ เมนูนี้สำหรับนักศึกษาเท่านั้น');
        }

        $selectedRoomId = $request->query('room_id');
        $rooms = Room::where('status', 'available')->orderBy('building')->orderBy('room_name')->get();
        
        $timeSlots = [
            '08:30 - 10:30',
            '10:30 - 12:30',
            '13:00 - 15:00',
            '15:00 - 17:00',
            '17:00 - 19:00',
            '19:00 - 21:00',
        ];

        return view('bookings.create', compact('rooms', 'selectedRoomId', 'timeSlots'));
    }

    // ตรวจสอบและบันทึกการจอง (Validation & ป้องกันการจองเวลาชนกัน)
    public function store(Request $request)
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.bookings')->with('error', 'บัญชีผู้ดูแลระบบไม่สามารถทำการจองห้องได้ เมนูนี้สำหรับนักศึกษาเท่านั้น');
        }

        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|string|max:100',
            'participant_count' => 'required|integer|min:1',
            'purpose' => 'required|string|max:1000',
        ], [
            'room_id.required' => 'กรุณาเลือกห้อง Study Room',
            'booking_date.required' => 'กรุณาระบุวันที่ต้องการใช้งาน',
            'booking_date.after_or_equal' => 'วันที่จองต้องเป็นวันนี้หรือวันข้างหน้าเท่านั้น',
            'time_slot.required' => 'กรุณากรอกช่วงเวลาที่ต้องการใช้ห้อง',
            'participant_count.required' => 'กรุณาระบุจำนวนผู้เข้าใช้งาน',
            'participant_count.integer' => 'จำนวนผู้เข้าใช้งานต้องเป็นตัวเลข',
            'participant_count.min' => 'จำนวนผู้เข้าใช้งานต้องมีอย่างน้อย 1 คน',
            'purpose.required' => 'กรุณากรอกวัตถุประสงค์การเข้าใช้งาน',
        ]);

        $room = Room::findOrFail($request->room_id);

        // ตรวจสอบว่ามีผู้จองห้องและเวลานี้ไปแล้วหรือยัง
        $conflict = Booking::where('room_id', $request->room_id)
            ->where('booking_date', $request->booking_date)
            ->where('time_slot', $request->time_slot)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($conflict) {
            return back()->withInput()->withErrors([
                'time_slot' => "ขออภัย ห้อง {$room->room_name} ในวันที่ {$request->booking_date} ช่วงเวลา {$request->time_slot} มีการจองแล้ว กรุณาระบุช่วงเวลาอื่นหรือห้องอื่น",
            ]);
        }

        Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'booking_date' => $request->booking_date,
            'time_slot' => $request->time_slot,
            'participant_count' => $request->input('participant_count', 1),
            'purpose' => $request->purpose,
            'status' => 'pending',
        ]);

        return redirect()->route('home')->with('success', 'ส่งคำขอจองห้องสำเร็จ ข้อมูลจะปรากฏบนปฏิทินหน้าแรกทันที');
    }

    // นักศึกษากดยกเลิกการจอง
    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'คุณไม่มีสิทธิ์ยกเลิกรายการนี้');
        }

        if ($booking->status === 'approved' || $booking->status === 'pending') {
            $booking->update(['status' => 'cancelled']);
            return redirect()->route('bookings.index')->with('success', 'ยกเลิกการจองห้องเรียบร้อยแล้ว');
        }

        return redirect()->route('bookings.index')->with('error', 'ไม่สามารถยกเลิกรายการนี้ได้');
    }

    // ผู้ดูแลระบบดูรายการจองทั้งหมด (Chapter 9: Eager Loading with room & user)
    public function adminIndex(Request $request)
    {
        $statusFilter = $request->query('status');
        $query = Booking::with(['room', 'user'])->latest();

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        $bookings = $query->paginate(20);

        // สรุปสถิติสำหรับแอดมิน
        $pendingCount = Booking::where('status', 'pending')->count();
        $approvedCount = Booking::where('status', 'approved')->count();
        $totalCount = Booking::count();

        return view('bookings.admin_manage', compact('bookings', 'statusFilter', 'pendingCount', 'approvedCount', 'totalCount'));
    }

    // ผู้ดูแลระบบกด อนุมัติ ปฏิเสธ หรือแก้ไขผลการพิจารณา
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
            'admin_note' => 'nullable|string|max:500',
        ]);

        $note = $request->admin_note;
        if (empty($note) && $request->status === 'rejected') {
            $note = 'ไม่อนุมัติคำขอ';
        }

        $booking->update([
            'status' => $request->status,
            'admin_note' => $note,
        ]);

        $statusText = match($request->status) {
            'approved' => 'อนุมัติการจองแล้ว',
            'rejected' => 'ปฏิเสธคำขอจองแล้ว',
            'pending' => 'รีเซ็ตสถานะเป็นรอการอนุมัติแล้ว',
            default => 'บันทึกการพิจารณาแล้ว',
        };
        return back()->with('success', "ดำเนินการ{$statusText} เรียบร้อย");
    }
}
