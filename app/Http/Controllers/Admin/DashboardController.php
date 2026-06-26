<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('webadmin.dashboard.index');
    }

    public function showLogin(Request $request): View|RedirectResponse
    {
        if ($request->user()) {
            return redirect()->route('admin.dashboard');
        }

        $request->session()->regenerateToken();

        return view('webadmin.auth.login');
    }
}
