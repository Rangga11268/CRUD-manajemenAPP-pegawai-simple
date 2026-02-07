<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\LeaveType;
use App\Models\Pegawai;
use App\Models\Department;
use App\Models\Jabatan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewLeaveRequest;
use App\Notifications\LeaveStatusUpdated;
use Tests\TestCase;

class NotificationTest extends TestCase
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

    public function test_hr_receives_notification_when_audit_creates_leave()
    {
        Notification::fake();

        $pegawai = User::factory()->create(['role' => 'pegawai']);
        $pegawai->assignRole('pegawai');
        $pegawaiProfile = Pegawai::factory()->create(['user_id' => $pegawai->id]);

        $hr = User::factory()->create(['role' => 'hr']);
        $hr->assignRole('hr');

        $leaveType = LeaveType::first();

        $response = $this->actingAs($pegawai)->post(route('leave.store'), [
            'leave_type_id' => $leaveType->id,
            'start_date' => now()->addDay()->format('Y-m-d'),
            'end_date' => now()->addDays(2)->format('Y-m-d'),
            'alasan' => 'Sakit',
        ]);

        $response->assertRedirect(route('leave.index'));

        Notification::assertSentTo(
            [$hr],
            NewLeaveRequest::class
        );
    }

    public function test_pegawai_receives_notification_when_leave_approved()
    {
        Notification::fake();

        $pegawai = User::factory()->create(['role' => 'pegawai']);
        $pegawai->assignRole('pegawai');
        $pegawaiProfile = Pegawai::factory()->create(['user_id' => $pegawai->id]);

        $hr = User::factory()->create(['role' => 'hr']);
        $hr->assignRole('hr');

        $leaveType = LeaveType::first();
        $leave = \App\Models\Leave::create([
            'pegawai_id' => $pegawaiProfile->id,
            'leave_type_id' => $leaveType->id,
            'start_date' => now()->addDay(),
            'end_date' => now()->addDays(2),
            'days_count' => 2,
            'alasan' => 'Test',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($hr)->post(route('leave.approve', $leave));

        $response->assertRedirect();

        Notification::assertSentTo(
            [$pegawai],
            LeaveStatusUpdated::class
        );
    }

    public function test_user_can_view_notifications()
    {
        $user = User::factory()->create();
        $user->assignRole('pegawai');

        // Create a database notification manually
        $user->notify(new NewLeaveRequest(\App\Models\Leave::factory()->create()));

        $response = $this->actingAs($user)->get(route('notifications.index'));

        $response->assertStatus(200);
        $response->assertSee('Notifikasi');
    }
}
