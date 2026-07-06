<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HeroSlideController extends Controller
{
    private const MAX_SLIDES = 5;

    public function index(): View
    {
        return view('webadmin.hero-slides.index', [
            'slides' => HeroSlide::query()->orderBy('sort_order')->get(),
            'canAdd' => HeroSlide::query()->count() < self::MAX_SLIDES,
            'maxSlides' => self::MAX_SLIDES,
        ]);
    }

    public function create(): View|RedirectResponse
    {
        if (HeroSlide::query()->count() >= self::MAX_SLIDES) {
            return redirect()->route('admin.hero-slides.index')
                ->with('error', 'Maximum of '.self::MAX_SLIDES.' hero slides allowed.');
        }

        return view('webadmin.hero-slides.create');
    }

    public function store(Request $request): RedirectResponse
    {
        if (HeroSlide::query()->count() >= self::MAX_SLIDES) {
            return redirect()->route('admin.hero-slides.index')
                ->with('error', 'Maximum of '.self::MAX_SLIDES.' hero slides allowed.');
        }

        $validated = $this->validateSlide($request);

        foreach (['main_image', 'left_image', 'right_image'] as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('hero', 'public');
            }
        }

        HeroSlide::create($validated);

        return redirect()->route('admin.hero-slides.index')->with('success', 'Hero slide created.');
    }

    public function edit(HeroSlide $heroSlide): View
    {
        return view('webadmin.hero-slides.edit', ['slide' => $heroSlide]);
    }

    public function update(Request $request, HeroSlide $heroSlide): RedirectResponse
    {
        $validated = $this->validateSlide($request, $heroSlide);

        foreach (['main_image', 'left_image', 'right_image'] as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('hero', 'public');
            } else {
                unset($validated[$field]);
            }
        }

        $heroSlide->update($validated);

        return redirect()->route('admin.hero-slides.index')->with('success', 'Hero slide updated.');
    }

    public function destroy(HeroSlide $heroSlide): RedirectResponse
    {
        $heroSlide->delete();

        return redirect()->route('admin.hero-slides.index')->with('success', 'Hero slide deleted.');
    }

    private function validateSlide(Request $request, ?HeroSlide $slide = null): array
    {
        $rules = [
            'subtitle' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:500'],
            'title_highlight' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'primary_button_text' => ['required', 'string', 'max:100'],
            'primary_button_url' => ['required', 'string', 'max:500'],
            'secondary_button_text' => ['nullable', 'string', 'max:100'],
            'secondary_button_url' => ['nullable', 'string', 'max:500'],
            'main_image' => [$slide ? 'nullable' : 'nullable', 'image', 'max:5120'],
            'left_image' => ['nullable', 'image', 'max:5120'],
            'right_image' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];

        return $request->validate($rules) + [
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => (int) ($request->input('sort_order', 0)),
        ];
    }
}
