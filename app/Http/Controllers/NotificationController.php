<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function feed(Request $request): JsonResponse
    {
        return response()->json([
            'notifications' => $request->user()->unreadNotifications()->latest()->limit(10)->get()->map(fn ($notification) => [
                'id' => $notification->id,
                'message' => $notification->data['message'] ?? 'Ada pembaruan ticket baru.',
                'url' => $notification->data['url'] ?? route('dashboard'),
                'created_at' => $notification->created_at->diffForHumans(),
            ]),
        ]);
    }

    public function read(Request $request, string $notification): JsonResponse
    {
        $request->user()->unreadNotifications()->whereKey($notification)->update(['read_at' => now()]);

        return response()->json(['ok' => true]);
    }
}
