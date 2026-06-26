<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeamMemberController extends Controller
{
    public function index(): View
    {
        return view('webadmin.team.index', [
            'members' => TeamMember::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('webadmin.team.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateMember($request);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('team', 'public');
        }

        TeamMember::create($validated);

        return redirect()->route('admin.team.index')->with('success', 'Team member added.');
    }

    public function edit(TeamMember $team): View
    {
        return view('webadmin.team.edit', ['member' => $team]);
    }

    public function update(Request $request, TeamMember $team): RedirectResponse
    {
        $validated = $this->validateMember($request);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('team', 'public');
        } else {
            unset($validated['photo']);
        }

        $team->update($validated);

        return redirect()->route('admin.team.index')->with('success', 'Team member updated.');
    }

    public function destroy(TeamMember $team): RedirectResponse
    {
        $team->delete();

        return redirect()->route('admin.team.index')->with('success', 'Team member removed.');
    }

    private function validateMember(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'role' => ['required', 'string', 'max:150'],
            'photo' => ['nullable', 'image', 'max:5120'],
            'linkedin' => ['nullable', 'url', 'max:500'],
            'twitter' => ['nullable', 'url', 'max:500'],
            'github' => ['nullable', 'url', 'max:500'],
            'dribbble' => ['nullable', 'url', 'max:500'],
            'instagram' => ['nullable', 'url', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]) + [
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => (int) ($request->input('sort_order', 0)),
        ];
    }
}
