<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Attendance;
use App\Models\Pegawai;
use App\Models\Department;
use App\Models\Jabatan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PegawaiExport;
use App\Exports\AttendanceExport;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        $this->seed(\Database\Seeders\DepartmentSeeder::class);
        $this->seed(\Database\Seeders\JabatanSeeder::class);
    }

    public function test_hr_can_view_reports_page()
    {
        $hr = User::factory()->create(['role' => 'hr']);
        $hr->assignRole('hr');

        $response = $this->actingAs($hr)->get(route('reports.index'));
        $response->assertStatus(200);
        $response->assertSee('Analytics & Reports');
    }

    public function test_driver_cannot_view_reports_page()
    {
        $user = User::factory()->create(['role' => 'pegawai']);
        $user->assignRole('pegawai');

        $response = $this->actingAs($user)->get(route('reports.index'));
        $response->assertStatus(403);
    }

    public function test_hr_can_export_pegawai()
    {
        Excel::fake();

        $hr = User::factory()->create(['role' => 'hr']);
        $hr->assignRole('hr');

        $response = $this->actingAs($hr)->get(route('reports.export.pegawai'));
        $response->assertStatus(200);

        Excel::assertDownloaded('pegawai.xlsx', function(PegawaiExport $export) {
            return true;
        });
    }

    public function test_hr_can_export_attendance()
    {
        Excel::fake();

        $hr = User::factory()->create(['role' => 'hr']);
        $hr->assignRole('hr');

        $start = now()->startOfMonth()->format('Y-m-d');
        $end = now()->endOfMonth()->format('Y-m-d');

        $response = $this->actingAs($hr)->get(route('reports.export.attendance', [
            'start_date' => $start,
            'end_date' => $end,
        ]));

        $response->assertStatus(200);

        Excel::assertDownloaded('attendance-'.$start.'-to-'.$end.'.xlsx', function(AttendanceExport $export) {
            return true;
        });
    }

    public function test_chart_data_endpoint()
    {
        $hr = User::factory()->create(['role' => 'hr']);
        $hr->assignRole('hr');

        $response = $this->actingAs($hr)->get(route('reports.chart-data'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'department' => ['labels', 'data'],
            'attendance' => ['labels', 'onTime', 'late'],
        ]);
    }
}
