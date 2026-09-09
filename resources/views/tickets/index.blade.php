<x-app-layout>
    <div class="container-fluid px-3 px-lg-5 py-4 py-lg-5">
        <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3 mb-4">
            <div><span class="badge rounded-pill text-primary bg-primary-subtle px-3 py-2">Pusat bantuan</span>
                <h1 class="display-6 fw-bold mt-3 mb-2">Tiket saya</h1>
                <p class="text-secondary mb-0">Cari dan pantau semua permintaan bantuan Anda.</p>
            </div><a href="{{ route('tickets.create') }}" class="btn btn-primary rounded-3 px-4">&#43; Buat tiket</a>
        </div>
        <form method="GET" class="halo-card bg-white p-3 mb-4">
            <div class="row g-2">
                <div class="col-12 col-lg-5"><input name="search" value="{{ request('search') }}"
                        placeholder="Cari nomor tiket atau subjek" class="form-control"></div>
                <div class="col-6 col-lg-2"><select name="status" class="form-select">
                        <option value="">Semua status</option>
                        @foreach (\App\Enums\TicketStatus::cases() as $status)
                            <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-lg-2"><select name="priority" class="form-select">
                        <option value="">Semua prioritas</option>
                        @foreach (\App\Enums\TicketPriority::cases() as $priority)
                            <option value="{{ $priority->value }}" @selected(request('priority') === $priority->value)>{{ $priority->value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-lg-3"><button class="btn btn-dark w-100">Terapkan filter</button></div>
            </div>
        </form>
        <section class="halo-card bg-white overflow-hidden">
            <div class="table-responsive">
                <table class="table halo-table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Tiket</th>
                            <th>Kategori</th>
                            <th>Prioritas</th>
                            <th>Status</th>
                            <th>Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tickets as $ticket)
                            <tr>
                                <td><a href="{{ route('tickets.show', $ticket) }}"
                                        class="text-decoration-none fw-semibold">{{ $ticket->ticket_number }}</a>
                                    <div class="small text-dark mt-1">{{ $ticket->subject }}</div>
                                </td>
                                <td>{{ $ticket->category->name }}</td>
                                <td><span
                                        class="badge rounded-pill bg-warning-subtle text-warning-emphasis">{{ $ticket->priority }}</span>
                                </td>
                                <td><span
                                        class="badge rounded-pill bg-primary-subtle text-primary">{{ $ticket->status }}</span>
                                </td>
                                <td class="text-secondary">{{ $ticket->created_at->format('d M Y') }}</td>
                        </tr>@empty<tr>
                                <td colspan="5" class="text-center py-5 text-secondary">Tidak ada tiket yang
                                    ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($tickets->hasPages())
                <div class="p-3 border-top">{{ $tickets->links() }}</div>
            @endif
        </section>
    </div>
</x-app-layout>
