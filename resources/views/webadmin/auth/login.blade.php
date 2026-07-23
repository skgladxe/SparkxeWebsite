@extends('webadmin.layouts.auth')

@section('title', 'Login — '.($adminLogoText ?? \App\Models\SiteSetting::adminLogoText()))

@section('content')
<div class="auth-cover-wrapper">
	<div class="row g-0 min-vh-100">
		<div class="col-lg-6 col-xl-5">
			<div class="form-wrapper d-flex align-items-center justify-content-center min-vh-100 p-4 p-md-5">
				<div class="w-100" style="max-width: 420px;">
					<div class="text-center mb-4">
						<a href="{{ route('website.home') }}" class="d-inline-block mb-3">
							<img src="{{ $adminLogoUrl ?? \App\Models\SiteSetting::adminLogoUrl() }}" alt="{{ $adminLogoText ?? \App\Models\SiteSetting::adminLogoText() }}" height="42">
						</a>
						@if($adminLogoTextImageUrl ?? \App\Models\SiteSetting::adminLogoTextImageUrl())
							<div class="mb-2">
								<img src="{{ $adminLogoTextImageUrl ?? \App\Models\SiteSetting::adminLogoTextImageUrl() }}" alt="{{ $adminLogoText ?? \App\Models\SiteSetting::adminLogoText() }}" height="32">
							</div>
						@else
							<h4 class="mb-1">Welcome to {{ $adminLogoText ?? \App\Models\SiteSetting::adminLogoText() }}</h4>
						@endif
						<p class="text-muted mb-0">Sign in to manage your Sparkxe website.</p>
					</div>

					@if ($errors->any())
						<div class="alert alert-danger">
							@foreach ($errors->all() as $error)
								<div>{{ $error }}</div>
							@endforeach
						</div>
					@endif

					<form method="POST" action="{{ route('admin.login.store') }}">
						@csrf
						<div class="mb-3">
							<label for="email" class="form-label">Email Address</label>
							<input type="email" class="form-control" id="email" name="email"
								value="{{ old('email') }}" placeholder="admin@sparkxe.com" required autofocus>
						</div>
						<div class="mb-3">
							<label for="password" class="form-label">Password</label>
							<div class="input-group">
								<input type="password" class="form-control" id="password" name="password"
									placeholder="********" required>
								<button class="btn btn-outline-secondary password-toggle" type="button" tabindex="-1">
									<i class="fi fi-rr-eye"></i>
								</button>
							</div>
						</div>
						<div class="mb-4 form-check">
							<input type="checkbox" class="form-check-input" id="remember" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
							<label class="form-check-label" for="remember">Keep me logged in</label>
						</div>
						<button type="submit" class="btn btn-primary w-100 py-2">Sign in</button>
					</form>

					<p class="text-center text-muted small mt-4 mb-0">
						<a href="{{ route('website.home') }}">← Back to website</a>
					</p>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-xl-7 d-none d-lg-block">
			<div class="auth-cover min-vh-100">
				<div class="auth-content">
					<h2 class="mb-3">Welcome Back!</h2>
					<p>Sparkxe admin — manage SEO, blogs, team, FAQs, contact leads, and your dynamic logo from one secure dashboard.</p>
					<a href="{{ route('website.home') }}" class="btn btn-outline-primary mt-3">Visit Website</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.password-toggle').forEach(function (btn) {
	btn.addEventListener('click', function () {
		const input = this.closest('.input-group').querySelector('input');
		input.type = input.type === 'password' ? 'text' : 'password';
	});
});
</script>
@endpush
