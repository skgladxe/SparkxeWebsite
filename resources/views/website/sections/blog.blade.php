<!-- Blog -->
	<section class="spark-blog" id="blog">
		<div class="container">
			<div class="row section-row align-items-end">
				<div class="col-lg-7">
					<div class="section-title">
						<h3 class="wow fadeInUp">Latest Insights</h3>
						<h2 class="wow fadeInUp" data-wow-delay="0.2s">Tips and trends from the <span>Sparkxe team</span></h2>
					</div>
				</div>
				<div class="col-lg-5 text-lg-end">
					<a href="{{ route('website.blog') }}" class="btn-default wow fadeInUp" data-wow-delay="0.3s">View All Posts</a>
				</div>
			</div>
			<div class="blog-grid">
				@forelse ($latestBlogs ?? [] as $index => $post)
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
					<p class="text-muted">No blog posts published yet.</p>
				@endforelse
			</div>
		</div>
	</section>
