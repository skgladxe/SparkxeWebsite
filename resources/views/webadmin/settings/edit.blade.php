@extends('webadmin.layouts.app')
@section('title', 'Logo & Settings')
@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Logo & Settings" :home-url="route('admin.dashboard')" />
	@include('webadmin.partials.alerts')
	<div class="card"><div class="card-body">
		<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">@csrf @method('PUT')
			<div class="mb-3"><label class="form-label">Current Logo</label><div><img src="{{ $logoUrl }}" alt="Logo" height="48" class="border rounded p-2"></div></div>
			<div class="mb-3"><label class="form-label">Upload New Logo</label><input type="file" name="logo" class="form-control" accept="image/*"></div>
			<p class="text-muted small">Recommended: SVG or PNG with transparent background. Used on website header and admin login.</p>
			<button class="btn btn-primary">Save Logo</button>
		</form>
	</div></div>
</div>
@endsection
