@extends('layout')

@section('title', 'ประวัติการจองห้องของฉัน')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <!-- ส่วนหัวหน้าประวัติการจอง ตรงตามภาพที่ 2 -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-clock fs-2 text-primary"></i>
                <h2 class="fw-bold mb-0" style="color: #0f172a; letter-spacing: -0.3px;">ประวัติการจองห้องของฉัน</h2>
            </div>
            <p class="text-secondary small mt-1 mb-0">ตรวจสอบสถานะคำขอจองห้อง Study Room (ดึงข้อมูลด้วย Eloquent Relationship ตาม Chapter 9)</p>
        </div>
        <a href="{{ route('bookings.create') }}" class="btn text-white fw-semibold px-3 py-2 shadow-sm d-inline-flex align-items-center gap-1" style="background-color: #1e3a8a; border-radius: 8px; min-height: 42px;">
            <i class="bi bi-plus-circle me-1"></i> จองห้องเพิ่ม
        </a>
    </div>

    <!-- การ์ดตารางประวัติการจอง ตรงตามภาพที่ 2 -->
    <div class="card border-0 shadow-sm bg-white overflow-hidden" style="border-radius: 14px; border: 1px solid #e2e8f0 !important;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0" aria-label="ตารางแสดงประวัติการจองห้อง Study Room" style="border-collapse: separate; border-spacing: 0;">
                    <thead style="background-color: #ffffff;">
                        <tr>
                            <th class="ps-4 text-secondary fw-semibold py-3" style="font-size: 0.8125rem; border-top: 0; border-bottom: 1px solid #e2e8f0; width: 140px;">วันที่จอง</th>
                            <th class="text-secondary fw-semibold py-3" style="font-size: 0.8125rem; border-top: 0; border-bottom: 1px solid #e2e8f0; width: 150px;">ช่วงเวลา</th>
                            <th class="text-secondary fw-semibold py-3" style="font-size: 0.8125rem; border-top: 0; border-bottom: 1px solid #e2e8f0; width: 140px;">ห้อง STUDY ROOM</th>
                            <th class="text-secondary fw-semibold py-3" style="font-size: 0.8125rem; border-top: 0; border-bottom: 1px solid #e2e8f0; width: 140px;">หอพัก</th>
                            <th class="text-secondary fw-semibold py-3" style="font-size: 0.8125rem; border-top: 0; border-bottom: 1px solid #e2e8f0; width: 85px;">จำนวนคน</th>
                            <th class="text-secondary fw-semibold py-3" style="font-size: 0.8125rem; border-top: 0; border-bottom: 1px solid #e2e8f0;">วัตถุประสงค์</th>
                            <th class="text-secondary fw-semibold py-3" style="font-size: 0.8125rem; border-top: 0; border-bottom: 1px solid #e2e8f0; width: 125px;">สถานะการจอง</th>
                            <th class="text-secondary fw-semibold py-3" style="font-size: 0.8125rem; border-top: 0; border-bottom: 1px solid #e2e8f0; width: 220px;">หมายเหตุจากผู้ดูแล</th>
                            <th class="text-end pe-4 text-secondary fw-semibold py-3" style="font-size: 0.8125rem; border-top: 0; border-bottom: 1px solid #e2e8f0; width: 95px;">ยกเลิก</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <!-- วันที่จอง พร้อมไอคอนปฏิทิน -->
                                <td class="ps-4 text-nowrap py-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-calendar-event text-primary" style="font-size: 1.05rem;"></i>
                                        <span class="fw-bold" style="color: #0f172a; font-size: 0.925rem;">
                                            {{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}
                                        </span>
                                    </div>
                                </td>

                                <!-- ช่วงเวลา ในกรอบ Pill สีขาวมีเส้นขอบ -->
                                <td class="text-nowrap py-3">
                                    <span class="badge bg-white text-secondary border fw-normal px-2 py-1 rounded-pill" style="font-size: 0.8rem; border-color: #e2e8f0 !important;">
                                        <i class="bi bi-clock me-1 text-muted"></i> {{ $booking->time_slot }} น.
                                    </span>
                                </td>

                                <!-- ห้อง STUDY ROOM (ม่วงสำหรับครุศาสตร์ น้ำเงินสำหรับแม่ริม) -->
                                <td class="text-nowrap py-3">
                                    <span class="fw-bold" style="font-size: 0.925rem; {{ $booking->room?->building === 'หอพักครุศาสตร์' ? 'color: #7c3aed;' : 'color: #1e40af;' }}">
                                        {{ $booking->room?->room_name ?? 'N/A' }}
                                    </span>
                                </td>

                                <!-- หอพัก (Pill สีม่วงสำหรับครุศาสตร์ หรือข้อความธรรมดาสำหรับแม่ริม) -->
                                <td class="text-nowrap py-3">
                                    @if($booking->room?->building === 'หอพักครุศาสตร์')
                                        <span class="badge rounded-pill px-2 py-1" style="background-color: #f5f3ff; color: #7c3aed; border: 1px solid #ede9fe; font-size: 0.785rem; font-weight: 500;">
                                            <i class="bi bi-mortarboard-fill me-1"></i> หอพักครุศาสตร์
                                        </span>
                                    @else
                                        <span class="text-secondary" style="font-size: 0.875rem;">{{ $booking->room?->building ?? '-' }}</span>
                                    @endif
                                </td>

                                <!-- จำนวนคน -->
                                <td class="text-nowrap py-3" style="font-size: 0.875rem; color: #475569;">
                                    {{ $booking->participant_count }} คน
                                </td>

                                <!-- วัตถุประสงค์ -->
                                <td class="py-3">
                                    <div class="text-secondary text-truncate" style="max-width: 180px; font-size: 0.85rem;" title="{{ $booking->purpose }}">
                                        {{ $booking->purpose }}
                                    </div>
                                </td>

                                <!-- สถานะการจอง -->
                                <td class="text-nowrap py-3">
                                    @if($booking->status === 'approved')
                                        <span class="badge rounded-pill px-3 py-2 fw-medium d-inline-flex align-items-center gap-1" style="background-color: #d1fae5; color: #047857; font-size: 0.8125rem;">
                                            <i class="bi bi-check-circle-fill"></i> อนุมัติแล้ว
                                        </span>
                                    @elseif($booking->status === 'pending')
                                        <span class="badge rounded-pill px-3 py-2 fw-medium d-inline-flex align-items-center gap-1" style="background-color: #fef3c7; color: #b45309; font-size: 0.8125rem;">
                                            <i class="bi bi-hourglass-split"></i> รอการอนุมัติ
                                        </span>
                                    @elseif($booking->status === 'rejected')
                                        <span class="badge rounded-pill px-3 py-2 fw-medium d-inline-flex align-items-center gap-1" style="background-color: #ffe4e6; color: #be123c; font-size: 0.8125rem;">
                                            <i class="bi bi-x-circle-fill"></i> ไม่อนุมัติ
                                        </span>
                                    @else
                                        <span class="badge rounded-pill px-3 py-2 fw-medium" style="background-color: #f1f5f9; color: #64748b; font-size: 0.8125rem;">
                                            ยกเลิกแล้ว
                                        </span>
                                    @endif
                                </td>

                                <!-- หมายเหตุจากผู้ดูแล -->
                                <td class="py-3">
                                    <div class="small text-secondary" style="max-width: 220px; line-height: 1.45;">
                                        {{ $booking->admin_note ?? '-' }}
                                    </div>
                                </td>

                                <!-- ปุ่มยกเลิก (กรอบแดงพื้นขาวมนโค้ง ตรงตามภาพที่ 2) -->
                                <td class="text-end pe-4 text-nowrap py-3">
                                    @if($booking->status === 'pending' || $booking->status === 'approved')
                                        <form action="{{ route('bookings.cancel', $booking) }}" method="POST" class="d-inline" onsubmit="return confirm('คุณต้องการยกเลิกการจองนี้ใช่หรือไม่?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm d-inline-flex align-items-center justify-content-center fw-medium px-3 py-1" style="border: 1px solid #ef4444; color: #ef4444; background-color: #ffffff; border-radius: 8px; font-size: 0.8125rem; min-height: 32px; transition: all 0.18s ease;">
                                                <i class="bi bi-x-lg me-1" style="font-size: 0.75rem;"></i> ยกเลิก
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-secondary">
                                    <i class="bi bi-inbox fs-1 d-block mb-3 text-secondary opacity-50"></i>
                                    <span class="fw-medium">คุณยังไม่มีประวัติการจองห้อง Study Room</span>
                                    <div class="mt-3">
                                        <a href="{{ route('bookings.create') }}" class="btn btn-sm btn-primary px-3 py-2 fw-semibold shadow-sm">
                                            <i class="bi bi-calendar-plus me-1"></i> เริ่มจองห้องเลย
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
