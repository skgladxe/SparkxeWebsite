<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\ContactSubmission;
use App\Models\Faq;
use App\Models\HeroSlide;
use App\Models\NewsletterSubscriber;
use App\Models\Product;
use App\Models\SeoMeta;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $now = Carbon::now();
        $startThisMonth = $now->copy()->startOfMonth();
        $startLastMonth = $now->copy()->subMonthNoOverflow()->startOfMonth();
        $endLastMonth = $now->copy()->subMonthNoOverflow()->endOfMonth();

        $contactsTotal = ContactSubmission::query()->count();
        $contactsThisMonth = ContactSubmission::query()->where('created_at', '>=', $startThisMonth)->count();
        $contactsLastMonth = ContactSubmission::query()
            ->whereBetween('created_at', [$startLastMonth, $endLastMonth])
            ->count();

        $statusCounts = ContactSubmission::query()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $pending = (int) ($statusCounts['pending'] ?? 0);
        $followup = (int) ($statusCounts['followup'] ?? 0);
        $completed = (int) ($statusCounts['completed'] ?? 0);
        $hold = (int) ($statusCounts['hold'] ?? 0);
        $openLeads = $pending + $followup + $hold;

        $newsletterTotal = NewsletterSubscriber::query()->count();
        $newsletterThisMonth = NewsletterSubscriber::query()
            ->where(function ($query) use ($startThisMonth) {
                $query->where('subscribed_at', '>=', $startThisMonth)
                    ->orWhere(function ($inner) use ($startThisMonth) {
                        $inner->whereNull('subscribed_at')
                            ->where('created_at', '>=', $startThisMonth);
                    });
            })
            ->count();

        $blogsTotal = Blog::query()->count();
        $blogsPublished = Blog::query()->where('is_published', true)->count();
        $productsActive = Product::query()->where('is_active', true)->count();
        $servicesActive = Service::query()->where('is_active', true)->count();
        $teamActive = TeamMember::query()->where('is_active', true)->count();
        $faqsActive = Faq::query()->where('is_active', true)->count();
        $heroActive = HeroSlide::query()->where('is_active', true)->count();
        $seoPages = SeoMeta::query()->count();
        $usersTotal = User::query()->count();

        $recentContacts = ContactSubmission::query()
            ->latest()
            ->limit(8)
            ->get();

        $chartLabels = [];
        $chartValues = [];
        $rangeStart = $now->copy()->subMonthsNoOverflow(5)->startOfMonth();
        $monthlyRows = ContactSubmission::query()
            ->where('created_at', '>=', $rangeStart)
            ->get(['created_at'])
            ->groupBy(fn ($row) => $row->created_at->format('Y-m'))
            ->map->count();

        for ($i = 5; $i >= 0; $i--) {
            $month = $now->copy()->subMonthsNoOverflow($i);
            $chartLabels[] = $month->format('M Y');
            $chartValues[] = (int) ($monthlyRows[$month->format('Y-m')] ?? 0);
        }

        $serviceBreakdown = ContactSubmission::query()
            ->select('service', DB::raw('count(*) as total'))
            ->whereNotNull('service')
            ->where('service', '!=', '')
            ->groupBy('service')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        return view('webadmin.dashboard.index', [
            'stats' => [
                'contacts_total' => $contactsTotal,
                'contacts_this_month' => $contactsThisMonth,
                'contacts_last_month' => $contactsLastMonth,
                'contacts_change' => $this->percentChange($contactsThisMonth, $contactsLastMonth),
                'pending' => $pending,
                'followup' => $followup,
                'completed' => $completed,
                'hold' => $hold,
                'open_leads' => $openLeads,
                'newsletter_total' => $newsletterTotal,
                'newsletter_this_month' => $newsletterThisMonth,
                'blogs_total' => $blogsTotal,
                'blogs_published' => $blogsPublished,
                'blogs_draft' => max($blogsTotal - $blogsPublished, 0),
                'products_active' => $productsActive,
                'services_active' => $servicesActive,
                'team_active' => $teamActive,
                'faqs_active' => $faqsActive,
                'hero_active' => $heroActive,
                'seo_pages' => $seoPages,
                'users_total' => $usersTotal,
            ],
            'recentContacts' => $recentContacts,
            'serviceBreakdown' => $serviceBreakdown,
            'chart' => [
                'labels' => $chartLabels,
                'values' => $chartValues,
                'status_labels' => ['Pending', 'Follow-up', 'Completed', 'Hold'],
                'status_values' => [$pending, $followup, $completed, $hold],
            ],
        ]);
    }

    public function showLogin(Request $request): View|RedirectResponse
    {
        if ($request->user()) {
            return redirect()->route('admin.dashboard');
        }

        $request->session()->regenerateToken();

        return view('webadmin.auth.login');
    }

    private function percentChange(int $current, int $previous): float
    {
        if ($previous === 0) {
            return $current > 0 ? 100.0 : 0.0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }
}
