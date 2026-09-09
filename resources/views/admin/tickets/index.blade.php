<x-app-layout>
    <div class="container-fluid px-3 px-lg-5 py-4 py-lg-5">
        <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3 mb-4">
            <div><span class="badge rounded-pill text-primary bg-primary-subtle px-3 py-2">Pusat operasional</span>
                <h1 class="display-6 fw-bold mt-3 mb-2">Semua tiket</h1>
                <p class="text-secondary mb-0">Kelola seluruh antrean bantuan perusahaan.</p>
            </div>
        </div>
        <form method="GET" class="halo-card bg-white p-3 mb-4">
            <div class="row g-2">
                <div class="col-12 col-lg-4"><input name="search" value="{{ request('search') }}"
                        placeholder="Cari tiket, subjek, atau deskripsi" class="form-control"></div>
                <div class="col-6 col-lg-2"><select name="status" class="form-select">
                        <option value="">Semua status</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-lg-2"><select name="priority" class="form-select">
                        <option value="">Semua prioritas</option>
                        @foreach ($priorities as $priority)
                            <option value="{{ $priority->value }}" @selected(request('priority') === $priority->value)>{{ $priority->value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-8 col-lg-2"><select name="category_id" class="form-select">
                        <option value="">Semua kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected((string) request('category_id') === (string) $category->id)>{{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4 col-lg-2"><button class="btn btn-dark w-100">Filter</button></div>
            </div>
        </form>
        <section class="halo-card bg-white overflow-hidden">
            <div class="table-responsive">
                <table class="table halo-table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Tiket</th>
                            <th>Pemohon</th>
                            <th>Kategori</th>
                            <th>Prioritas</th>
                            <th>Ditugaskan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tickets as $ticket)
                            <tr>
                                <td><a href="{{ route('admin.tickets.show', $ticket) }}"
                                        class="text-decoration-none fw-semibold">{{ $ticket->ticket_number }}</a>
                                    <div class="small mt-1">{{ $ticket->subject }}</div>
                                </td>
                                <td>{{ $ticket->user->name }}</td>
                                <td>{{ $ticket->category->name }}</td>
                                <td><span
                                        class="badge rounded-pill bg-warning-subtle text-warning-emphasis">{{ $ticket->priority }}</span>
                                </td>
                                <td class="text-secondary">{{ $ticket->assignedUser?->name ?? 'Belum ditugaskan' }}
                                </td>
                                <td><span
                                        class="badge rounded-pill bg-primary-subtle text-primary">{{ $ticket->status }}</span>
                                </td>
                        </tr>@empty<tr>
                                <td colspan="6" class="text-center py-5 text-secondary">Tidak ada tiket yang
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
