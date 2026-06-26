@extends('webadmin.layouts.app')
@section('title', 'Add FAQ')
@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Add FAQ" :home-url="route('admin.faqs.index')" />
	<div class="card"><div class="card-body">
		<form method="POST" action="{{ route('admin.faqs.store') }}">@csrf
			@include('webadmin.faqs._form')
			<button class="btn btn-primary">Save</button>
		</form>
	</div></div>
</div>
@endsection
