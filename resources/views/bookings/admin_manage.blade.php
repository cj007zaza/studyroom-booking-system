@extends('layout')

@section('title', 'จัดการคำขอจองห้อง Study Room')

@section('content')
<!-- เมนูด่วนด้านบนสำหรับ Admin ไม่ต้องเลื่อนหา -->
<div class="card border-0 shadow-sm mb-4 bg-white">
    <div class="card-body p-3 p-md-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h4 class="fw-bold mb-1" style="color: var(--color-neutral-heading);">
                    <i class="bi bi-shield-check me-2 text-primary"></i> ศูนย์ควบคุมผู้ดูแลระบบ
                </h4>
                <p class="text-secondary small mb-0">จัดการคำขอจองห้องและข้อมูลห้องพัก</p>
            </div>
            <!-- ปุ่มเมนูหลัก -->
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('rooms.index') }}" class="btn btn-outline-primary fw-semibold">
                    <i class="bi bi-door-closed me-1"></i> จัดการห้อง Study Room
                </a>
                <a href="{{ route('rooms.create') }}" class="btn btn-primary fw-semibold shadow-sm">
                    <i class="bi bi-plus-circle me-1"></i> เพิ่มห้องใหม่
                </a>
            </div>
        </div>
    </div>
</div>

<!-- สรุปตัวเลขคำขอ (Modern Metric Cards) -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 bg-white p-4 rounded-4 shadow-sm h-100 card-hover" style="border: 1px solid rgba(226, 232, 240, 0.8) !important;">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-secondary fw-semibold small">คำขอที่รออนุมัติ</span>
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background-color: #fffbeb; color: #d97706; border: 1px solid #fef3c7;">
                    <i class="bi bi-clock-history fs-5"></i>
                </div>
            </div>
            <div class="d-flex align-items-baseline gap-2">
                <div class="fs-1 fw-bold text-dark" style="letter-spacing: -0.5px; line-height: 1;">{{ $pendingCount }}</div>
                <span class="text-muted small">คำขอ</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 bg-white p-4 rounded-4 shadow-sm h-100 card-hover" style="border: 1px solid rgba(226, 232, 240, 0.8) !important;">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-secondary fw-semibold small">อนุมัติเรียบร้อยแล้ว</span>
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background-color: #ecfdf5; color: #059669; border: 1px solid #d1fae5;">
                    <i class="bi bi-check2-circle fs-5"></i>
                </div>
            </div>
            <div class="d-flex align-items-baseline gap-2">
                <div class="fs-1 fw-bold text-dark" style="letter-spacing: -0.5px; line-height: 1;">{{ $approvedCount }}</div>
                <span class="text-muted small">คำขอ</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 bg-white p-4 rounded-4 shadow-sm h-100 card-hover" style="border: 1px solid rgba(226, 232, 240, 0.8) !important;">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-secondary fw-semibold small">คำขอทั้งหมดในระบบ</span>
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background-color: #eff6ff; color: #2563eb; border: 1px solid #dbeafe;">
                    <i class="bi bi-layers-half fs-5"></i>
                </div>
            </div>
            <div class="d-flex align-items-baseline gap-2">
                <div class="fs-1 fw-bold text-dark" style="letter-spacing: -0.5px; line-height: 1;">{{ $totalCount }}</div>
                <span class="text-muted small">คำขอ</span>
            </div>
        </div>
    </div>
</div>

<!-- แท็บกรองสถานะ -->
<div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
    <div class="btn-group shadow-sm">
        <a href="{{ route('admin.bookings') }}" class="btn btn-sm {{ empty($statusFilter) ? 'btn-primary' : 'btn-outline-primary' }}">
            ทั้งหมด {{ $totalCount }}
        </a>
        <a href="{{ route('admin.bookings', ['status' => 'pending']) }}" class="btn btn-sm {{ $statusFilter == 'pending' ? 'btn-warning text-dark fw-bold' : 'btn-outline-warning text-dark' }}">
            รออนุมัติ {{ $pendingCount }}
        </a>
        <a href="{{ route('admin.bookings', ['status' => 'approved']) }}" class="btn btn-sm {{ $statusFilter == 'approved' ? 'btn-success fw-bold' : 'btn-outline-success' }}">
            อนุมัติแล้ว {{ $approvedCount }}
        </a>
        <a href="{{ route('admin.bookings', ['status' => 'rejected']) }}" class="btn btn-sm {{ $statusFilter == 'rejected' ? 'btn-danger fw-bold' : 'btn-outline-danger' }}">
            ไม่อนุมัติ
        </a>
    </div>
