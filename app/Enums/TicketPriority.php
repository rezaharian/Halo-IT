<?php

namespace App\Enums;

enum TicketPriority: string
{
    case Low = 'Low';
    case Medium = 'Medium';
    case High = 'High';
    case Urgent = 'Urgent';

    public static function values(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Low => 'bg-gray-100 text-gray-700 ring-gray-500/20',
            self::Medium => 'bg-sky-100 text-sky-800 ring-sky-600/20',
            self::High => 'bg-orange-100 text-orange-800 ring-orange-600/20',
            self::Urgent => 'bg-red-100 text-red-800 ring-red-600/20 font-semibold animate-pulse',
        };
    }
}
