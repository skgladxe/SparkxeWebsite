@extends('webadmin.layouts.app')
@section('title', 'Edit FAQ')
@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Edit FAQ" :home-url="route('admin.faqs.index')" />
	<div class="card"><div class="card-body">
		<form method="POST" action="{{ route('admin.faqs.update', $faq) }}">@csrf @method('PUT')
			@include('webadmin.faqs._form', ['faq' => $faq])
			<button class="btn btn-primary">Update</button>
		</form>
	</div></div>
</div>
@endsection
