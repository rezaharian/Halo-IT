<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'totalCount' => Ticket::count(),
            'openCount' => Ticket::where('status', 'Open')->count(),
            'inProgressCount' => Ticket::where('status', 'In Progress')->count(),
            'resolvedCount' => Ticket::whereIn('status', ['Resolved', 'Closed'])->count(),
            'urgentCount' => Ticket::where('priority', 'Urgent')->whereNotIn('status', ['Resolved', 'Closed', 'Cancelled'])->count(),
            'tickets' => Ticket::with(['user', 'category', 'assignedUser'])->latest()->limit(10)->get(),
        ]);
    }
}
