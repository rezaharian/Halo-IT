<x-app-layout>
    <div class="container-fluid px-3 px-lg-5 py-4 py-lg-5 report-document">
        <div class="report-print-header mb-4">
            <div class="d-flex justify-content-between align-items-start border-bottom border-dark pb-3">
                <div>
                    <div class="fw-bold fs-4">HALO IT</div>
                    <div class="small">Dukungan Teknologi Informasi</div>
                </div>
                <div class="text-end small"><strong>LAPORAN MANAJEMEN</strong><br>Dokumen:
                    IT-RPT-{{ now()->format('Ymd') }}<br>Printed: {{ now()->format('d M Y H:i') }}</div>
            </div>
            <h1 class="h3 fw-bold mt-4 mb-1">Laporan Kinerja Helpdesk IT</h1>
            <p class="small mb-0">Periode laporan: {{ $from->format('d M Y') }} - {{ now()->format('d M Y') }}</p>
        </div>
        <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3 mb-4 no-print">
            <div><span class="badge rounded-pill text-primary bg-primary-subtle px-3 py-2">Analitik operasional</span>
                <h1 class="display-6 fw-bold mt-3 mb-2">Laporan bantuan IT</h1>
                <p class="text-secondary mb-0">Ringkasan volume tiket, beban kerja, dan kinerja penyelesaian.</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <form method="GET" class="d-flex align-items-center gap-2"><label for="period"
                        class="small text-secondary text-nowrap">Periode</label><select id="period" name="period"
                        class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="7" @selected($period === 7)>7 hari terakhir</option>
                        <option value="30" @selected($period === 30)>30 hari terakhir</option>
                        <option value="90" @selected($period === 90)>90 hari terakhir</option>
                    </select></form><button type="button" class="btn btn-primary btn-sm rounded-3 px-3"
                    onclick="window.print()"><span class="me-1">&#128438;</span> Cetak / Simpan PDF</button>
            </div>
        </div>
        <div class="alert alert-light border d-flex align-items-center gap-2 small text-secondary mb-4 no-print"><span
                class="text-primary fs-5">&#9432;</span> Showing tickets created from
            <strong>{{ $from->format('d M Y') }}</strong> until today.
        </div>
        <div class="row g-3 mb-4">
            <div class="col-6 col-xl-2">
                <div class="halo-card bg-white p-3 h-100"><small
                        class="text-secondary text-uppercase fw-semibold">Tickets</small>
                    <div class="h2 fw-bold mt-2 mb-0">{{ $totalCount }}</div><small class="text-secondary">in selected
                        period</small>
                </div>
            </div>
            <div class="col-6 col-xl-2">
                <div class="halo-card bg-white p-3 h-100"><small
                        class="text-secondary text-uppercase fw-semibold">Open</small>
                    <div class="h2 fw-bold mt-2 mb-0 text-primary">{{ $openCount }}</div><small
                        class="text-secondary">awaiting action</small>
                </div>
            </div>
            <div class="col-6 col-xl-2">
                <div class="halo-card bg-white p-3 h-100"><small class="text-secondary text-uppercase fw-semibold">In
                        progress</small>
                    <div class="h2 fw-bold mt-2 mb-0 text-warning">{{ $inProgressCount }}</div><small
                        class="text-secondary">being handled</small>
                </div>
            </div>
            <div class="col-6 col-xl-2">
                <div class="halo-card bg-white p-3 h-100"><small
                        class="text-secondary text-uppercase fw-semibold">Resolved</small>
                    <div class="h2 fw-bold mt-2 mb-0 text-success">{{ $resolvedCount }}</div><small
                        class="text-secondary">closed or resolved</small>
                </div>
            </div>
            <div class="col-6 col-xl-2">
                <div class="halo-card bg-white p-3 h-100"><small
                        class="text-secondary text-uppercase fw-semibold">Urgent</small>
                    <div class="h2 fw-bold mt-2 mb-0 text-danger">{{ $urgentCount }}</div><small
                        class="text-secondary">priority tickets</small>
                </div>
            </div>
            <div class="col-6 col-xl-2">
                <div class="halo-card bg-primary text-white p-3 h-100"><small
                        class="text-white-50 text-uppercase fw-semibold">Resolution rate</small>
                    <div class="h2 fw-bold mt-2 mb-0">{{ $resolutionRate }}%</div><small class="text-white-50">period
                        performance</small>
                </div>
            </div>
        </div>
        <div class="row g-4 mb-4">
            <div class="col-12 col-xl-8 no-print">
                <section class="halo-card bg-white p-4 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h2 class="h5 fw-bold mb-1">Ticket volume</h2>
                            <p class="small text-secondary mb-0">New tickets created each day</p>
                        </div><span class="badge rounded-pill bg-primary-subtle text-primary">{{ $period }}
                            days</span>
                    </div>
                    <div class="halo-report-chart d-flex align-items-end gap-2 gap-md-3">
                        @foreach ($dailyTrend as $day)
                            <div class="halo-chart-column flex-fill text-center">
                                <div class="halo-chart-value small fw-semibold text-primary mb-1">
                                    {{ $day['total'] ?: '' }}</div>
                                <div class="halo-chart-bar mx-auto"
                                    style="height: {{ $totalCount > 0 ? max(8, ($day['total'] / max(1, $dailyTrend->max('total'))) * 150) : 8 }}px">
                                </div><small class="text-secondary d-block mt-2">{{ $day['label'] }}</small>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
            <div class="col-12 col-xl-4">
                <section class="halo-card bg-white p-4 h-100">
                    <h2 class="h5 fw-bold mb-1">By priority</h2>
                    <p class="small text-secondary mb-4">Where attention is needed</p>
                    @foreach ($priorities as $priority)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center gap-2"><span
                                    class="halo-priority-dot priority-{{ strtolower($priority->value) }}"></span><span
                                    class="small fw-semibold">{{ $priority->value }}</span></div><span
                                class="badge rounded-pill bg-light text-dark">{{ $priorityCounts->get($priority->value, 0) }}</span>
                        </div>
                    @endforeach
                </section>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-12 col-lg-5">
                <section class="halo-card bg-white overflow-hidden h-100">
                    <div class="p-4 border-bottom">
                        <h2 class="h5 fw-bold mb-1">By status</h2>
                        <p class="small text-secondary mb-0">Current ticket distribution</p>
                    </div>
                    <div class="p-4">
                        @foreach ($statuses as $status)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between small mb-2">
                                    <span>{{ $status->value }}</span><strong>{{ $statusCounts->get($status->value, 0) }}</strong>
                                </div>
                                <div class="progress" style="height: 7px">
                                    <div class="progress-bar bg-primary"
                                        style="width: {{ $totalCount > 0 ? ($statusCounts->get($status->value, 0) / $totalCount) * 100 : 0 }}%">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
            <div class="col-12 col-lg-7">
                <section class="halo-card bg-white overflow-hidden h-100">
                    <div class="p-4 border-bottom">
                        <h2 class="h5 fw-bold mb-1">Top categories</h2>
                        <p class="small text-secondary mb-0">Categories generating the most requests</p>
                    </div>
                    <div class="table-responsive">
                        <table class="table halo-table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th class="text-end">Tickets</th>
                                    <th class="text-end">Share</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categoryCounts as $category)
                                    <tr>
                                        <td class="fw-semibold">{{ $category->name }}</td>
                                        <td class="text-end">{{ $category->total }}</td>
                                        <td class="text-end text-secondary">
                                            {{ $totalCount > 0 ? round(($category->total / $totalCount) * 100) : 0 }}%
                                        </td>
                                </tr>@empty<tr>
                                        <td colspan="3" class="text-center py-4 text-secondary">No category data
                                            for
                                            this period.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
        <div class="report-print-signoff mt-5 pt-4 border-top">
            <div class="row g-4 small">
                <div class="col-4"><strong>Prepared by</strong>
                    <div class="report-sign-line"></div><span>IT Support</span>
                </div>
                <div class="col-4"><strong>Reviewed by</strong>
                    <div class="report-sign-line"></div><span>IT Manager</span>
                </div>
                <div class="col-4"><strong>Approved by</strong>
                    <div class="report-sign-line"></div><span>Management</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
