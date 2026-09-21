<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. บัญชีผู้ดูแลระบบ (Admin)
        \App\Models\User::firstOrCreate(
            ['student_id' => 'admin'],
            [
                'name' => 'ผู้ดูแลระบบ (Admin)',
                'email' => 'admin@studyroom.ac.th',
                'password' => \Illuminate\Support\Facades\Hash::make('admin1234'),
                'faculty' => 'กองพัฒนานักศึกษา',
                'major' => 'งานบริการหอพัก',
                'year_level' => '-',
                'phone' => '053-885555',
                'role' => 'admin',
            ]
        );

        // 2. บัญชีนักศึกษาตัวอย่างสำหรับทดสอบระบบ
        \App\Models\User::firstOrCreate(
            ['student_id' => '67123456'],
            [
                'name' => 'นายสมชาย รักเรียน',
                'email' => 'somchai@cmru.ac.th',
                'password' => \Illuminate\Support\Facades\Hash::make('123456'),
                'faculty' => 'คณะวิทยาศาสตร์และเทคโนโลยี',
                'major' => 'วิทยาการคอมพิวเตอร์',
                'year_level' => 'ปี 2',
                'phone' => '089-1234567',
                'role' => 'student',
            ]
        );

        // 3. ข้อมูลห้อง Study Room ทั้ง 9 ห้อง (ตามเอกสารระบบจองห้อง study room.docx)
        $rooms = [
            // Study room หอพักครุศาสตร์ (3 ห้อง)
            [
                'building' => 'หอพักครุศาสตร์',
                'room_name' => 'ครุศาสตร์ 1',
                'capacity' => 6,
                'facilities' => 'แอร์, กระดานไวท์บอร์ด, ปลั๊กไฟ 6 ช่อง, จอ Smart TV',
                'image' => 'images/rooms/room_kru1.jpg',
                'status' => 'available',
            ],
            [
                'building' => 'หอพักครุศาสตร์',
                'room_name' => 'ครุศาสตร์ 2',
                'capacity' => 4,
                'facilities' => 'แอร์, กระดานไวท์บอร์ด, ปลั๊กไฟ 4 ช่อง, โต๊ะประชุมกลุ่ม',
                'image' => 'images/rooms/room_kru2.jpg',
                'status' => 'available',
            ],
            [
                'building' => 'หอพักครุศาสตร์',
                'room_name' => 'ครุศาสตร์ 3',
                'capacity' => 8,
                'facilities' => 'แอร์, โปรเจกเตอร์, ไวท์บอร์ด, ปลั๊กไฟ 8 ช่อง',
                'image' => 'images/rooms/room_kru3.jpg',
                'status' => 'available',
            ],
            // Study room หอพักแม่ริม (6 ห้อง)
            [
                'building' => 'หอพักแม่ริม',
                'room_name' => 'หอแม่ริม 1',
                'capacity' => 6,
                'facilities' => 'แอร์, ไวท์บอร์ด, จอ LED, ปลั๊กไฟ 6 ช่อง',
                'image' => 'images/rooms/room_mr1.jpg',
                'status' => 'available',
            ],
            [
                'building' => 'หอพักแม่ริม',
                'room_name' => 'หอแม่ริม 2',
                'capacity' => 6,
                'facilities' => 'แอร์, ไวท์บอร์ด, ปลั๊กไฟ 6 ช่อง, Wi-Fi ความเร็วสูง',
                'image' => 'images/rooms/room_mr2.jpg',
                'status' => 'available',
            ],
            [
                'building' => 'หอพักแม่ริม',
                'room_name' => 'หอแม่ริม 3',
                'capacity' => 4,
                'facilities' => 'แอร์, โต๊ะอ่านหนังสือแยกเดี่ยวและกลุ่ม, ไวท์บอร์ด',
                'image' => 'images/rooms/room_mr3.jpg',
                'status' => 'available',
            ],
            [
                'building' => 'หอพักแม่ริม',
                'room_name' => 'หอแม่ริม 4',
                'capacity' => 8,
                'facilities' => 'แอร์, โปรเจกเตอร์, จอโปรเจกเตอร์, ไวท์บอร์ด',
                'image' => 'images/rooms/room_mr4.jpg',
                'status' => 'available',
            ],
            [
                'building' => 'หอพักแม่ริม',
                'room_name' => 'หอแม่ริม 5',
                'capacity' => 6,
                'facilities' => 'แอร์, ไวท์บอร์ด, ปลั๊กไฟ 6 ช่อง, โซฟาพักผ่อน',
                'image' => 'images/rooms/room_mr5.jpg',
                'status' => 'available',
            ],
            [
                'building' => 'หอพักแม่ริม',
                'room_name' => 'หอแม่ริม 6',
                'capacity' => 10,
                'facilities' => 'ห้องใหญ่, แอร์ 2 ตัว, โปรเจกเตอร์, ไวท์บอร์ดกระจก',
                'image' => 'images/rooms/room_mr6.jpg',
                'status' => 'available',
            ],
        ];

        foreach ($rooms as $room) {
            \App\Models\Room::firstOrCreate(
                ['room_name' => $room['room_name']],
                $room
            );
        }
    }
}
