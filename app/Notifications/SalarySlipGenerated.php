<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SalarySlipGenerated extends Notification
{
    use Queueable;

    public $salary;

    public function __construct($salary)
    {
        $this->salary = $salary;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'salary_id' => $this->salary->id,
            'message' => 'Slip Gaji Periode ' . $this->salary->periode . ' Telah Terbit',
            'url' => route('salary.show', $this->salary->id),
        ];
    }


}
