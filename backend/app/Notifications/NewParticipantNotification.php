<?php

namespace App\Notifications;

use App\Models\Event;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewParticipantNotification extends Notification
{
    use Queueable;

    protected $event;
    protected $user;

    public function __construct(Event $event, User $user)
    {
        $this->event = $event;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'New Participant',
            'message' => "{$this->user->name} joined your event: {$this->event->title}",
            'event_id' => $this->event->id,
            'icon' => '✅',
            'type' => 'event.joined'
        ];
    }
}
