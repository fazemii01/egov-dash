<!--begin::Card widget 17-->
<div class="card card-flush h-md-50 mb-5 mb-xl-10">
	<!--begin::Header-->
	<div class="card-header pt-5">
		<!--begin::Title-->
		<div class="card-title d-flex flex-column">
			<!--begin::Info-->
			<div class="d-flex align-items-center">
				<!--begin::Icon-->
				<span class="fs-2hx fw-bold text-gray-900 me-2">{!! getIcon('chart-simple', 'fs-1') !!}</span>
				<!--end::Icon-->
				<!--begin::Amount-->
				<span class="fs-2hx fw-bold text-gray-900 me-2 lh-1">Berita Populer</span>
				<!--end::Amount-->
			</div>
			<!--end::Info-->
			<!--begin::Subtitle-->
			<span class="text-gray-500 pt-1 fw-semibold fs-6">Top 5 Berita Terbanyak Dilihat</span>
			<!--end::Subtitle-->
		</div>
		<!--end::Title-->
	</div>
	<!--end::Header-->
	<!--begin::Card body-->
	<div class="card-body pt-2 pb-4 d-flex flex-wrap align-items-center">
		<!--begin::Labels-->
		<div class="d-flex flex-column content-justify-center flex-row-fluid">
			@forelse(($metrics['popular_news'] ?? []) as $popular)
			<!--begin::Label-->
			<div class="d-flex fw-semibold align-items-center {{ !$loop->first ? 'my-3' : '' }}">
				<!--begin::Bullet-->
				<div class="bullet w-8px h-3px rounded-2 bg-{{ ['success', 'primary', 'warning', 'danger', 'info'][$loop->index] ?? 'success' }} me-3"></div>
				<!--end::Bullet-->
				<!--begin::Label-->
				<div class="text-gray-500 flex-grow-1 me-4 text-truncate" title="{{ $popular->news->headline ?? 'Berita' }}">
					{{ \Illuminate\Support\Str::limit($popular->news->headline ?? 'Berita', 30) }}
				</div>
				<!--end::Label-->
				<!--begin::Stats-->
				<div class="fw-bolder text-gray-700 text-xxl-end">{{ $popular->views ?? 0 }} views</div>
				<!--end::Stats-->
			</div>
			<!--end::Label-->
			@empty
			<!--begin::Label-->
			<div class="d-flex fw-semibold align-items-center">
				<div class="text-gray-500 flex-grow-1 me-4">Belum ada data views</div>
			</div>
			<!--end::Label-->
			@endforelse
		</div>
		<!--end::Labels-->
	</div>
	<!--end::Card body-->
</div>
<!--end::Card widget 17-->