<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminTicketController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketCommentController;
use App\Http\Controllers\TicketController;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Auth::check() ? to_route('dashboard') : view('welcome');
});

Route::get('/dashboard', function () {
    $tickets = Ticket::query()->where('user_id', Auth::id())->with('category')->latest()->limit(5)->get();

    return view('dashboard', [
        'tickets' => $tickets,
        'openCount' => Ticket::where('user_id', Auth::id())->whereNotIn('status', ['Resolved', 'Closed', 'Cancelled'])->count(),
        'resolvedCount' => Ticket::where('user_id', Auth::id())->whereIn('status', ['Resolved', 'Closed'])->count(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/notifications/feed', [NotificationController::class, 'feed'])->name('notifications.feed');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::resource('tickets', TicketController::class)->only(['index', 'create', 'store', 'show']);
    Route::post('/tickets/{ticket}/comments', [TicketCommentController::class, 'store'])->name('tickets.comments.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::resource('tickets', AdminTicketController::class)->only(['index', 'show', 'edit', 'update']);
});

require __DIR__.'/auth.php';
