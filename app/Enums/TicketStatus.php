<?php

namespace App\Enums;

enum TicketStatus: string
{
    case Open = 'Open';
    case Assigned = 'Assigned';
    case InProgress = 'In Progress';
    case WaitingUser = 'Waiting User';
    case Resolved = 'Resolved';
    case Closed = 'Closed';
    case Cancelled = 'Cancelled';

    public static function values(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Open => 'bg-blue-100 text-blue-800 ring-blue-600/20',
            self::Assigned => 'bg-indigo-100 text-indigo-800 ring-indigo-600/20',
            self::InProgress => 'bg-amber-100 text-amber-800 ring-amber-600/20',
            self::WaitingUser => 'bg-purple-100 text-purple-800 ring-purple-600/20',
            self::Resolved => 'bg-emerald-100 text-emerald-800 ring-emerald-600/20',
            self::Closed => 'bg-gray-200 text-gray-700 ring-gray-500/20',
            self::Cancelled => 'bg-red-100 text-red-800 ring-red-600/20',
        };
    }
}
