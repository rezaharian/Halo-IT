<?php

namespace App\Http\Controllers;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Http\Requests\StoreTicketRequest;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $tickets = Ticket::query()
            ->with('category')
            ->where('user_id', $request->user()->id)
            ->search($request->string('search')->toString())
            ->status($request->string('status')->toString())
            ->priority($request->string('priority')->toString())
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('tickets.create', [
            'categories' => Category::query()->where('is_active', true)->orderBy('name')->get(),
            'priorities' => TicketPriority::cases(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request): RedirectResponse
    {
        $ticket = DB::transaction(function () use ($request): Ticket {
            $ticket = Ticket::create([
                ...$request->validated(),
                'ticket_number' => 'TMP-'.Str::uuid(),
                'user_id' => $request->user()->id,
                'status' => TicketStatus::Open->value,
            ]);

            $ticket->update(['ticket_number' => sprintf('TCK-%06d', $ticket->id)]);

            return $ticket;
        });

        User::where('role', 'admin')->get()->each(fn (User $admin) => $admin->notify(new TicketNotification(
            $ticket,
            'ticket.created',
            "Tiket {$ticket->ticket_number} baru dibuat oleh {$request->user()->name}.",
        )));

        return to_route('tickets.show', $ticket)->with('status', 'Tiket berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Ticket $ticket): View
    {
        abort_unless($ticket->user_id === $request->user()->id, 404);

        return view('tickets.show', ['ticket' => $ticket->load(['category', 'comments' => fn ($query) => $query->where('is_internal', false)->with('user'), 'activities.user'])]);
    }
}
