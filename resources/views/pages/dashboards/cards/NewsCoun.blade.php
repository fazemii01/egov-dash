<!--begin::Card widget 20-->
<div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-100 mb-5 mb-xl-10" style="background-color: #00A3FF;background-image:url('assets/media/patterns/vector-1.png')">
	<!--begin::Header-->
	<div class="card-header pt-5">
		<!--begin::Title-->
		<div class="card-title d-flex flex-column">
			<!--begin::Amount-->
			<span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $metrics['total_news'] ?? 0 }}</span>
			<!--end::Amount-->
			<!--begin::Subtitle-->
			<span class="text-white opacity-75 pt-1 fw-semibold fs-6">Total Berita</span>
			<!--end::Subtitle-->
		</div>
		<!--end::Title-->
	</div>
	<!--end::Header-->
	<!--begin::Card body-->
	<div class="card-body d-flex align-items-end pt-0">
		<!--begin::Progress-->
		<div class="d-flex align-items-center flex-column mt-3 w-100">
			<div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
    <span>{{ $metrics['total_news_views'] ?? 0 }} Total Views</span>
    <span>{{ $metrics['total_news'] ? round(($metrics['total_news_views'] / $metrics['total_news']), 1) : 0 }} avg</span>
</div>
			<div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
				<div class="bg-white rounded h-8px" role="progressbar" 
					 style="width: {{ min(($metrics['total_news_views'] ?? 0) / max(($metrics['total_news'] ?? 1) * 10, 1) * 100, 100) }}%;" 
					 aria-valuenow="{{ $metrics['total_news_views'] ?? 0 }}" 
					 aria-valuemin="0" 
					 aria-valuemax="{{ max(($metrics['total_news'] ?? 1) * 10, 100) }}">
				</div>
			</div>
		</div>
		<!--end::Progress-->
	</div>
	<!--end::Card body-->
</div>
<!--end::Card widget 20-->