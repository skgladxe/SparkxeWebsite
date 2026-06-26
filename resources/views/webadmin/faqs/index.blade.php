@extends('webadmin.layouts.app')
@section('title', 'FAQs')
@section('content')
<div class="container-fluid">
	<div class="d-flex justify-content-between mb-4">
		<x-webadmin::page-breadcrumb title="FAQs" :home-url="route('admin.dashboard')" />
		<a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">Add FAQ</a>
	</div>
	@include('webadmin.partials.alerts')
	<div class="card"><div class="card-body table-responsive">
		<table class="table"><thead><tr><th>Question</th><th>Active</th><th>Open</th><th></th></tr></thead><tbody>
		@foreach($faqs as $faq)
		<tr><td>{{ Str::limit($faq->question, 80) }}</td><td>{{ $faq->is_active ? 'Yes' : 'No' }}</td><td>{{ $faq->is_open_default ? 'Yes' : 'No' }}</td>
		<td class="text-end"><a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-sm btn-outline-primary">Edit</a>
		<form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form></td></tr>
		@endforeach</tbody></table>
	</div></div>
</div>
@endsection
