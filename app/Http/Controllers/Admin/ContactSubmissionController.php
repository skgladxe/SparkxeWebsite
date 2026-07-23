<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ContactSubmissionController extends Controller
{
    public function index(): View
    {
        return view('webadmin.contacts.index', [
            'contacts' => ContactSubmission::query()->latest()->paginate(15),
        ]);
    }

    public function show(ContactSubmission $contact): View
    {
        return view('webadmin.contacts.show', compact('contact'));
    }

    public function update(Request $request, ContactSubmission $contact): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(ContactSubmission::STATUSES)],
            'admin_notes' => ['nullable', 'string'],
        ]);

        $contact->update($validated);

        return redirect()->route('admin.contacts.show', $contact)->with('success', 'Contact updated.');
    }

    public function destroy(ContactSubmission $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'Contact deleted.');
    }
}
