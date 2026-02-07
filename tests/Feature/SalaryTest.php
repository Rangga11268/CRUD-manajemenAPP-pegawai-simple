<?php

namespace Tests\Feature;

use App\Models\Pegawai;
use App\Models\Salary;
use App\Models\User;
use App\Models\Department;
use App\Models\Jabatan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalaryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        $this->seed(\Database\Seeders\DepartmentSeeder::class);
        $this->seed(\Database\Seeders\JabatanSeeder::class);
    }

    public function test_hr_can_generate_payroll()
    {
        $hr = User::factory()->create(['role' => 'hr']);
        $hr->assignRole('hr');

        $dept = Department::first();
        $jabatan = Jabatan::first();
        if (!$jabatan->deskripsi_jabatan) $jabatan->update(['deskripsi_jabatan' => 'Test Desc']);

        $pegawai = Pegawai::create([
            'user_id' => User::factory()->create()->id,
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

        $response = $this->actingAs($hr)->post(route('salary.store'), [
            'pegawai_id' => $pegawai->id,
            'periode' => '2026-02',
            'tunjangan' => [
                ['nama' => 'Makan', 'jumlah' => 500000],
            ],
            'potongan' => [
                ['nama' => 'BPJS', 'jumlah' => 100000],
            ],
        ]);

        $response->assertRedirect(route('salary.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('salaries', [
            'pegawai_id' => $pegawai->id,
            'periode' => '2026-02',
            'gaji_pokok' => 5000000,
            'gaji_bersih' => 5400000, // 5000000 + 500000 - 100000
        ]);

        $this->assertDatabaseHas('salary_components', [
            'nama' => 'Makan',
            'type' => 'tunjangan',
            'jumlah' => 500000,
        ]);
    }

    public function test_pegawai_can_view_own_salary()
    {
        $user = User::factory()->create(['role' => 'pegawai']);
        $user->assignRole('pegawai');

        $dept = Department::first();
        $jabatan = Jabatan::first();
        if (!$jabatan->deskripsi_jabatan) $jabatan->update(['deskripsi_jabatan' => 'Test Desc']);

        $pegawai = Pegawai::create([
            'user_id' => $user->id,
            'department_id' => $dept->id,
            'jabatan_id' => $jabatan->id,
            'nama_pegawai' => 'Info Pegawai',
            'nik' => '1234567890123456',
            'employee_id' => 'EMP002',
            'gender' => 'L',
            'tanggal_lahir' => '1990-01-01',
            'alamat' => 'Test Address',
            'telepon' => '08123456789',
            'email' => 'info@example.com',
            'tanggal_masuk' => '2023-01-01',
            'status' => 'aktif',
            'gaji_pokok' => 4500000,
            'image' => 'default.png',
        ]);

        $salary = Salary::create([
            'pegawai_id' => $pegawai->id,
            'periode' => '2026-02',
            'gaji_pokok' => 4500000,
            'gaji_bersih' => 4500000,
            'status' => 'paid',
            'tanggal_bayar' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('salary.index'));
        $response->assertStatus(200);
        $response->assertSee('Gaji Bersih'); // Verify table header exists

        $responseSlip = $this->actingAs($user)->get(route('salary.show', $salary));
        $responseSlip->assertStatus(200);
    }
}
