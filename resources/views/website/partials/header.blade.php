<!-- Header -->
	<header class="main-header">
		<div class="header-sticky">
			<div class="nav-shell">
				<nav class="navbar navbar-expand-lg">
					<div class="container">
						<div class="mobile-nav-row d-lg-none">
							<a class="navbar-brand" href="{{ route('website.home') }}">
								<img src="{{ $siteLogoUrl ?? \App\Models\SiteSetting::websiteNavLogoUrl() }}" alt="{{ config('website.name') }}">
							</a>
							<button class="mobile-menu-btn" type="button" aria-label="Open menu">
								<span></span><span></span><span></span>
							</button>
						</div>

						<div class="mobile-menu-panel d-lg-none" id="mobileMenu">
							<ul class="mobile-nav-list">
								<li><a href="{{ route('website.home') }}" class="{{ request()->routeIs('website.home') ? 'active' : '' }}">Home</a></li>
								<li><a href="{{ route('website.about') }}" class="{{ request()->routeIs('website.about') ? 'active' : '' }}">About</a></li>
								<li><a href="{{ route('website.team') }}" class="{{ request()->routeIs('website.team') ? 'active' : '' }}">Team</a></li>
								<li class="mobile-has-sub{{ request()->routeIs('website.products.*') ? ' active' : '' }}">
									<button type="button" class="mobile-sub-toggle{{ request()->routeIs('website.products.*') ? ' active' : '' }}">Our Products <i class="fa-solid fa-chevron-down"></i></button>
									<ul class="mobile-sub-menu">
										<li><a href="{{ route('website.home') }}#services">All Products</a></li>
										@foreach ($menuProducts ?? [] as $product)
											@if ($product->slug)
												<li><a href="{{ route('website.products.show', $product->slug) }}" class="{{ request()->routeIs('website.products.show') && request()->route('slug') === $product->slug ? 'active' : '' }}">{{ $product->title }}</a></li>
											@endif
										@endforeach
									</ul>
								</li>
								<li><a href="{{ route('website.services.index') }}" class="{{ request()->routeIs('website.services.*') ? 'active' : '' }}">Services</a></li>
								<li><a href="{{ route('website.blog') }}" class="{{ request()->routeIs('website.blog*') ? 'active' : '' }}">Blog</a></li>
								<li><a href="{{ route('website.faq') }}" class="{{ request()->routeIs('website.faq') ? 'active' : '' }}">FAQ</a></li>
								<li><a href="{{ route('website.contact') }}" class="{{ request()->routeIs('website.contact') ? 'active' : '' }}">Contact Us</a></li>
							</ul>
							<div class="mobile-cta">
								<a href="{{ route('website.contact') }}" class="btn-default">Get Started</a>
							</div>
						</div>

						<a class="navbar-brand d-none d-lg-block" href="{{ route('website.home') }}">
							<img src="{{ $siteLogoUrl ?? \App\Models\SiteSetting::websiteNavLogoUrl() }}" alt="{{ config('website.name') }}">
						</a>

						<div class="collapse navbar-collapse main-menu">
							<div class="nav-menu-wrapper">
								<ul class="navbar-nav mr-auto" id="menu">
									<li class="nav-item{{ request()->routeIs('website.home') ? ' active' : '' }}">
										<a class="nav-link{{ request()->routeIs('website.home') ? ' active' : '' }}" href="{{ route('website.home') }}">Home</a>
									</li>
									<li class="nav-item{{ request()->routeIs('website.about') ? ' active' : '' }}">
										<a class="nav-link{{ request()->routeIs('website.about') ? ' active' : '' }}" href="{{ route('website.about') }}">About</a>
									</li>
									<li class="nav-item{{ request()->routeIs('website.team') ? ' active' : '' }}">
										<a class="nav-link{{ request()->routeIs('website.team') ? ' active' : '' }}" href="{{ route('website.team') }}">Team</a>
									</li>

									<li class="nav-item has-dropdown has-mega{{ request()->routeIs('website.products.*') ? ' active' : '' }}">
										<a class="nav-link{{ request()->routeIs('website.products.*') ? ' active' : '' }}" href="{{ route('website.home') }}#services">Our Products <i class="fa-solid fa-chevron-down nav-chevron"></i></a>
										<div class="mega-menu">
											<div class="mega-menu-inner">
												<div class="mega-feature">
													<div class="mega-feature-icon"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
													<h4>Smart Digital Products</h4>
													<p>Marketing, software, apps &amp; design — solutions built for real business growth.</p>
													<a href="{{ route('website.home') }}#services">View all products <i class="fa-solid fa-arrow-right"></i></a>
												</div>
												<div class="mega-columns">
													@php
														$chunks = collect($menuProducts ?? [])->chunk(max(1, (int) ceil(max(1, ($menuProducts ?? collect())->count()) / 2)));
													@endphp
													@foreach ($chunks as $chunkIndex => $products)
														<div class="mega-col">
															@if ($chunkIndex === 0)
																<h5>Our Products</h5>
															@else
																<h5>&nbsp;</h5>
															@endif
															<ul>
																@foreach ($products as $product)
																	@if ($product->slug)
																		<li>
																			<a href="{{ route('website.products.show', $product->slug) }}" class="{{ request()->routeIs('website.products.show') && request()->route('slug') === $product->slug ? 'active' : '' }}">
																				@if ($product->iconClass())<i class="{{ $product->iconClass() }}"></i>@endif
																				{{ $product->title }}
																			</a>
																		</li>
																	@endif
																@endforeach
															</ul>
														</div>
													@endforeach
												</div>
											</div>
										</div>
									</li>

									<li class="nav-item{{ request()->routeIs('website.services.*') ? ' active' : '' }}">
										<a class="nav-link{{ request()->routeIs('website.services.*') ? ' active' : '' }}" href="{{ route('website.services.index') }}">Services</a>
									</li>
									<li class="nav-item{{ request()->routeIs('website.blog*') ? ' active' : '' }}">
										<a class="nav-link{{ request()->routeIs('website.blog*') ? ' active' : '' }}" href="{{ route('website.blog') }}">Blog</a>
									</li>
									<li class="nav-item{{ request()->routeIs('website.faq') ? ' active' : '' }}">
										<a class="nav-link{{ request()->routeIs('website.faq') ? ' active' : '' }}" href="{{ route('website.faq') }}">FAQ</a>
									</li>
									<li class="nav-item{{ request()->routeIs('website.contact') ? ' active' : '' }}">
										<a class="nav-link{{ request()->routeIs('website.contact') ? ' active' : '' }}" href="{{ route('website.contact') }}">Contact Us</a>
									</li>
								</ul>
							</div>
							<div class="header-btn d-inline-flex">
								<a href="{{ route('website.contact') }}" class="btn-default">Get Started</a>
							</div>
						</div>
					</div>
				</nav>
			</div>
		</div>
	</header>
