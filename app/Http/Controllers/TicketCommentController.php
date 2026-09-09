<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketCommentRequest;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketNotification;
use Illuminate\Http\RedirectResponse;

class TicketCommentController extends Controller
{
    public function store(StoreTicketCommentRequest $request, Ticket $ticket): RedirectResponse
    {
        $comment = $ticket->comments()->create([
            'user_id' => $request->user()->id,
            'comment' => $request->validated('comment'),
            'is_internal' => $request->boolean('is_internal') && $request->user()->role === 'admin',
        ]);

        $ticket->activities()->create([
            'user_id' => $request->user()->id,
            'action' => 'comment.created',
            'description' => $comment->is_internal ? 'Internal comment added' : 'Comment added',
        ]);

        if ($request->user()->role === 'admin') {
            if (! $comment->is_internal && $ticket->user_id !== $request->user()->id) {
                $ticket->user->notify(new TicketNotification(
                    $ticket,
                    'comment.created',
                    "Komentar baru pada tiket {$ticket->ticket_number}.",
                ));
            }
        } else {
            User::query()
                ->where('role', 'admin')
                ->where('id', '!=', $request->user()->id)
                ->get()
                ->each(fn (User $admin) => $admin->notify(new TicketNotification(
                    $ticket,
                    'comment.created',
                    "Komentar baru pada tiket {$ticket->ticket_number} dari {$request->user()->name}.",
                )));
        }

        return back()->with('status', 'Komentar berhasil ditambahkan.');
    }
}
