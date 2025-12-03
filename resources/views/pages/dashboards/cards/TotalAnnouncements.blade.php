<!--begin::Card widget 7-->
<div class="card card-flush h-lg-100">
	<!--begin::Header-->
	<div class="card-header pt-5">
		<!--begin::Title-->
		<div class="card-title d-flex flex-column">
			<span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">{{ $metrics['total_announcements'] ?? 0 }}</span>
			<span class="text-gray-500 pt-1 fw-semibold fs-6">Total Pengumuman</span>
		</div>
		<!--end::Title-->
	</div>
	<!--end::Header-->
	<!--begin::Card body-->
	<div class="card-body d-flex flex-column justify-content-start pe-0">
		<span class="fs-6 fw-bolder text-gray-800 d-block mb-2">Pengumuman Terbaru</span>
		<div class="d-flex flex-column">
			@forelse(($metrics['recent_announcements'] ?? []) as $announcement)
			<div class="d-flex align-items-center mb-2">
				<div class="bullet bullet-vertical bg-primary me-3"></div>
				<div class="text-gray-700 fw-semibold fs-7 text-truncate">
					{{ \Illuminate\Support\Str::limit($announcement->title ?? 'Pengumuman', 35) }}
				</div>
			</div>
			@empty
			<div class="text-gray-500 fs-7">Belum ada pengumuman</div>
			@endforelse
		</div>
	</div>
	<!--end::Card body-->
</div>
<!--end::Card widget 7-->