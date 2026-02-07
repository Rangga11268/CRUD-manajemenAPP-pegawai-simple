<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        $this->seed(\Database\Seeders\DepartmentSeeder::class);
        $this->seed(\Database\Seeders\JabatanSeeder::class);
    }

    public function test_pegawai_can_view_attendance_page()
    {
        $user = User::factory()->create(['role' => 'pegawai']);
        $user->assignRole('pegawai');
        
        $dept = Department::first();
        $jabatan = Jabatan::first();

        // Ensure Jabatan has deskripsi_jabatan as per migration
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
        
        $response = $this->actingAs($user)->get(route('attendance.index'));
        $response->assertStatus(200);
    }

    public function test_pegawai_can_clock_in()
    {
        // Setup User & Pegawai
        $user = User::factory()->create(['role' => 'pegawai']);
        $user->assignRole('pegawai');
        
        $dept = Department::first();
        $jabatan = Jabatan::first();

        // Ensure Jabatan has deskripsi_jabatan as per migration
        if (!$jabatan->deskripsi_jabatan) {
            $jabatan->update(['deskripsi_jabatan' => 'Test Desc']);
        }
        
        $pegawai = Pegawai::create([
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

        $response = $this->actingAs($user)->post(route('attendance.clock-in'));
        
        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('attendances', [
            'pegawai_id' => $pegawai->id,
            'tanggal' => date('Y-m-d'),
            'status' => 'hadir',
        ]);
    }

    public function test_pegawai_cannot_clock_in_twice()
    {
        // Setup User & Pegawai
        $user = User::factory()->create(['role' => 'pegawai']);
        $user->assignRole('pegawai');
        
        $dept = Department::first();
        $jabatan = Jabatan::first();
        
        $pegawai = Pegawai::create([
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

        // First Clock In
        $this->actingAs($user)->post(route('attendance.clock-in'));

        // Second Clock In
        $response = $this->actingAs($user)->post(route('attendance.clock-in'));
        
        $response->assertSessionHas('error');
    }

    public function test_pegawai_can_clock_out()
    {
        // Setup User & Pegawai
        $user = User::factory()->create(['role' => 'pegawai']);
        $user->assignRole('pegawai');
        
        $dept = Department::first();
        $jabatan = Jabatan::first();
        
        $pegawai = Pegawai::create([
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

        // Clock In first
        $this->actingAs($user)->post(route('attendance.clock-in'));

        // Clock Out
        $response = $this->actingAs($user)->post(route('attendance.clock-out'));
        
        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('attendances', [
            'pegawai_id' => $pegawai->id,
            'tanggal' => date('Y-m-d'),
        ]);
        
        $attendance = Attendance::where('pegawai_id', $pegawai->id)->first();
        $this->assertNotNull($attendance->clock_out);
    }
}
