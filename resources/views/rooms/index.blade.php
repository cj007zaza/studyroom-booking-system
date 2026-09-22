@extends('layout')

@section('title', 'จัดการข้อมูลห้อง Study Room')

@section('content')
<!-- เมนูด่วนด้านบนสำหรับ Admin ไม่ต้องเลื่อนหา -->
<div class="card border-0 shadow-sm mb-4 bg-white">
    <div class="card-body p-3 p-md-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h4 class="fw-bold mb-1" style="color: var(--color-neutral-heading);">
                    <i class="bi bi-door-closed-fill me-2 text-primary"></i> จัดการห้อง Study Room
                </h4>
                <p class="text-secondary small mb-0">ระบบเพิ่ม ลบ แก้ไข ข้อมูลห้องพักและรูปภาพ</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.bookings') }}" class="btn btn-outline-primary fw-semibold">
                    <i class="bi bi-shield-check me-1"></i> จัดการคำขอจองห้อง
                </a>
                <a href="{{ route('rooms.create') }}" class="btn btn-primary fw-semibold shadow-sm">
                    <i class="bi bi-plus-circle me-1"></i> เพิ่มห้องใหม่
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">รูปภาพ</th>
                        <th>หอพัก</th>
                        <th>ชื่อห้อง</th>
                        <th>สิ่งอำนวยความสะดวก</th>
                        <th>สถานะ</th>
                        <th class="text-end pe-4">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rooms as $room)
                        <tr>
                            <td class="ps-4">
                                @if($room->image)
                                    <img src="{{ str_starts_with($room->image, 'data:') ? $room->image : asset($room->image) }}" 
                                         alt="{{ $room->room_name }}" 
                                         width="80" height="55" 
                                         class="rounded-3 object-fit-cover shadow-sm border"
                                         onerror="this.onerror=null; this.src='{{ asset('images/rooms/room_mr1.jpg') }}';">
                                @else
                                    <span class="badge bg-light text-secondary border">ไม่มีรูปภาพ</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border fw-medium px-2 py-1">
                                    <i class="bi bi-building me-1 text-secondary"></i> {{ $room->building }}
                                </span>
                            </td>
                            <td class="fw-bold" style="{{ $room->building === 'หอพักครุศาสตร์' ? 'color: var(--color-secondary);' : 'color: var(--color-primary);' }}">
                                {{ $room->room_name }}
                            </td>
                            <td><small class="text-secondary">{{ Str::limit($room->facilities ?? '-', 50) }}</small></td>
                            <td>
                                @if($room->status === 'available')
                                    <span class="badge badge-approved">พร้อมใช้งาน</span>
                                @else
                                    <span class="badge badge-cancelled">ปิดปรับปรุง</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('rooms.edit', $room) }}" class="btn btn-sm btn-outline-warning me-1 fw-semibold" style="border-radius: var(--radius-md);">
                                    <i class="bi bi-pencil me-1"></i> แก้ไข
                                </a>
                                <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="d-inline" onsubmit="return confirm('ยืนยันการลบห้อง {{ $room->room_name }} ใช่หรือไม่?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger fw-medium" style="border-radius: var(--radius-md);">
                                        <i class="bi bi-trash me-1"></i> ลบ
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-secondary">
                                ยังไม่มีข้อมูลห้องในระบบ
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
