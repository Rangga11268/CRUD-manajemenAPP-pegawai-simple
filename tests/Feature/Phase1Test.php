<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class Phase1Test extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        $this->seed(\Database\Seeders\DepartmentSeeder::class);
    }

    public function test_admin_can_crud_department()
    {
        $admin = User::factory()->create(['name' => 'Admin', 'email' => 'admin@test.com', 'role' => 'admin']);
        $admin->assignRole('admin');

        $this->actingAs($admin);

        // CREATE
        $response = $this->post(route('department.store'), [
            'name' => 'New Dept',
            'code' => 'ND',
            'description' => 'New Department Description',
            'is_active' => '1',
        ]);
        $response->assertRedirect(route('department.index'));
        $this->assertDatabaseHas('departments', ['code' => 'ND']);

        // READ
        $dept = Department::where('code', 'ND')->first();
        $response = $this->get(route('department.index'));
        $response->assertSee('New Dept');

        // UPDATE
        $response = $this->put(route('department.update', $dept->id), [
            'name' => 'Updated Dept',
            'code' => 'ND', // Keep code same
            'description' => 'Updated Description',
            'is_active' => '1',
        ]);
        $response->assertRedirect(route('department.index'));
        $this->assertDatabaseHas('departments', ['name' => 'Updated Dept']);

        // DELETE
        $response = $this->delete(route('department.destroy', $dept->id));
        $response->assertRedirect(route('department.index'));
        $this->assertDatabaseMissing('departments', ['id' => $dept->id]);
    }

    public function test_pegawai_cannot_create_department()
    {
        $user = User::factory()->create(['name' => 'User', 'email' => 'user@test.com', 'role' => 'pegawai']);
        $user->assignRole('pegawai');

        $this->actingAs($user);

        $response = $this->post(route('department.store'), [
            'name' => 'Illegal Dept',
            'code' => 'ID',
        ]);

        $response->assertStatus(403); // Forbidden
    }

    public function test_admin_can_create_pegawai_with_new_fields()
    {
        $admin = User::factory()->create(['name' => 'Admin', 'email' => 'admin@test.com', 'role' => 'admin']);
        $admin->assignRole('admin');

        $jabatan = Jabatan::create([
            'nama_jabatan' => 'Staff', 
            'gaji_pokok' => 5000000, 
            'tunjangan' => 500000,
            'deskripsi_jabatan' => 'Staff Description'
        ]);
        $dept = Department::first();

        $this->actingAs($admin);

        $response = $this->post(route('pegawai.store'), [
            'nama_pegawai' => 'John Doe',
            'nik' => '1234567890123456',
            'employee_id' => 'EMP001',
            'email' => 'johndoe@example.com',
            'gender' => 'L',
            'tanggal_lahir' => '1990-01-01',
            'tanggal_masuk' => '2023-01-01',
            'alamat' => 'Jl. Test No. 1',
            'telepon' => '08123456789',
            'jabatan_id' => $jabatan->id,
            'department_id' => $dept->id,
            'gaji_pokok' => 6000000,
            'status' => 'aktif',
        ]);

        $response->assertRedirect(route('pegawai.index'));
        $this->assertDatabaseHas('pegawais', [
            'nama_pegawai' => 'John Doe',
            'nik' => '1234567890123456',
            'email' => 'johndoe@example.com',
            'department_id' => $dept->id,
        ]);
    }
}