</div>

<!-- ตารางแสดงคำขอจอง สะดวกและสะอาดตา ไม่แสดงความจุคน -->
<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">วันที่ และ ช่วงเวลา</th>
                        <th>ห้องที่ขอจอง</th>
                        <th>ผู้จอง และ คณะ สาขา</th>
                        <th>วัตถุประสงค์</th>
                        <th>สถานะ</th>
                        <th>หมายเหตุ</th>
                        <th class="text-end pe-4">การพิจารณา</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td class="ps-4 text-nowrap">
                                <div class="fw-semibold" style="color: var(--color-neutral-heading);">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}</div>
                                <span class="badge bg-light text-dark border fw-medium px-2 py-1 mt-1">
                                    <i class="bi bi-clock me-1 text-secondary"></i> {{ $booking->time_slot }}
                                </span>
                            </td>
                            <td class="text-nowrap">
                                <div class="fw-bold" style="{{ $booking->room?->building === 'หอพักครุศาสตร์' ? 'color: var(--color-secondary);' : 'color: var(--color-primary);' }}">
                                    {{ $booking->room?->room_name ?? '-' }}
                                </div>
                                <small class="text-secondary">{{ $booking->room?->building ?? '-' }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $booking->user?->name ?? '-' }}</div>
                                <small class="text-secondary d-block">
                                    รหัส {{ $booking->user?->student_id ?? '-' }} ชั้นปี {{ $booking->user?->year_level ?? '-' }}
                                </small>
                                <small class="text-secondary">
                                    {{ $booking->user?->faculty ?? '-' }} - {{ $booking->user?->major ?? '-' }}
                                </small>
                            </td>
                            <td><small class="text-dark">{{ $booking->purpose }}</small></td>
                            <td class="text-nowrap">
                                @if($booking->status === 'pending')
                                    <span class="badge badge-pending">รอการอนุมัติ</span>
                                @elseif($booking->status === 'approved')
                                    <span class="badge badge-approved">อนุมัติแล้ว</span>
                                @elseif($booking->status === 'rejected')
                                    <span class="badge badge-rejected">ไม่อนุมัติ</span>
                                @else
                                    <span class="badge badge-cancelled">ยกเลิกแล้ว</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-secondary">{{ $booking->admin_note ?? '-' }}</small>
                            </td>
                            <td class="text-end pe-4 text-nowrap">
                                @if($booking->status === 'pending')
                                    <div class="d-flex justify-content-end gap-1">
                                        <!-- ปุ่มอนุมัติ 1-Click ทันที สะดวกมาก -->
                                        <form action="{{ route('admin.bookings.status', $booking) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <input type="hidden" name="admin_note" value="อนุมัติเรียบร้อย ให้นักศึกษาเข้าใช้งานได้ตามกำหนด">
                                            <button type="submit" class="btn btn-sm btn-success fw-semibold shadow-sm" onclick="return confirm('ยืนยันอนุมัติคำขอนี้?')">
                                                <i class="bi bi-check-lg me-1"></i> อนุมัติ
                                            </button>
                                        </form>

                                        <!-- ปุ่มไม่อนุมัติ -->
                                        <button type="button" class="btn btn-sm btn-outline-danger fw-medium" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $booking->id }}">
                                            <i class="bi bi-x-lg me-1"></i> ไม่อนุมัติ
                                        </button>
                                    </div>

                                    <!-- Modal ปฏิเสธ -->
                                    <div class="modal fade text-start" id="rejectModal{{ $booking->id }}" tabindex="-1" style="white-space: normal;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow rounded-4 overflow-hidden" style="white-space: normal;">
                                                <form action="{{ route('admin.bookings.status', $booking) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <div class="modal-header bg-danger text-white py-3">
                                                        <h6 class="modal-title fw-bold">ปฏิเสธคำขอจองห้อง</h6>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body p-4 text-start" style="white-space: normal;">
                                                        <div class="bg-light p-3 rounded-3 mb-3 border" style="line-height: 1.6; word-break: break-word;">
                                                            <div class="mb-1">
                                                                <span class="text-secondary small">ห้อง:</span>
                                                                <strong class="text-dark">{{ $booking->room?->room_name }}</strong>
                                                            </div>
                                                            <div>
                                                                <span class="text-secondary small">ผู้จอง:</span>
                                                                <strong class="text-dark">{{ $booking->user?->name }} - รหัส {{ $booking->user?->student_id }}</strong>
                                                            </div>
                                                        </div>
                                                        <div class="mb-1">
                                                            <label class="form-label fw-semibold text-dark small d-flex justify-content-between">
                                                                <span>เหตุผลที่ไม่อนุมัติ</span>
                                                                <span class="text-secondary fw-normal">ไม่บังคับ เว้นว่างได้</span>
                                                            </label>
                                                            <textarea name="admin_note" rows="3" class="form-control" placeholder="ระบุเหตุผล หรือเว้นว่างไว้"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light py-2">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ปิด</button>
                                                        <button type="submit" class="btn btn-danger btn-sm fw-bold">ยืนยันปฏิเสธ</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-primary fw-medium" data-bs-toggle="modal" data-bs-target="#editDecisionModal{{ $booking->id }}">
                                            <i class="bi bi-pencil-square me-1"></i> แก้ไขผล
                                        </button>
                                    </div>

                                    <!-- Modal แก้ไขผลการพิจารณา -->
                                    <div class="modal fade text-start" id="editDecisionModal{{ $booking->id }}" tabindex="-1" aria-labelledby="editDecisionModalLabel{{ $booking->id }}" aria-hidden="true" style="white-space: normal;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow rounded-4 overflow-hidden" style="white-space: normal;">
                                                <form action="{{ route('admin.bookings.status', $booking) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-header bg-primary text-white py-3">
                                                        <h6 class="modal-title fw-bold" id="editDecisionModalLabel{{ $booking->id }}">
                                                            <i class="bi bi-pencil-square me-2"></i> แก้ไขผลการพิจารณาคำขอจอง
                                                        </h6>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <div class="bg-light p-3 rounded-3 mb-3 border">
                                                            <div class="d-flex justify-content-between mb-1">
                                                                <span class="text-secondary small">ห้อง:</span>
                                                                <strong class="text-dark">{{ $booking->room?->room_name }}</strong>
                                                            </div>
                                                            <div class="d-flex justify-content-between mb-1">
                                                                <span class="text-secondary small">ผู้จอง:</span>
                                                                <strong class="text-dark">{{ $booking->user?->name }} - รหัส {{ $booking->user?->student_id }}</strong>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-secondary small">วันที่และเวลา:</span>
                                                                <span class="text-dark fw-medium">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }} | {{ $booking->time_slot }}</span>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold small text-dark">
                                                                <i class="bi bi-toggle-on me-1 text-primary"></i> สถานะการพิจารณา
                                                            </label>
                                                            <select name="status" class="form-select" required>
                                                                <option value="approved" {{ $booking->status === 'approved' ? 'selected' : '' }}>อนุมัติการจองห้อง</option>
                                                                <option value="rejected" {{ $booking->status === 'rejected' ? 'selected' : '' }}>ไม่อนุมัติ - ปฏิเสธคำขอ</option>
                                                                <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>รอการอนุมัติ - รีเซ็ตกลับไปพิจารณาใหม่</option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label class="form-label fw-semibold small text-dark">
                                                                <i class="bi bi-card-text me-1 text-primary"></i> หมายเหตุ หรือ เหตุผลการพิจารณา
                                                            </label>
                                                            <textarea name="admin_note" rows="3" class="form-control" placeholder="ระบุหมายเหตุเพิ่มเติม">{{ $booking->admin_note }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light py-2">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ยกเลิก</button>
                                                        <button type="submit" class="btn btn-primary btn-sm fw-bold">
                                                            <i class="bi bi-save me-1"></i> บันทึกการแก้ไข
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-secondary">
                                ไม่พบรายการคำขอจอง
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
@if($bookings->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $bookings->appends(request()->query())->links() }}
</div>
@endif
@endsection
