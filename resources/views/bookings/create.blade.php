@extends('layout')

@section('title', 'จองห้อง Study Room')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center gap-3">
                <div class="rounded-3 p-2 bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i class="bi bi-calendar2-check fs-5"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0 text-dark" style="letter-spacing: -0.2px;">แบบฟอร์มขอใช้บริการห้อง Study Room</h5>
                    <span class="text-muted small">กรอกรายละเอียดเพื่อส่งคำขอจองห้องศึกษาค้นคว้า</span>
                </div>
            </div>

            <div class="card-body p-4">
                <!-- ข้อมูลนักศึกษาผู้ทำการจอง -->
                <div class="bg-light p-3 rounded-3 mb-4 border">
                    <div class="mb-2">
                        <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 fw-semibold">ข้อมูลผู้จอง</span>
                    </div>
                    <div class="row g-2 small text-muted">
                        <div class="col-md-4">
                            <strong>รหัสนักศึกษา:</strong> {{ Auth::user()->student_id ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>ชื่อ-นามสกุล:</strong> {{ Auth::user()->name }}
                        </div>
                        <div class="col-md-4">
                            <strong>ชั้นปี:</strong> {{ Auth::user()->year_level ?? '-' }}
                        </div>
                        <div class="col-md-6">
                            <strong>คณะ:</strong> {{ Auth::user()->faculty ?? '-' }}
                        </div>
                        <div class="col-md-6">
                            <strong>สาขา:</strong> {{ Auth::user()->major ?? '-' }}
                        </div>
                    </div>
                </div>

                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf
                    <!-- ซ่อนจำนวนคนตามความต้องการ ไม่ต้องกรอกความจุ -->
                    <input type="hidden" name="participant_count" value="1">

                    <div class="row g-3">
                        <!-- เลือกห้อง Study Room -->
                        <div class="col-12">
                            <label for="room_id" class="form-label fw-semibold text-dark">
                                เลือกห้อง Study Room <span class="text-danger">*</span>
                            </label>
                            <select name="room_id" id="room_id" class="form-select form-select-lg @error('room_id') is-invalid @enderror" required>
                                <option value="">-- กรุณาเลือกห้องที่ต้องการจอง --</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" 
                                            {{ (old('room_id', $selectedRoomId) == $room->id) ? 'selected' : '' }}>
                                        {{ $room->building }} - {{ $room->room_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('room_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- วันที่ต้องการใช้งาน -->
                        <div class="col-md-6">
                            <label for="booking_date" class="form-label fw-semibold text-dark">
                                วันที่ต้องการเข้าใช้ห้อง <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="booking_date" id="booking_date" 
                                   class="form-control form-control-lg @error('booking_date') is-invalid @enderror" 
                                   min="{{ date('Y-m-d') }}" 
                                   value="{{ old('booking_date', request('date', request('booking_date', request('start_date', date('Y-m-d'))))) }}" required>
                            @error('booking_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- ช่วงเวลา พิมพ์เองได้อิสระ หรือเลือกจากช่วงเวลาแนะนำ -->
                        <div class="col-md-6">
                            <label for="time_slot" class="form-label fw-semibold text-dark">
                                ช่วงเวลาที่ต้องการใช้ห้อง <span class="text-danger">*</span>
                            </label>
                            @php
                                $prefilledTime = request('time_slot');
                                if (!$prefilledTime && request('start_time') && request('end_time')) {
                                    $prefilledTime = request('start_time') . ' - ' . request('end_time');
                                }
                            @endphp
                            <input type="text" name="time_slot" id="time_slot" 
                                   list="timeSlotSuggestions"
                                   class="form-control form-control-lg @error('time_slot') is-invalid @enderror" 
                                   placeholder="08:30 - 10:30" 
                                   value="{{ old('time_slot', $prefilledTime) }}" required>
                            <datalist id="timeSlotSuggestions">
                                @if(isset($timeSlots))
                                    @foreach($timeSlots as $slot)
                                        <option value="{{ $slot }}"></option>
                                    @endforeach
                                @endif
                            </datalist>
                            @error('time_slot')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- วัตถุประสงค์การใช้งาน -->
                        <div class="col-12">
                            <label for="purpose" class="form-label fw-semibold text-dark">
                                วัตถุประสงค์การใช้งานห้อง <span class="text-danger">*</span>
                            </label>
                            <textarea name="purpose" id="purpose" rows="3" 
                                      class="form-control @error('purpose') is-invalid @enderror" required>{{ old('purpose') }}</textarea>
                            @error('purpose')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold px-4 shadow-sm" style="min-height: 48px;">
                            ยืนยันการส่งคำขอจองห้อง
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg" style="min-height: 48px; display: inline-flex; align-items: center;">ย้อนกลับ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
