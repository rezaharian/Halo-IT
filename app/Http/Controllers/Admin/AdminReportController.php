<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminReportController extends Controller
{
    public function index(Request $request): View
    {
        $period = in_array($request->integer('period', 30), [7, 30, 90], true)
            ? $request->integer('period', 30)
            : 30;
        $from = now()->subDays($period - 1)->startOfDay();
        $baseQuery = Ticket::query()->where('tickets.created_at', '>=', $from);

        $statusCounts = (clone $baseQuery)
            ->select('status')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');
        $priorityCounts = (clone $baseQuery)
            ->select('priority')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('priority')
            ->pluck('total', 'priority');
        $categoryCounts = (clone $baseQuery)
            ->join('categories', 'categories.id', '=', 'tickets.category_id')
            ->select('categories.name')
            ->selectRaw('COUNT(tickets.id) as total')
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total')
            ->get();
        $dailyCounts = (clone $baseQuery)
            ->selectRaw('DATE(tickets.created_at) as report_date')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('report_date')
            ->pluck('total', 'report_date');
        $dailyTrend = collect(range($period - 1, 0))->map(function (int $daysAgo) use ($dailyCounts): array {
            $date = now()->subDays($daysAgo)->startOfDay();

            return [
                'label' => $date->format('d M'),
                'total' => (int) $dailyCounts->get($date->toDateString(), 0),
            ];
        })->values();
        $resolvedCount = (int) $statusCounts->get(TicketStatus::Resolved->value, 0) + (int) $statusCounts->get(TicketStatus::Closed->value, 0);
        $totalCount = (int) $baseQuery->count();

        return view('admin.reports.index', [
            'period' => $period,
            'from' => $from,
            'totalCount' => $totalCount,
            'openCount' => (int) $statusCounts->get(TicketStatus::Open->value, 0),
            'inProgressCount' => (int) $statusCounts->get(TicketStatus::InProgress->value, 0),
            'resolvedCount' => $resolvedCount,
            'urgentCount' => (int) $priorityCounts->get(TicketPriority::Urgent->value, 0),
            'resolutionRate' => $totalCount > 0 ? round(($resolvedCount / $totalCount) * 100) : 0,
            'statusCounts' => $statusCounts,
            'priorityCounts' => $priorityCounts,
            'categoryCounts' => $categoryCounts,
            'dailyTrend' => $dailyTrend,
            'statuses' => TicketStatus::cases(),
            'priorities' => TicketPriority::cases(),
            'categories' => Category::query()->where('is_active', true)->orderBy('name')->get(),
        ]);
    }
}
