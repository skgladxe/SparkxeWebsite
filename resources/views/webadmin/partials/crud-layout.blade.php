@extends('webadmin.layouts.app')

@section('title', $title.' — '.config('webadmin.name'))

@section('content')
<div class="container-fluid">
	<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
		<x-webadmin::page-breadcrumb :title="$title" :home-url="route('admin.dashboard')" />
		@if (!empty($actionUrl))
			<a href="{{ $actionUrl }}" class="btn btn-primary">{{ $actionLabel ?? 'Add New' }}</a>
		@endif
	</div>

	@include('webadmin.partials.alerts')

	<div class="card">
		<div class="card-body">
			{{ $slot }}
		</div>
	</div>
</div>
@endsection
