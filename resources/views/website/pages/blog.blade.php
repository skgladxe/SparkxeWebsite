@extends('website.layouts.website')

@section('content')
	@include('website.partials.page-hero', [
		'eyebrow' => 'Latest Insights',
		'title' => 'Tips and trends from the Sparkxe team',
		'highlight' => 'Sparkxe team',
		'description' => 'Practical advice on digital marketing, custom software, and design for modern businesses.',
		'breadcrumbs' => [
			['label' => 'Home', 'url' => route('website.home')],
			['label' => 'Blog'],
		],
	])

	<section class="spark-blog blog-page">
		<div class="container">
			<div class="blog-grid">
				@forelse ($blogs as $index => $post)
					<article class="blog-card wow fadeInUp" data-wow-delay="{{ ($index * 0.1).'s' }}">
						<div class="blog-card-thumb">
							<img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}">
							@if ($post->category)
								<span class="blog-card-tag">{{ $post->category->name }}</span>
							@endif
						</div>
						<div class="blog-card-body">
							<p class="blog-card-meta">{{ $post->published_at?->format('F j, Y') }} · {{ $post->read_time }} min read</p>
							<h3><a href="{{ route('website.blog.show', $post->slug) }}">{{ $post->title }}</a></h3>
							<p>{{ $post->excerpt }}</p>
							<a href="{{ route('website.blog.show', $post->slug) }}" class="blog-read-more">Read more <i class="fa-solid fa-arrow-right"></i></a>
						</div>
					</article>
				@empty
					<p>No blog posts published yet.</p>
				@endforelse
			</div>
		</div>
	</section>

	@include('website.sections.cta-banner')
@endsection
