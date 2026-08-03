@extends('webadmin.layouts.app')

@section('title', config('webadmin.title'))

@section('content')
@php
	$change = $stats['contacts_change'];
	$changePositive = $change >= 0;
@endphp
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Dashboard" :home-url="route('admin.dashboard')" />

	{{-- KPI cards --}}
	<div class="row g-3 mb-3">
		<div class="col-xl-3 col-md-6">
			<div class="card h-100 dashboard-stat-card">
				<div class="card-body">
					<div class="d-flex align-items-start justify-content-between">
						<div>
							<p class="text-muted mb-1">Total Contacts</p>
							<h2 class="mb-1">{{ number_format($stats['contacts_total']) }}</h2>
							<span class="badge badge-sm {{ $changePositive ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
								{{ $changePositive ? '+' : '' }}{{ $change }}% this month
							</span>
						</div>
						<span class="dashboard-stat-icon bg-primary-subtle text-primary">
							<i class="fi fi-rr-envelope"></i>
						</span>
					</div>
					<div class="border-top mt-3 pt-3 d-flex justify-content-between align-items-center">
						<span class="text-muted text-1xs">This month: {{ number_format($stats['contacts_this_month']) }} · Last: {{ number_format($stats['contacts_last_month']) }}</span>
						<a href="{{ route('admin.contacts.index') }}" class="btn-link text-primary">View</a>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3 col-md-6">
			<div class="card h-100 dashboard-stat-card">
				<div class="card-body">
					<div class="d-flex align-items-start justify-content-between">
						<div>
							<p class="text-muted mb-1">Open Leads</p>
							<h2 class="mb-1">{{ number_format($stats['open_leads']) }}</h2>
							<span class="text-muted text-1xs">Pending + Follow-up + Hold</span>
						</div>
						<span class="dashboard-stat-icon bg-warning-subtle text-warning">
							<i class="fi fi-rr-envelope"></i>
						</span>
					</div>
					<div class="border-top mt-3 pt-3 d-flex flex-wrap gap-2">
						<span class="badge bg-warning-subtle text-warning">Pending {{ $stats['pending'] }}</span>
						<span class="badge bg-info-subtle text-info">Follow-up {{ $stats['followup'] }}</span>
						<span class="badge bg-secondary-subtle text-secondary">Hold {{ $stats['hold'] }}</span>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3 col-md-6">
			<div class="card h-100 dashboard-stat-card">
				<div class="card-body">
					<div class="d-flex align-items-start justify-content-between">
						<div>
							<p class="text-muted mb-1">Completed Leads</p>
							<h2 class="mb-1">{{ number_format($stats['completed']) }}</h2>
							<span class="text-muted text-1xs">Closed contact submissions</span>
						</div>
						<span class="dashboard-stat-icon bg-success-subtle text-success">
							<i class="fi fi-rr-check"></i>
						</span>
					</div>
					<div class="border-top mt-3 pt-3">
						<a href="{{ route('admin.contacts.index') }}" class="btn-link text-primary">Manage contacts</a>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3 col-md-6">
			<div class="card h-100 dashboard-stat-card">
				<div class="card-body">
					<div class="d-flex align-items-start justify-content-between">
						<div>
							<p class="text-muted mb-1">Newsletter</p>
							<h2 class="mb-1">{{ number_format($stats['newsletter_total']) }}</h2>
							<span class="text-muted text-1xs">+{{ number_format($stats['newsletter_this_month']) }} this month</span>
						</div>
						<span class="dashboard-stat-icon bg-info-subtle text-info">
							<i class="fi fi-rr-envelope-open"></i>
						</span>
					</div>
					<div class="border-top mt-3 pt-3">
						<a href="{{ route('admin.newsletter-subscribers.index') }}" class="btn-link text-primary">View subscribers</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row g-3 mb-3">
		{{-- Contacts chart --}}
		<div class="col-xxl-8 col-lg-7">
			<div class="card h-100">
				<div class="card-header border-0 pb-0 d-flex align-items-center justify-content-between">
					<div>
						<h6 class="mb-0">Contact Submissions</h6>
						<p class="text-muted text-1xs mb-0">Last 6 months</p>
					</div>
					<a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-outline-primary">All contacts</a>
				</div>
				<div class="card-body pt-2">
					<div id="chartContactsTrend" class="dashboard-chart"></div>
				</div>
			</div>
		</div>

		{{-- Status breakdown --}}
		<div class="col-xxl-4 col-lg-5">
			<div class="card h-100">
				<div class="card-header border-0 pb-0">
					<h6 class="mb-0">Lead Status</h6>
					<p class="text-muted text-1xs mb-0">All contact submissions</p>
				</div>
				<div class="card-body">
					<div id="chartLeadStatus" class="dashboard-donut mb-3"></div>
					<div class="d-grid gap-2">
						<div class="d-flex justify-content-between"><span>Pending</span><strong>{{ $stats['pending'] }}</strong></div>
						<div class="d-flex justify-content-between"><span>Follow-up</span><strong>{{ $stats['followup'] }}</strong></div>
						<div class="d-flex justify-content-between"><span>Completed</span><strong>{{ $stats['completed'] }}</strong></div>
						<div class="d-flex justify-content-between"><span>Hold</span><strong>{{ $stats['hold'] }}</strong></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row g-3 mb-3">
		{{-- Recent contacts --}}
		<div class="col-xxl-8 col-lg-7">
			<div class="card h-100">
				<div class="card-header border-0 pb-0 d-flex align-items-center justify-content-between">
					<h6 class="mb-0">Recent Contact Submissions</h6>
					<a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-outline-primary">View all</a>
				</div>
				<div class="card-body table-responsive">
					<table class="table mb-0">
						<thead>
							<tr>
								<th>Name</th>
								<th>Service</th>
								<th>Status</th>
								<th>Date</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@forelse ($recentContacts as $contact)
								@php
									$badge = match ($contact->status) {
										'pending' => 'warning',
										'followup' => 'info',
										'completed' => 'success',
										default => 'secondary',
									};
								@endphp
								<tr>
									<td>
										<div class="fw-semibold">{{ $contact->fullName() }}</div>
										<div class="text-muted text-1xs">{{ $contact->email }}</div>
									</td>
									<td>{{ $contact->service ?: '—' }}</td>
									<td><span class="badge bg-{{ $badge }}">{{ ucfirst($contact->status) }}</span></td>
									<td>{{ $contact->created_at?->format('d M Y') }}</td>
									<td class="text-end">
										<a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-sm btn-outline-primary">View</a>
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="5" class="text-muted">No contact submissions yet.</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>

		{{-- Requested services + content inventory --}}
		<div class="col-xxl-4 col-lg-5">
			<div class="card mb-3">
				<div class="card-header border-0 pb-0">
					<h6 class="mb-0">Top Requested Services</h6>
				</div>
				<div class="card-body">
					@forelse ($serviceBreakdown as $row)
						<div class="d-flex justify-content-between align-items-center py-2 {{ ! $loop->last ? 'border-bottom' : '' }}">
							<span>{{ $row->service }}</span>
							<strong>{{ $row->total }}</strong>
						</div>
					@empty
						<p class="text-muted mb-0">No service requests yet.</p>
					@endforelse
				</div>
			</div>

			<div class="card">
				<div class="card-header border-0 pb-0">
					<h6 class="mb-0">Website Content</h6>
				</div>
				<div class="card-body">
					<div class="row g-2">
						<a href="{{ route('admin.blogs.index') }}" class="col-6 text-decoration-none">
							<div class="dashboard-mini-stat">
								<div class="text-muted text-1xs">Blog Posts</div>
								<div class="fw-semibold text-dark">{{ $stats['blogs_published'] }}/{{ $stats['blogs_total'] }}</div>
								<div class="text-muted text-1xs">published</div>
							</div>
						</a>
						<a href="{{ route('admin.products.index') }}" class="col-6 text-decoration-none">
							<div class="dashboard-mini-stat">
								<div class="text-muted text-1xs">Products</div>
								<div class="fw-semibold text-dark">{{ $stats['products_active'] }}</div>
								<div class="text-muted text-1xs">active</div>
							</div>
						</a>
						<a href="{{ route('admin.services.index') }}" class="col-6 text-decoration-none">
							<div class="dashboard-mini-stat">
								<div class="text-muted text-1xs">Services</div>
								<div class="fw-semibold text-dark">{{ $stats['services_active'] }}</div>
								<div class="text-muted text-1xs">active</div>
							</div>
						</a>
						<a href="{{ route('admin.team.index') }}" class="col-6 text-decoration-none">
							<div class="dashboard-mini-stat">
								<div class="text-muted text-1xs">Team</div>
								<div class="fw-semibold text-dark">{{ $stats['team_active'] }}</div>
								<div class="text-muted text-1xs">members</div>
							</div>
						</a>
						<a href="{{ route('admin.faqs.index') }}" class="col-6 text-decoration-none">
							<div class="dashboard-mini-stat">
								<div class="text-muted text-1xs">FAQs</div>
								<div class="fw-semibold text-dark">{{ $stats['faqs_active'] }}</div>
								<div class="text-muted text-1xs">active</div>
							</div>
						</a>
						<a href="{{ route('admin.hero-slides.index') }}" class="col-6 text-decoration-none">
							<div class="dashboard-mini-stat">
								<div class="text-muted text-1xs">Hero Slides</div>
								<div class="fw-semibold text-dark">{{ $stats['hero_active'] }}</div>
								<div class="text-muted text-1xs">active</div>
							</div>
						</a>
						<a href="{{ route('admin.seo.index') }}" class="col-6 text-decoration-none">
							<div class="dashboard-mini-stat">
								<div class="text-muted text-1xs">SEO Pages</div>
								<div class="fw-semibold text-dark">{{ $stats['seo_pages'] }}</div>
								<div class="text-muted text-1xs">configured</div>
							</div>
						</a>
						<a href="{{ route('admin.users.index') }}" class="col-6 text-decoration-none">
							<div class="dashboard-mini-stat">
								<div class="text-muted text-1xs">Users</div>
								<div class="fw-semibold text-dark">{{ $stats['users_total'] }}</div>
								<div class="text-muted text-1xs">admins</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
	const chartData = @json($chart);
	const primary = getComputedStyle(document.documentElement).getPropertyValue('--bs-primary').trim() || '#4f46e5';

	if (typeof ApexCharts === 'undefined') {
		return;
	}

	const trendEl = document.querySelector('#chartContactsTrend');
	if (trendEl) {
		new ApexCharts(trendEl, {
			chart: {
				type: 'area',
				height: 280,
				toolbar: { show: false },
				fontFamily: 'inherit',
			},
			series: [{ name: 'Contacts', data: chartData.values }],
			xaxis: {
				categories: chartData.labels,
				axisBorder: { show: false },
				axisTicks: { show: false },
			},
			yaxis: {
				min: 0,
				forceNiceScale: true,
				labels: {
					formatter: function (val) {
						return Math.round(val);
					}
				}
			},
			dataLabels: { enabled: false },
			stroke: { curve: 'smooth', width: 3 },
			fill: {
				type: 'gradient',
				gradient: {
					shadeIntensity: 1,
					opacityFrom: 0.35,
					opacityTo: 0.05,
					stops: [0, 90, 100],
				},
			},
			colors: [primary],
			grid: {
				borderColor: 'rgba(0,0,0,0.06)',
				strokeDashArray: 4,
			},
			tooltip: {
				y: {
					formatter: function (val) {
						return val + ' submissions';
					}
				}
			},
		}).render();
	}

	const statusEl = document.querySelector('#chartLeadStatus');
	if (statusEl) {
		const hasData = chartData.status_values.some(function (v) { return v > 0; });
		new ApexCharts(statusEl, {
			chart: {
				type: 'donut',
				height: 220,
				fontFamily: 'inherit',
			},
			series: hasData ? chartData.status_values : [1],
			labels: hasData ? chartData.status_labels : ['No data'],
			colors: hasData
				? ['#f59e0b', '#0ea5e9', '#22c55e', '#94a3b8']
				: ['#e2e8f0'],
			legend: { show: false },
			dataLabels: { enabled: false },
			plotOptions: {
				pie: {
					donut: {
						size: '72%',
						labels: {
							show: true,
							total: {
								show: true,
								label: 'Total',
								formatter: function () {
									return chartData.status_values.reduce(function (a, b) { return a + b; }, 0);
								}
							}
						}
					}
				}
			},
			stroke: { width: 0 },
		}).render();
	}
});
</script>
@endpush
