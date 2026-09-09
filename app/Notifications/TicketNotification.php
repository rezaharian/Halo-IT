<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Notifications\Notification;

class TicketNotification extends Notification
{
    public function __construct(
        public Ticket $ticket,
        public string $event,
        public string $message,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'event' => $this->event,
            'message' => $this->message,
            'ticket_id' => $this->ticket->id,
            'ticket_number' => $this->ticket->ticket_number,
            'url' => route($notifiable->role === 'admin' ? 'admin.tickets.show' : 'tickets.show', $this->ticket, false),
        ];
    }
}
