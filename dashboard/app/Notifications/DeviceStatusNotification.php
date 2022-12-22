<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeviceStatusNotification extends Notification
{
    use Queueable;

    public $device;
    public $succeed;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($device, $succeed = true)
    {
        $this->device = $device;
        $this->succeed = $succeed;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $status = $this->device['status'];
        $deviceId = $this->device['id'];
        $deviceName = $this->device['device_id'];
        $url = route('device.show', $deviceId);
        $color = $this->device['status'] == 'active' ? 'green' : 'red';
        $title = $this->getMessage()['title'];
        $body = $this->getMessage()['body'];


        return (new MailMessage)
            ->subject('Device Status Changed')
            ->markdown('mail.device.status', [
                'deviceName' => $deviceName,
                'status' => $status,
                'url' => $url,
                'color' => $color,
                'title' => $title,
                'body' => $body,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'type' => 'device_status',
            'device_id' => $this->device['device_id'],
            'succeed' => $this->succeed,
            'title' => $this->getMessage()['title'],
            'body' => $this->getMessage()['body'],
        ];
    }

    public function getMessage()
    {
        $deviceId = $this->device['device_id'];

        if ($this->succeed) {
            $status = $this->device['status'];
            $message['title'] = 'Status Change Succeed';
            $message['body'] = "`$deviceId` has been changed to $status";
        } else {
            $message['title'] = 'Status Change Failed';
            $message['body'] = "`$deviceId` has not been changed";
        }

        return $message;
    }
}
