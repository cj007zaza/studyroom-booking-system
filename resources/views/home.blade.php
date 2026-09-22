@extends('layout')

@section('title', 'ระบบจองห้อง Study Room มหาวิทยาลัยราชภัฏเชียงใหม่')

@section('styles')
<style>
    /* Modern Calendar Styles */
    .fc {
        font-family: 'Prompt', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
    .fc .fc-toolbar {
        margin-bottom: 1.25rem !important;
        gap: 0.75rem;
    }
    .fc .fc-toolbar-title {
        font-size: 1.3rem !important;
        font-weight: 700 !important;
        color: #0f172a !important;
        letter-spacing: -0.3px;
    }
    .fc-button-group {
        border-radius: var(--radius-md) !important;
        overflow: hidden;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    .fc-button-primary {
        background-color: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        color: #334155 !important;
        font-size: 0.835rem !important;
        font-weight: 600 !important;
        padding: 7px 15px !important;
        min-height: 38px;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
        box-shadow: none !important;
    }
    .fc-button-primary:hover {
        background-color: #f8fafc !important;
        border-color: #cbd5e1 !important;
        color: #0f172a !important;
    }
    .fc-button-primary:disabled {
        background-color: #f8fafc !important;
        border-color: #e2e8f0 !important;
        color: #94a3b8 !important;
        opacity: 0.7 !important;
    }
    .fc-button-primary.fc-button-active,
    .fc-button-primary:active {
        background-color: var(--color-primary) !important;
        border-color: var(--color-primary) !important;
        color: #ffffff !important;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.3) !important;
    }
    .fc .fc-today-button {
        background-color: #f1f5f9 !important;
        border: 1px solid #e2e8f0 !important;
        color: #1e293b !important;
        font-weight: 600 !important;
        border-radius: var(--radius-md) !important;
        margin-left: 6px !important;
    }
    .fc .fc-today-button:hover {
        background-color: #e2e8f0 !important;
        color: #0f172a !important;
    }
    .fc .fc-today-button:disabled {
        background-color: #f8fafc !important;
        color: #94a3b8 !important;
    }
    .fc-theme-standard td, .fc-theme-standard th {
        border-color: #e2e8f0 !important;
    }
    .fc-col-header-cell {
        background-color: #f8fafc !important;
        padding: 10px 0 !important;
        border-color: #e2e8f0 !important;
    }
    .fc-col-header-cell-cushion {
        font-size: 0.825rem !important;
        font-weight: 700 !important;
        color: #64748b !important;
        text-decoration: none !important;
    }
    .fc-daygrid-day-number {
        font-size: 0.85rem !important;
        font-weight: 600 !important;
        color: #475569 !important;
        padding: 6px 8px !important;
        text-decoration: none !important;
    }
    .fc-day-today {
        background-color: rgba(37, 99, 235, 0.04) !important;
    }
    .fc-day-today .fc-daygrid-day-number {
        background: #2563eb !important;
        color: #ffffff !important;
        border-radius: 9999px !important;
        width: 26px !important;
        height: 26px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        margin: 3px !important;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.35) !important;
    }
    .fc-daygrid-day {
        transition: background-color 0.15s ease;
    }
    .fc-daygrid-day:hover {
        background-color: rgba(248, 250, 252, 0.85);
        cursor: pointer;
    }
    .fc-daygrid-day-other .fc-daygrid-day-number {
        color: #94a3b8 !important;
        opacity: 0.6;
    }
    .fc-event {
        cursor: pointer;
        font-size: 0.8rem !important;
        font-weight: 500 !important;
        padding: 4px 8px !important;
        border-radius: 6px !important;
        margin: 2px 3px !important;
        border: none !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.07);
        transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease !important;
    }
    .fc-event:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
        filter: brightness(1.06);
    }
    .fc-event-title {
        font-weight: 600 !important;
        letter-spacing: -0.1px;
    }
    .fc-more-link {
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        color: #2563eb !important;
        background: #eff6ff !important;
        padding: 2px 7px !important;
        border-radius: 4px !important;
        text-decoration: none !important;
        display: inline-block;
        margin: 2px 4px;
        transition: background-color 0.15s ease;
    }
    .fc-more-link:hover {
        background: #dbeafe !important;
        color: #1d4ed8 !important;
    }
    .fc-popover {
        border-radius: var(--radius-lg) !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
        overflow: hidden;
    }
    .fc-popover-header {
        background: #f8fafc !important;
        padding: 8px 12px !important;
        font-weight: 700 !important;
        color: #0f172a !important;
    }
    .room-thumb {
        width: 104px;
        height: 78px;
        object-fit: cover;
        border-radius: var(--radius-md);
        border: 1px solid var(--color-neutral-border);
    }
    .hero-welcome {
        position: relative;
        border-radius: var(--radius-xl);
        overflow: hidden;
        background: #0f172a url('{{ asset('images/hero_welcome_bg.jpg') }}') center 35% / cover no-repeat;
        border: 1px solid rgba(255, 255, 255, 0.15);
        box-shadow: 0 12px 32px -4px rgba(15, 23, 42, 0.25);
    }
    .hero-welcome-overlay {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.62) 0%, rgba(15, 23, 42, 0.82) 100%);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        padding: 4.5rem 1.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }
    .badge-campus {
        background-color: rgba(245, 158, 11, 0.18);
        color: #fef08a;
        border: 1px solid rgba(245, 158, 11, 0.4);
        border-radius: var(--radius-pill);
        font-size: 0.85rem;
    }
    .hero-title-th {
        font-size: 2.6rem;
        font-weight: 700;
        color: #ffffff;
        letter-spacing: -0.3px;
        margin-bottom: 1.25rem;
        min-height: 72px;
        display: inline-flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 0.15rem;
        text-shadow: 0 2px 12px rgba(0, 0, 0, 0.75);
    }
    .text-highlight {
        color: #38bdf8 !important;
        text-shadow: 0 0 20px rgba(56, 189, 248, 0.4);
    }
    .text-campus {
        color: #facc15 !important;
        text-shadow: 0 0 20px rgba(250, 204, 21, 0.4);
    }
    .typing-cursor {
        display: inline-block;
        width: 3px;
        height: 1.15em;
        background-color: #38bdf8;
        margin-left: 4px;
        animation: blinkCursor 0.85s infinite;
        vertical-align: middle;
        box-shadow: 0 0 8px rgba(56, 189, 248, 0.8);
    }
    @keyframes blinkCursor {
        0%, 100% { opacity: 1; }
        50% { opacity: 0; }
    }
    .btn-hero-cta {
        background-color: #3b82f6;
        border-color: #3b82f6;
        color: #ffffff;
        font-weight: 600;
        min-height: 46px;
        display: inline-flex;
        align-items: center;
        border-radius: var(--radius-md);
        transition: all 0.2s var(--ease-standard);
    }
    .btn-hero-cta:hover {
        background-color: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
    }

    /* Mobile Touch Targets */
    @media (max-width: 767.98px) {
        .hero-welcome-overlay {
            padding: 3rem 1rem;
        }
        .hero-title-th {
            font-size: 1.65rem;
            min-height: 56px;
            gap: 0.35rem;
        }
        .fc-toolbar {
            flex-direction: column;
            gap: 8px;
        }
        .fc-button-primary {
            min-height: 44px !important;
            padding: 10px 16px !important;
        }
        .btn-filter-touch {
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding-left: 14px;
            padding-right: 14px;
        }
        .btn-room-action {
            min-height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<!-- ส่วนต้อนรับ (Welcome Hero Section) -->
<div class="hero-welcome mb-4 shadow-sm">
    <div class="hero-welcome-overlay">
        <!-- ป้ายชื่อแคมปัส Booking CMRU -->
        <div class="badge badge-campus px-3 py-1 fw-bold mb-3 d-inline-flex align-items-center gap-2 shadow-sm">
            <img src="{{ asset('images/cmru_logo.png') }}" alt="โลโก้ มรภ.เชียงใหม่" style="height: 20px; width: auto; object-fit: contain;">
            <span>Booking CMRU - Mae Rim Campus</span>
        </div>

        <!-- หัวข้อ: ระบบจองห้อง มหาวิทยาลัยราชภัฏเชียงใหม่ ศูนย์แม่ริม (พิมพ์ออกมาทีละคำ) -->
        <h1 class="hero-title-th mb-3" aria-label="ระบบจองห้อง มหาวิทยาลัยราชภัฏเชียงใหม่ ศูนย์แม่ริม" id="heroHeadline">
            <span class="text-white" id="typeWord1"></span><span id="typeSpace1" class="text-white" style="display: none;">&nbsp;</span><span class="text-highlight" id="typeWord2"></span><span id="typeSpace2" class="text-white" style="display: none;">&nbsp;</span><span class="text-campus" id="typeWord3"></span><span class="typing-cursor" id="heroCursor"></span>
        </h1>

        <p class="text-white-50 mb-4" style="max-width: 65ch; font-size: 1rem; line-height: 1.7;">
            พื้นที่สำหรับการเรียนรู้ ติวสอบ และทำงานกลุ่ม ตรวจสอบตารางการใช้ห้องผ่านปฏิทินด้านล่างได้ทันที
        </p>

        <div>
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.bookings') }}" class="btn btn-hero-cta px-4 shadow-sm">
                        จัดการคำขอจองห้อง
                    </a>
                @else
                    <a href="{{ route('bookings.create') }}" class="btn btn-hero-cta px-4 shadow-sm">
                        จองห้อง Study Room ทันที
                    </a>
                @endif
            @else
                <a href="{{ route('bookings.create') }}" class="btn btn-hero-cta px-4 shadow-sm">
                    จองห้องใช้งาน
                </a>
            @endauth
        </div>
    </div>
</div>

<!-- Layout หลัก: ปฏิทินอยู่ด้านซ้าย ห้องพักอยู่ด้านขวา -->
<div class="row g-4">
    <!-- ฝั่งซ้าย: ปฏิทินการใช้ห้อง Study Room (Calendar View) -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden" style="border: 1px solid rgba(226, 232, 240, 0.8) !important;">
            <div class="card-header bg-white py-3 px-3 px-md-4 border-bottom">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <h5 class="fw-bold mb-0 text-dark" style="letter-spacing: -0.2px;">ปฏิทินการใช้ห้อง Study Room</h5>
                        <span class="text-muted small">คลิกวันที่เพื่อจอง หรือคลิกรายการเพื่อดูรายละเอียด</span>
                    </div>

                    <!-- ฝั่งขวา: สถานะ & ตัวกรองห้อง -->
                    <div class="d-flex flex-wrap align-items-center gap-3 ms-auto">
                        <div class="d-flex align-items-center gap-2 small">
                            <span class="d-inline-flex align-items-center gap-1">
                                <span class="rounded-circle d-inline-block" style="width: 8px; height: 8px; background-color: #2563eb;"></span>
                                <span class="text-secondary fw-medium">อนุมัติแล้ว</span>
                            </span>
                            <span class="d-inline-flex align-items-center gap-1">
                                <span class="rounded-circle d-inline-block" style="width: 8px; height: 8px; background-color: #f59e0b;"></span>
                                <span class="text-secondary fw-medium">รอการอนุมัติ</span>
                            </span>
                        </div>

                        <div class="d-flex align-items-center gap-1">
                            <select id="roomFilter" class="form-select form-select-sm rounded-pill px-3 py-1 shadow-none border-secondary-subtle" aria-label="กรองปฏิทินตามห้อง" style="min-width: 175px; font-size: 0.825rem;">
                                <option value="all">ทุกห้อง (ทั้งหมด)</option>
                                @foreach($allRooms as $r)
                                    <option value="{{ $r->id }}">{{ $r->building }} - {{ $r->room_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-3 p-md-4">
                <div id="calendar" role="region" aria-label="ปฏิทินแสดงตารางการใช้ห้อง Study Room"></div>
            </div>
        </div>
    </div>

    <!-- ฝั่งขวา: รายการห้อง Study Room พร้อมกดจอง -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="fw-bold mb-0" style="color: var(--color-neutral-heading);">
                    ห้อง Study Room
                </h5>
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('home') }}" class="btn btn-filter-touch {{ empty($building) ? 'btn-primary' : 'btn-outline-primary' }}">
                        ทั้งหมด
                    </a>
                    <a href="{{ route('home', ['building' => 'หอพักครุศาสตร์']) }}" class="btn btn-filter-touch {{ $building == 'หอพักครุศาสตร์' ? 'btn-faculty' : 'btn-outline-faculty' }}">
                        หอครุศาสตร์
                    </a>
                    <a href="{{ route('home', ['building' => 'หอพักแม่ริม']) }}" class="btn btn-filter-touch {{ $building == 'หอพักแม่ริม' ? 'btn-primary' : 'btn-outline-primary' }}">
                        หอแม่ริม
                    </a>
                </div>
            </div>

            <div class="card-body p-3 overflow-auto" style="max-height: 680px;">
                <div class="vstack gap-3">
                    @forelse($rooms as $room)
                        <div class="card border rounded-3 p-3 bg-white card-hover">
                            <div class="d-flex gap-3 align-items-start">
                                <!-- รูปห้อง (พร้อม Lazy Loading & Alt) -->
                                @if($room->image)
                                    <img src="{{ str_starts_with($room->image, 'data:') ? $room->image : asset($room->image) }}" 
                                         class="room-thumb shadow-sm" 
                                         alt="รูปห้อง {{ $room->room_name }}" 
                                         loading="lazy" 
                                         decoding="async"
                                         onerror="this.onerror=null; this.src='{{ asset('images/rooms/room_mr1.jpg') }}';">
                                @else
                                    <div class="room-thumb bg-light d-flex align-items-center justify-content-center text-secondary" aria-label="ไม่มีรูปภาพห้อง">
                                        <i class="bi bi-image fs-4 opacity-50"></i>
                                    </div>
                                @endif

                                <!-- ข้อมูลห้อง -->
                                <div class="flex-grow-1 min-w-0">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="fw-bold mb-0 text-truncate" style="{{ $room->building === 'หอพักครุศาสตร์' ? 'color: var(--color-secondary) !important;' : 'color: var(--color-primary);' }}">
                                            {{ $room->room_name }}
                                        </h6>
                                        <span class="badge {{ $room->status === 'available' ? 'badge-approved' : 'badge-cancelled' }} small">
                                            {{ $room->status === 'available' ? 'พร้อมใช้' : 'ปิดปรับปรุง' }}
                                        </span>
                                    </div>
                                    <div class="small mb-1">
                                        @if($room->building === 'หอพักครุศาสตร์')
                                            <span class="badge-faculty-subtle d-inline-block py-0 px-2" style="font-size: 0.8125rem;">
                                                {{ $room->building }}
                                            </span>
                                        @else
                                            <span class="text-secondary">{{ $room->building }}</span>
                                        @endif
                                    </div>
                                    <div class="small text-secondary text-truncate mb-3">
                                        {{ $room->facilities ?? 'แอร์, ไวท์บอร์ด, ปลั๊กไฟ' }}
                                    </div>

                                    @auth
                                        @if(Auth::user()->role === 'admin')
                                            <a href="{{ route('rooms.edit', $room) }}" class="btn btn-sm btn-outline-warning w-100 btn-room-action">
                                                แก้ไขห้อง
                                            </a>
                                        @else
                                            @if($room->status === 'available')
                                                <a href="{{ route('bookings.create', ['room_id' => $room->id]) }}" class="btn btn-sm {{ $room->building === 'หอพักครุศาสตร์' ? 'btn-faculty' : 'btn-primary' }} w-100 fw-medium btn-room-action">
                                                    จองห้องนี้
                                                </a>
                                            @else
                                                <button class="btn btn-sm btn-secondary w-100 btn-room-action" disabled>ปิดปรับปรุง</button>
                                            @endif
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-sm {{ $room->building === 'หอพักครุศาสตร์' ? 'btn-outline-faculty' : 'btn-outline-primary' }} w-100 btn-room-action">
                                            เข้าสู่ระบบเพื่อจอง
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-secondary">
                            ไม่พบข้อมูลห้อง
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal แสดงรายละเอียดการจองเมื่อคลิกรายการบนปฏิทิน -->
<div class="modal fade" id="bookingDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header text-white py-3" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);">
                <h6 class="modal-title fw-bold" id="modalTitle">
                    ข้อมูลการจองห้อง
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span id="modalBuilding" class="badge bg-light text-dark border px-3 py-2"></span>
                    <span id="modalStatus" class="badge px-3 py-2"></span>
                </div>
                <h4 id="modalRoomName" class="fw-bold mb-3" style="color: var(--color-primary);"></h4>

                <div class="list-group list-group-flush border-top border-bottom mb-3 small">
                    <div class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-secondary">วันที่:</span>
                        <strong id="modalDate" class="text-dark"></strong>
                    </div>
                    <div class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-secondary">ช่วงเวลา:</span>
                        <strong id="modalTimeSlot" class="text-dark"></strong>
                    </div>
                    <div class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-secondary">ผู้จอง:</span>
                        <strong id="modalUserName" class="text-dark"></strong>
                    </div>
                    <div class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-secondary">รหัสนักศึกษา:</span>
                        <strong id="modalStudentId" class="text-dark"></strong>
                    </div>
                    <div class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-secondary">คณะ และ สาขา:</span>
                        <strong id="modalFacultyMajor" class="text-dark"></strong>
                    </div>
                </div>

                <div class="bg-light p-3 rounded-3 border">
                    <div class="text-secondary small fw-bold mb-1">
                        วัตถุประสงค์:
                    </div>
                    <div id="modalPurpose" class="text-dark small"></div>
                </div>
            </div>
            <div class="modal-footer bg-light py-2 border-top">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ปิด</button>
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('admin.bookings') }}" class="btn btn-primary btn-sm fw-bold">
                        จัดการคำขอจองห้อง
                    </a>
                @else
                    <a id="modalBookBtn" href="{{ route('bookings.create') }}" class="btn btn-primary btn-sm fw-bold">
                        จองห้องนี้ช่วงอื่น
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- FullCalendar JS CDN และ ภาษาไทย -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/locales/th.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rawEvents = @json($calendarEvents);
        const calendarEl = document.getElementById('calendar');
        const roomFilter = document.getElementById('roomFilter');
        const detailModal = new bootstrap.Modal(document.getElementById('bookingDetailModal'));

        const calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'th',
            initialView: 'dayGridMonth',
            dayMaxEvents: 3,
            fixedWeekCount: false,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listMonth'
            },
            buttonText: {
                today: 'วันนี้',
                month: 'เดือน',
                week: 'สัปดาห์',
                list: 'รายการ'
            },
            events: rawEvents,
            eventClick: function(info) {
                const props = info.event.extendedProps;
                document.getElementById('modalRoomName').textContent = props.room_name;
                document.getElementById('modalBuilding').textContent = props.building;
                document.getElementById('modalDate').textContent = props.booking_date;
                document.getElementById('modalTimeSlot').textContent = props.time_slot;
                document.getElementById('modalUserName').textContent = props.user_name;
                document.getElementById('modalStudentId').textContent = props.student_id;
                document.getElementById('modalFacultyMajor').textContent = props.faculty + (props.major !== '-' ? ' - ' + props.major : '');
                document.getElementById('modalPurpose').textContent = props.purpose;

                const statusEl = document.getElementById('modalStatus');
                statusEl.className = 'badge px-3 py-2 ' + props.status_badge;
                statusEl.textContent = props.status_label;

                const bookBtn = document.getElementById('modalBookBtn');
                if (bookBtn) {
                    bookBtn.href = "{{ route('bookings.create') }}?room_id=" + props.roomId;
                }

                detailModal.show();
            },
            @if(Auth::check() && Auth::user()->role === 'admin')
            // แอดมินคลิกวันที่บนปฏิทิน ไม่เปิดหน้าจองห้อง
            @else
            dateClick: function(info) {
                window.location.href = "{{ route('bookings.create') }}?date=" + info.dateStr;
            }
            @endif
        });

        calendar.render();

        roomFilter.addEventListener('change', function() {
            const selectedRoomId = this.value;
            calendar.removeAllEvents();
            if (selectedRoomId === 'all') {
                calendar.addEventSource(rawEvents);
            } else {
                const filtered = rawEvents.filter(ev => ev.roomId === selectedRoomId);
                calendar.addEventSource(filtered);
            }
        });

        // ฟังก์ชันพิมพ์ข้อความทีละคำ (Typewriter Animation)
        const typeEl1 = document.getElementById('typeWord1');
        const typeEl2 = document.getElementById('typeWord2');
        const typeEl3 = document.getElementById('typeWord3');
        const spaceEl1 = document.getElementById('typeSpace1');
        const spaceEl2 = document.getElementById('typeSpace2');

        if (typeEl1 && typeEl2 && typeEl3) {
            const segmenter = (typeof Intl !== 'undefined' && Intl.Segmenter)
                ? new Intl.Segmenter('th', { granularity: 'grapheme' })
                : null;

            function getGraphemes(text) {
                if (segmenter) {
                    return Array.from(segmenter.segment(text), s => s.segment);
                }
                return Array.from(text);
            }

            const word1 = getGraphemes('ระบบจองห้อง');
            const word2 = getGraphemes('มหาวิทยาลัยราชภัฏเชียงใหม่');
            const word3 = getGraphemes('ศูนย์แม่ริม');

            const sleep = ms => new Promise(resolve => setTimeout(resolve, ms));

            async function typeGraphemes(element, graphemes, minDelay = 50, maxDelay = 75) {
                for (let i = 0; i < graphemes.length; i++) {
                    element.textContent += graphemes[i];
                    const delay = Math.floor(Math.random() * (maxDelay - minDelay + 1)) + minDelay;
                    await sleep(delay);
                }
            }

            async function backspaceGraphemes(element, graphemes, delay = 22) {
                for (let i = graphemes.length; i > 0; i--) {
                    element.textContent = graphemes.slice(0, i - 1).join('');
                    await sleep(delay);
                }
            }

            async function runTypewriterLoop() {
                while (true) {
                    // ล้างค่าเริ่มต้น
                    typeEl1.textContent = '';
                    typeEl2.textContent = '';
                    typeEl3.textContent = '';
                    if (spaceEl1) spaceEl1.style.display = 'none';
                    if (spaceEl2) spaceEl2.style.display = 'none';

                    await sleep(400);

                    // พิมพ์คำที่ 1: ระบบจองห้อง
                    await typeGraphemes(typeEl1, word1, 55, 75);
                    if (spaceEl1) spaceEl1.style.display = 'inline';
                    await sleep(250);

                    // พิมพ์คำที่ 2: มหาวิทยาลัยราชภัฏเชียงใหม่
                    await typeGraphemes(typeEl2, word2, 45, 65);
                    if (spaceEl2) spaceEl2.style.display = 'inline';
                    await sleep(250);

                    // พิมพ์คำที่ 3: ศูนย์แม่ริม
                    await typeGraphemes(typeEl3, word3, 55, 75);

                    // แสดงค้างไว้ให้อ่าน 4 วินาที
                    await sleep(4000);

                    // ลบข้อความย้อนกลับอย่างนุ่มนวล
                    await backspaceGraphemes(typeEl3, word3, 20);
                    if (spaceEl2) spaceEl2.style.display = 'none';
                    await sleep(120);

                    await backspaceGraphemes(typeEl2, word2, 16);
                    if (spaceEl1) spaceEl1.style.display = 'none';
                    await sleep(120);

                    await backspaceGraphemes(typeEl1, word1, 20);
                    await sleep(500);
                }
            }

            runTypewriterLoop();
        }
    });
</script>
@endsection
