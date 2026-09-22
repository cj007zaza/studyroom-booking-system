<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class RoomController extends Controller
{
    // แสดงรายการห้องทั้งหมด (Chapter 8)
    public function index()
    {
        $rooms = Room::orderBy('building')->orderBy('room_name')->get();
        return view('rooms.index', compact('rooms'));
    }

    // ฟอร์มสำหรับเพิ่มห้องใหม่ (Chapter 8)
    public function create()
    {
        return view('rooms.create');
    }

    // บันทึกข้อมูลห้องใหม่ พร้อมอัปโหลดไฟล์ภาพ (Chapter 8)
    public function store(Request $request)
    {
        $request->validate([
            'building' => 'required|string|max:255',
            'room_name' => 'required|string|max:255|unique:rooms,room_name',
            'capacity' => 'nullable|integer',
            'facilities' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'status' => 'required|string|in:available,maintenance',
        ], [
            'building.required' => 'กรุณาระบุหอพัก',
            'room_name.required' => 'กรุณาระบุชื่อห้อง',
            'room_name.unique' => 'ชื่อห้องนี้มีอยู่ในระบบแล้ว',
            'image.image' => 'ไฟล์ที่อัปโหลดต้องเป็นไฟล์รูปภาพเท่านั้น',
            'image.max' => 'ไฟล์รูปภาพต้องมีขนาดไม่เกิน 10 MB',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $mime = $file->getMimeType();
            $data = file_get_contents($file->getRealPath());
            $imagePath = 'data:' . $mime . ';base64,' . base64_encode($data);

            try {
                $targetDir = public_path('images/rooms');
                if (!File::exists($targetDir)) {
                    File::makeDirectory($targetDir, 0775, true, true);
                }

                $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($targetDir, $imageName);
            } catch (\Exception $e) {
                // เก็บรูปเป็น Base64 ในฐานข้อมูลอยู่แล้ว ไม่กังวลกรณีดิสก์มีปัญหา
            }
        }

        Room::create([
            'building' => $request->building,
            'room_name' => $request->room_name,
            'capacity' => $request->input('capacity', 6),
            'facilities' => $request->facilities,
            'image' => $imagePath,
            'status' => $request->status,
        ]);

        return redirect()->route('rooms.index')->with('success', 'เพิ่มข้อมูลห้องสำเร็จเรียบร้อย');
    }

    // ฟอร์มแก้ไขข้อมูลห้อง (Chapter 8)
    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    // อัปเดตข้อมูลห้องและจัดการรูปภาพเดิม (Chapter 8)
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'building' => 'required|string|max:255',
            'room_name' => 'required|string|max:255|unique:rooms,room_name,' . $room->id,
            'capacity' => 'nullable|integer',
            'facilities' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'status' => 'required|string|in:available,maintenance',
        ], [
            'building.required' => 'กรุณาระบุหอพัก',
            'room_name.required' => 'กรุณาระบุชื่อห้อง',
            'room_name.unique' => 'ชื่อห้องนี้มีอยู่ในระบบแล้ว',
            'image.image' => 'ไฟล์ที่อัปโหลดต้องเป็นไฟล์รูปภาพเท่านั้น',
            'image.max' => 'ไฟล์รูปภาพต้องมีขนาดไม่เกิน 10 MB',
        ]);

        $imagePath = $room->image;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $mime = $file->getMimeType();
            $data = file_get_contents($file->getRealPath());
            $imagePath = 'data:' . $mime . ';base64,' . base64_encode($data);

            try {
                $targetDir = public_path('images/rooms');
                if (!File::exists($targetDir)) {
                    File::makeDirectory($targetDir, 0775, true, true);
                }

                if ($room->image && !str_starts_with($room->image, 'data:') && File::exists(public_path($room->image))) {
                    File::delete(public_path($room->image));
                }

                $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($targetDir, $imageName);
            } catch (\Exception $e) {
                // เก็บรูปเป็น Base64 ในฐานข้อมูลอยู่แล้ว ไม่กังวลกรณีดิสก์มีปัญหา
            }
        }

        $room->update([
            'building' => $request->building,
            'room_name' => $request->room_name,
            'capacity' => $request->input('capacity', $room->capacity),
            'facilities' => $request->facilities,
            'image' => $imagePath,
            'status' => $request->status,
        ]);

        return redirect()->route('rooms.index')->with('success', 'ปรับปรุงข้อมูลห้องสำเร็จเรียบร้อย');
    }

    // ลบข้อมูลห้องและลบไฟล์ภาพ (Chapter 8) — ป้องกันลบห้องที่มี booking ค้างอยู่
    public function destroy(Room $room)
    {
        // ตรวจสอบว่ามี booking ที่ยังใช้งานอยู่หรือไม่ (pending หรือ approved)
        $activeBookings = $room->bookings()
            ->whereIn('status', ['pending', 'approved'])
            ->count();

        if ($activeBookings > 0) {
            return redirect()->route('rooms.index')->with('error',
                "ไม่สามารถลบห้อง {$room->room_name} ได้ เนื่องจากยังมีคำขอจองที่ใช้งานอยู่ {$activeBookings} รายการ กรุณาจัดการคำขอจองก่อนทำการลบ"
            );
        }

        if ($room->image && File::exists(public_path($room->image))) {
            File::delete(public_path($room->image));
        }

        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'ลบข้อมูลห้องสำเร็จเรียบร้อย');
    }
}
