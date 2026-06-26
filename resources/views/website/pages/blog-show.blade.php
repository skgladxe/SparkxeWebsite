@extends('website.layouts.website')

@section('content')
	<article class="blog-detail-page">
		<div class="container">
			<nav class="blog-detail-breadcrumb" aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('website.home') }}">Home</a></li>
					<li class="breadcrumb-item"><a href="{{ route('website.blog') }}">Blog</a></li>
					<li class="breadcrumb-item active" aria-current="page">{{ Str::limit($blog->title, 50) }}</li>
				</ol>
			</nav>

			<div class="blog-detail-hero wow fadeInUp">
				<div class="blog-detail-thumb">
					<img src="{{ $blog->imageUrl() }}" alt="{{ $blog->title }}">
				</div>
				<div class="blog-detail-header">
					@if ($blog->category)
						<span class="blog-detail-category">{{ $blog->category->name }}</span>
					@endif
					<h1 class="blog-detail-title">{{ $blog->title }}</h1>
					<p class="blog-detail-meta">
						<i class="fa-regular fa-calendar"></i> {{ $blog->published_at?->format('F j, Y') }}
						<span class="mx-2">·</span>
						<i class="fa-regular fa-clock"></i> {{ $blog->read_time }} min read
					</p>
					@if ($blog->excerpt)
						<p class="blog-detail-excerpt">{{ $blog->excerpt }}</p>
					@endif
				</div>
			</div>

			<div class="blog-detail-content wow fadeInUp" data-wow-delay="0.1s">
				{!! $blog->content !!}
			</div>

			@if ($relatedBlogs->count())
				<div class="blog-related mt-5">
					<h3>Related Posts</h3>
					<div class="blog-grid">
						@foreach ($relatedBlogs as $post)
							<article class="blog-card">
								<div class="blog-card-thumb">
									<img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}">
									@if ($post->category)<span class="blog-card-tag">{{ $post->category->name }}</span>@endif
								</div>
								<div class="blog-card-body">
									<p class="blog-card-meta">{{ $post->published_at?->format('F j, Y') }} · {{ $post->read_time }} min read</p>
									<h3><a href="{{ route('website.blog.show', $post->slug) }}">{{ $post->title }}</a></h3>
									@if ($post->excerpt)<p>{{ Str::limit($post->excerpt, 120) }}</p>@endif
									<a href="{{ route('website.blog.show', $post->slug) }}" class="blog-read-more">Read more <i class="fa-solid fa-arrow-right"></i></a>
								</div>
							</article>
						@endforeach
					</div>
				</div>
			@endif
		</div>
	</article>

	@include('website.sections.cta-banner')
@endsection
