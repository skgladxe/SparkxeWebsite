@extends('webadmin.layouts.app')
@section('title', 'Contact #'.$contact->id)
@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Contact Submission" :home-url="route('admin.contacts.index')" />
	@include('webadmin.partials.alerts')
	<div class="row g-4">
		<div class="col-lg-7">
			<div class="card"><div class="card-body">
				<p><strong>Name:</strong> {{ $contact->fullName() }}</p>
				<p><strong>Email:</strong> <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
				<p><strong>Phone:</strong> {{ $contact->phone ?? '—' }}</p>
				<p><strong>Service:</strong> {{ $contact->service ?? '—' }}</p>
				<p><strong>Message:</strong></p>
				<p class="border rounded p-3 bg-light">{{ $contact->message }}</p>
				<p class="text-muted small mb-0">Received {{ $contact->created_at->format('d M Y, h:i A') }}</p>
			</div></div>
		</div>
		<div class="col-lg-5">
			<div class="card"><div class="card-body">
				<form method="POST" action="{{ route('admin.contacts.update', $contact) }}">@csrf @method('PUT')
					<div class="mb-3"><label class="form-label">Status</label>
						<select name="status" class="form-select">
							@foreach(\App\Models\ContactSubmission::STATUSES as $status)
								<option value="{{ $status }}" @selected(old('status', $contact->status) === $status)>{{ ucfirst($status) }}</option>
							@endforeach
						</select>
					</div>
					<div class="mb-3"><label class="form-label">Admin Notes</label><textarea name="admin_notes" class="form-control" rows="4">{{ old('admin_notes', $contact->admin_notes) }}</textarea></div>
					<button class="btn btn-primary">Update Status</button>
				</form>
				<form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" class="mt-3" onsubmit="return confirm('Delete this submission?')">@csrf @method('DELETE')
					<button class="btn btn-outline-danger btn-sm">Delete</button>
				</form>
			</div></div>
		</div>
	</div>
</div>
@endsection
