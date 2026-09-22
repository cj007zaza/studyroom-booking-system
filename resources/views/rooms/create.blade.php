@extends('layout')

@section('title', 'เพิ่มห้อง Study Room ใหม่')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0" style="color: var(--color-neutral-heading);">
                    <i class="bi bi-plus-circle me-2 text-primary"></i> เพิ่มห้อง Study Room ใหม่
                </h5>
                <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary btn-sm" style="border-radius: var(--radius-md);">
                    <i class="bi bi-arrow-left me-1"></i> ย้อนกลับ
                </a>
            </div>

            <div class="card-body p-4 p-md-5">
                <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="capacity" value="6">

                    <div class="mb-3">
                        <label for="building" class="form-label fw-semibold text-dark">
                            หอพัก <span class="text-danger">*</span>
                        </label>
                        <select name="building" id="building" class="form-select @error('building') is-invalid @enderror" required>
                            <option value="">-- เลือกหอพัก --</option>
                            <option value="หอพักครุศาสตร์" {{ old('building') == 'หอพักครุศาสตร์' ? 'selected' : '' }}>หอพักครุศาสตร์</option>
                            <option value="หอพักแม่ริม" {{ old('building') == 'หอพักแม่ริม' ? 'selected' : '' }}>หอพักแม่ริม</option>
                        </select>
                        @error('building')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="room_name" class="form-label fw-semibold text-dark">
                            ชื่อห้อง Study Room <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="room_name" id="room_name" 
                               class="form-control @error('room_name') is-invalid @enderror" 
                               value="{{ old('room_name') }}" required>
                        @error('room_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">สถานะห้อง <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3 pt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status_avail" value="available" checked>
                                <label class="form-check-label text-success fw-semibold" for="status_avail">พร้อมใช้งาน</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status_maint" value="maintenance">
                                <label class="form-check-label text-secondary fw-semibold" for="status_maint">ปิดปรับปรุง</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="facilities" class="form-label fw-semibold text-dark">สิ่งอำนวยความสะดวกภายในห้อง</label>
                        <textarea name="facilities" id="facilities" rows="2" 
                                  class="form-control @error('facilities') is-invalid @enderror">{{ old('facilities') }}</textarea>
                        @error('facilities')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="image" class="form-label fw-semibold text-dark">รูปภาพห้อง Study Room</label>
                        <input type="file" name="image" id="image" 
                               class="form-control @error('image') is-invalid @enderror" 
                               accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 pt-3 border-top">
                        <button type="submit" class="btn btn-primary fw-semibold px-4 shadow-sm" style="min-height: 44px;">
                            <i class="bi bi-save me-1"></i> บันทึกข้อมูลห้อง
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
    if (file && file.size > 10 * 1024 * 1024) { // > 10MB
        alert('รูปภาพมีขนาดใหญ่เกินไป (' + (file.size / (1024 * 1024)).toFixed(2) + ' MB)\nกรุณาเลือกรูปภาพที่มีขนาดไม่เกิน 10 MB ครับ');
        this.value = ''; // Reset file input
    }
});
</script>
@endsection
