<x-app-layout>
    <div class="container-fluid px-3 px-lg-5 py-4 py-lg-5">
        <div class="mb-4"><span class="badge rounded-pill text-primary bg-primary-subtle px-3 py-2">Pusat
                operasional</span>
            <h1 class="display-6 fw-bold mt-3 mb-2">Dasbor admin</h1>
            <p class="text-secondary mb-0">Pantau antrean bantuan dan selesaikan masalah lebih cepat.</p>
        </div>
        <div class="row g-3 mb-4">
            <div class="col-6 col-xl">
                <div class="halo-card bg-white p-3 h-100"><small class="text-secondary text-uppercase fw-semibold">Total
                        tiket</small>
                    <div class="h2 fw-bold mt-2 mb-0">{{ $totalCount }}</div>
                </div>
            </div>
            <div class="col-6 col-xl">
                <div class="halo-card bg-white p-3 h-100"><small
                        class="text-secondary text-uppercase fw-semibold">Terbuka</small>
                    <div class="h2 fw-bold mt-2 mb-0 text-primary">{{ $openCount }}</div>
                </div>
            </div>
            <div class="col-6 col-xl">
                <div class="halo-card bg-white p-3 h-100"><small class="text-secondary text-uppercase fw-semibold">Dalam
                        proses</small>
                    <div class="h2 fw-bold mt-2 mb-0 text-warning">{{ $inProgressCount }}</div>
                </div>
            </div>
            <div class="col-6 col-xl">
                <div class="halo-card bg-white p-3 h-100"><small
                        class="text-secondary text-uppercase fw-semibold">Selesai</small>
                    <div class="h2 fw-bold mt-2 mb-0 text-success">{{ $resolvedCount }}</div>
                </div>
            </div>
            <div class="col-12 col-xl">
                <div class="halo-card bg-danger-subtle p-3 h-100"><small
                        class="text-danger text-uppercase fw-semibold">Urgent aktif</small>
                    <div class="h2 fw-bold mt-2 mb-0 text-danger">{{ $urgentCount }}</div>
                </div>
            </div>
        </div>
        <section class="halo-card bg-white overflow-hidden">
            <div class="d-flex flex-column flex-sm-row justify-content-between gap-2 p-4 border-bottom">
                <div>
                    <h2 class="h5 fw-bold mb-1">Antrean terbaru</h2>
                    <p class="small text-secondary mb-0">Permintaan bantuan terbaru dari karyawan.</p>
                </div><a href="{{ route('admin.tickets.index') }}" class="btn btn-light btn-sm rounded-3">Kelola semua
                    tiket &rarr;</a>
            </div>
            <div class="table-responsive">
                <table class="table halo-table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Tiket</th>
                            <th>Pemohon</th>
                            <th>Kategori</th>
                            <th>Prioritas</th>
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
                                <td><span
                                        class="badge rounded-pill bg-primary-subtle text-primary">{{ $ticket->status }}</span>
                                </td>
                        </tr>@empty<tr>
                                <td colspan="5" class="text-center py-5 text-secondary">Belum ada tiket dalam
                                    antrean.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
