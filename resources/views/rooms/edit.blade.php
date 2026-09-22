@extends('layout')

@section('title', 'แก้ไขข้อมูลห้อง ' . $room->room_name)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0" style="color: var(--color-neutral-heading);">
                    <i class="bi bi-pencil-square me-2 text-primary"></i> แก้ไขข้อมูลห้อง: {{ $room->room_name }}
                </h5>
                <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary btn-sm" style="border-radius: var(--radius-md);">
                    <i class="bi bi-arrow-left me-1"></i> ย้อนกลับ
                </a>
            </div>

            <div class="card-body p-4 p-md-5">
                <form action="{{ route('rooms.update', $room) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="capacity" value="{{ $room->capacity }}">

                    <div class="mb-3">
                        <label for="building" class="form-label fw-semibold text-dark">หอพัก <span class="text-danger">*</span></label>
                        <select name="building" id="building" class="form-select @error('building') is-invalid @enderror" required>
                            <option value="หอพักครุศาสตร์" {{ old('building', $room->building) == 'หอพักครุศาสตร์' ? 'selected' : '' }}>หอพักครุศาสตร์</option>
                            <option value="หอพักแม่ริม" {{ old('building', $room->building) == 'หอพักแม่ริม' ? 'selected' : '' }}>หอพักแม่ริม</option>
                        </select>
                        @error('building')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="room_name" class="form-label fw-semibold text-dark">ชื่อห้อง <span class="text-danger">*</span></label>
                        <input type="text" name="room_name" id="room_name" 
                               class="form-control @error('room_name') is-invalid @enderror" 
                               value="{{ old('room_name', $room->room_name) }}" required>
                        @error('room_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">สถานะห้อง <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3 pt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status_avail" value="available" 
                                       {{ old('status', $room->status) == 'available' ? 'checked' : '' }}>
                                <label class="form-check-label text-success fw-semibold" for="status_avail">พร้อมใช้งาน</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status_maint" value="maintenance" 
                                       {{ old('status', $room->status) == 'maintenance' ? 'checked' : '' }}>
                                <label class="form-check-label text-secondary fw-semibold" for="status_maint">ปิดปรับปรุง</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="facilities" class="form-label fw-semibold text-dark">สิ่งอำนวยความสะดวกภายในห้อง</label>
                        <textarea name="facilities" id="facilities" rows="2" 
                                  class="form-control @error('facilities') is-invalid @enderror">{{ old('facilities', $room->facilities) }}</textarea>
                        @error('facilities')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark">รูปภาพห้อง Study Room</label>
                        @if($room->image)
                            <div class="mb-2">
                                <span class="text-secondary small d-block mb-1">รูปภาพปัจจุบัน:</span>
                                <img src="{{ asset($room->image) }}" alt="{{ $room->room_name }}" width="140" height="95" class="rounded-3 object-fit-cover border shadow-sm">
                            </div>
                        @endif
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 pt-3 border-top">
                        <button type="submit" class="btn btn-warning fw-semibold px-4 shadow-sm" style="min-height: 44px; color: #0f172a;">
                            <i class="bi bi-check-lg me-1"></i> บันทึกการเปลี่ยนแปลง
                        </button>
                        <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary" style="min-height: 44px; display: inline-flex; align-items: center;">ยกเลิก</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('image')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file && file.size > 2 * 1024 * 1024) { // > 2MB
        alert('รูปภาพมีขนาดใหญ่เกินไป (' + (file.size / (1024 * 1024)).toFixed(2) + ' MB)\nกรุณาเลือกรูปภาพที่มีขนาดไม่เกิน 2 MB หรือย่อขนาดรูปก่อนอัปโหลดครับ');
        this.value = ''; // Reset file input
    }
});
</script>
@endsection
