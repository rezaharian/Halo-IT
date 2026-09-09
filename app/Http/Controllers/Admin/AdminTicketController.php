<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateTicketRequest;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class AdminTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $tickets = Ticket::query()
            ->with(['user', 'category', 'assignedUser'])
            ->search($request->string('search')->toString())
            ->status($request->string('status')->toString())
            ->priority($request->string('priority')->toString())
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->integer('category_id')))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.tickets.index', [
            'tickets' => $tickets,
            'categories' => Category::where('is_active', true)->orderBy('name')->get(),
            'statuses' => TicketStatus::cases(),
            'priorities' => TicketPriority::cases(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): RedirectResponse
    {
        return to_route('admin.tickets.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket): View
    {
        Gate::authorize('view', $ticket);

        return view('admin.tickets.show', [
            'ticket' => $ticket->load(['user', 'category', 'assignedUser', 'comments.user', 'activities.user']),
            'categories' => Category::where('is_active', true)->orderBy('name')->get(),
            'technicians' => User::where('role', 'admin')->orderBy('name')->get(),
            'statuses' => TicketStatus::cases(),
            'priorities' => TicketPriority::cases(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket): View
    {
        return $this->show($ticket);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket): RedirectResponse
    {
        $oldValues = $ticket->only(['status', 'priority', 'category_id', 'assigned_to']);
        $values = $request->validated();

        if ($values['status'] === TicketStatus::Resolved->value && $ticket->status !== TicketStatus::Resolved->value) {
            $values['resolved_at'] = now();
        }

        if ($values['status'] === TicketStatus::Closed->value && $ticket->status !== TicketStatus::Closed->value) {
            $values['closed_at'] = now();
        }

        if ($values['assigned_to'] !== null && $ticket->assigned_to === null && $values['status'] === TicketStatus::Open->value) {
            $values['status'] = TicketStatus::Assigned->value;
        }

        $ticket->update($values);

        if ($ticket->wasChanged(['status', 'priority', 'category_id', 'assigned_to'])) {
            $ticket->user->notify(new TicketNotification(
                $ticket,
                'ticket.updated',
                "Tiket {$ticket->ticket_number} diperbarui oleh tim IT.",
            ));
        }

        foreach (['status', 'priority', 'category_id', 'assigned_to'] as $field) {
            if ((string) $oldValues[$field] !== (string) $ticket->{$field}) {
                $ticket->activities()->create([
                    'user_id' => $request->user()->id,
                    'action' => 'ticket.updated',
                    'description' => "{$field} updated",
                    'old_value' => (string) $oldValues[$field],
                    'new_value' => (string) $ticket->{$field},
                ]);
            }
        }

        return to_route('admin.tickets.show', $ticket)->with('status', 'Tiket berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket): RedirectResponse
    {
        abort(404);
    }
}
