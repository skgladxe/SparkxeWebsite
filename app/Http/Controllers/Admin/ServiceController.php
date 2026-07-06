<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('webadmin.services.index', [
            'services' => Service::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('webadmin.services.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateService($request);

        foreach (['image'] as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('services', 'public');
            }
        }

        if (blank($validated['slug'] ?? null)) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Service created.');
    }

    public function edit(Service $service): View
    {
        return view('webadmin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $this->validateService($request, $service);

        foreach (['image'] as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('services', 'public');
            } else {
                unset($validated[$field]);
            }
        }

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Service updated.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service deleted.');
    }

    private function validateService(Request $request, ?Service $service = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:services,slug,'.($service?->id ?? 'NULL')],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]) + [
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => (int) ($request->input('sort_order', 0)),
        ];
    }
}
