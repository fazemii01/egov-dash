<!--begin::Card widget 7-->
<div class="card card-flush h-md-50 mb-5 mb-xl-10">
	<!--begin::Header-->
	<div class="card-header pt-5">
		<!--begin::Title-->
		<div class="card-title d-flex flex-column">
			<!--begin::Amount-->
			<span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">{{ $metrics['total_announcements'] ?? 0 }}</span>
			<!--end::Amount-->
			<!--begin::Subtitle-->
			<span class="text-gray-500 pt-1 fw-semibold fs-6">Total Pengumuman</span>
			<!--end::Subtitle-->
		</div>
		<!--end::Title-->
	</div>
	<!--end::Header-->
	<!--begin::Card body-->
	<div class="card-body d-flex flex-column justify-content-end pe-0">
		<!--begin::Title-->
		<span class="fs-6 fw-bolder text-gray-800 d-block mb-2">Statistik Terkini</span>
		<!--end::Title-->
		<!--begin::Stats group-->
		<div class="symbol-group symbol-hover flex-nowrap">
			<div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Total Berita">
				<span class="symbol-label bg-primary text-inverse-primary fw-bold">{{ $metrics['total_news'] ?? 0 }}</span>
			</div>
			<div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Total Views">
				<span class="symbol-label bg-success text-inverse-success fw-bold">{{ $metrics['total_news_views'] ?? 0 }}</span>
			</div>
			<div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Total Pengunjung">
				<span class="symbol-label bg-warning text-inverse-warning fw-bold">{{ $metrics['total_visitors'] ?? 0 }}</span>
			</div>
		</div>
		<!--end::Stats group-->
	</div>
	<!--end::Card body-->
</div>
<!--end::Card widget 7-->