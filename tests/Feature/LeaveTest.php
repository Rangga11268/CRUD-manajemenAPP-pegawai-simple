<?php

namespace Tests\Feature;

use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Pegawai;
use App\Models\User;
use App\Models\Department;
use App\Models\Jabatan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeaveTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        $this->seed(\Database\Seeders\DepartmentSeeder::class);
        $this->seed(\Database\Seeders\JabatanSeeder::class);
        $this->seed(\Database\Seeders\LeaveTypeSeeder::class);
    }

    public function test_pegawai_can_create_leave_request()
    {
        $user = User::factory()->create(['role' => 'pegawai']);
        $user->assignRole('pegawai');
        
        $dept = Department::first();
        $jabatan = Jabatan::first();
        
        // Ensure Jabatan has deskripsi_jabatan
        if (!$jabatan->deskripsi_jabatan) {
            $jabatan->update(['deskripsi_jabatan' => 'Test Desc']);
        }
        
        Pegawai::create([
            'user_id' => $user->id,
            'department_id' => $dept->id,
            'jabatan_id' => $jabatan->id,
            'nama_pegawai' => 'Test Pegawai',
            'nik' => '1234567890123456',
            'employee_id' => 'EMP001',
            'gender' => 'L',
            'tanggal_lahir' => '1990-01-01',
            'alamat' => 'Test Address',
            'telepon' => '08123456789',
            'email' => 'test@example.com',
            'tanggal_masuk' => '2023-01-01',
            'status' => 'aktif',
            'gaji_pokok' => 5000000,
            'image' => 'default.png',
        ]);

        $leaveType = LeaveType::first();

        $response = $this->actingAs($user)->post(route('leave.store'), [
            'leave_type_id' => $leaveType->id,
            'start_date' => date('Y-m-d', strtotime('+1 day')),
            'end_date' => date('Y-m-d', strtotime('+3 days')),
            'alasan' => 'Liburan',
        ]);

        $response->assertRedirect(route('leave.index'));
        $this->assertDatabaseHas('leaves', [
            'pegawai_id' => $user->pegawai->id,
            'status' => 'pending',
            'days_count' => 3,
        ]);
    }

    public function test_hr_can_approve_leave_request()
    {
        // 1. Setup Pegawai (Requester)
        $userPegawai = User::factory()->create(['role' => 'pegawai']);
        $userPegawai->assignRole('pegawai');
        
        $dept = Department::first();
        $jabatan = Jabatan::first();
        if (!$jabatan->deskripsi_jabatan) $jabatan->update(['deskripsi_jabatan' => 'Test Desc']);

        $pegawai = Pegawai::create([
            'user_id' => $userPegawai->id,
            'department_id' => $dept->id,
            'jabatan_id' => $jabatan->id,
            'nama_pegawai' => 'Test Pegawai',
            'nik' => '1234567890123456',
            'employee_id' => 'EMP001',
            'gender' => 'L',
            'tanggal_lahir' => '1990-01-01',
            'alamat' => 'Test Address',
            'telepon' => '08123456789',
            'email' => 'pegawai@example.com',
            'tanggal_masuk' => '2023-01-01',
            'status' => 'aktif',
            'gaji_pokok' => 5000000,
            'image' => 'default.png',
        ]);

        $leaveType = LeaveType::first();
        $leave = Leave::create([
            'pegawai_id' => $pegawai->id,
            'leave_type_id' => $leaveType->id,
            'start_date' => date('Y-m-d', strtotime('+1 day')),
            'end_date' => date('Y-m-d', strtotime('+3 days')),
            'days_count' => 3,
            'alasan' => 'Sakit',
            'status' => 'pending',
        ]);

        // 2. Setup HR (Approver)
        $userHR = User::factory()->create(['role' => 'hr']);
        $userHR->assignRole('hr');

        $response = $this->actingAs($userHR)->post(route('leave.approve', $leave));

        $response->assertRedirect();
        $this->assertDatabaseHas('leaves', [
            'id' => $leave->id,
            'status' => 'approved',
            'approved_by' => $userHR->id,
        ]);
    }
}
