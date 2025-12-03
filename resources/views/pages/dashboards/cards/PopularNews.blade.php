<!--begin::Card widget Popular News-->
<div class="card card-flush h-md-100 mb-5 mb-xl-10">
    <!--begin::Header-->
    <div class="card-header pt-5">
        <!--begin::Title-->
        <div class="card-title d-flex flex-column">
            <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1">Berita Populer</span>
            <span class="text-gray-500 pt-1 fw-semibold fs-6">Top 5 Berita Terbanyak Dilihat</span>
        </div>
        <!--end::Title-->
    </div>
    <!--end::Header-->
    <!--begin::Card body-->
    <div class="card-body pt-2 pb-4">
        <!--begin::Table container-->
        <div class="table-responsive">
            <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                <thead>
                    <tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
                        <th class="p-0 pb-3 min-w-30px text-start">NO</th>
                        <th class="p-0 pb-3 min-w-120px text-center">JUDUL</th>
                        <th class="p-0 pb-3 min-w-80px text-center">GRAFIK</th>
                        <th class="p-0 pb-3 min-w-30px text-start">VIEWS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($metrics['popular_news'] ?? []) as $index => $popular)
                    <tr>
                        <!-- Kolom Nomor -->
                        <td>
                            <div class="text-gray-900 text-center fw-bold fs-6">{{ $index + 1 }}</div>
                        </td>
                        
                        <!-- Kolom Judul (2 kata pertama) -->
                        <td>
                            <div class="d-flex justify-content-center text-center flex-column">
                                @php
                                    $words = explode(' ', $popular['news']->headline ?? 'Berita');
                                    $shortTitle = implode(' ', array_slice($words, 0, 2));
                                @endphp
                                <span class="text-gray-900 fw-bold text-hover-primary fs-6" title="{{ $popular['news']->headline ?? 'Berita' }}">
                                    {{ $shortTitle }}
                                </span>
                            </div>
                        </td>
                        
                        <!-- Kolom Grafik -->
                        <td class="text-center pe-0">
                            <div id="kt_charts_PopularNews_chart_{{ $index + 1 }}" class="h-30px mt-n5" data-kt-chart-color="{{ ['success', 'primary', 'warning', 'danger', 'info'][$index] ?? 'success' }}"></div>
                        </td>
                        
                        <!-- Kolom Views -->
                        <td class="text-center">
                            <span class="text-gray-900 fw-bold fs-6">{{ number_format($popular['views'] ?? 0) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-start text-gray-500 py-10">
                            <div class="fw-semibold fs-6">Belum ada data views</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!--end::Table container-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Card widget Popular News-->

{{-- ===== TAMBAH CODE INI DI BAWAH ===== --}}
@push('scripts')
<script>
// Simple chart untuk Popular News - taruh di sini
document.addEventListener('DOMContentLoaded', function() {
    @foreach(($metrics['popular_news'] ?? []) as $index => $popular)
    (function() {
        var element = document.getElementById('kt_charts_PopularNews_chart_{{ $index + 1 }}');
        if (!element) return;
        
        // Data dari controller
        var data = {!! json_encode($popular['trend_data'] ?? [45, 52, 48, 60, 55, 40, 35]) !!};
        var color = '{{ ['success', 'primary', 'warning', 'danger', 'info'][$index] ?? 'success' }}';
        var maxValue = Math.max(...data);
        
        // Buat SVG line chart simple
        var points = data.map(function(value, i) {
            var x = (i / (data.length - 1)) * 100;
            var y = 100 - (value / maxValue) * 100;
            return x + ',' + y;
        }).join(' ');
        
        element.innerHTML = `
            <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
                <polyline points="${points}" fill="none" stroke="var(--bs-${color})" stroke-width="2"/>
            </svg>
        `;
    })();
    @endforeach
});
</script>
@endpush