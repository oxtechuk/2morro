<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SiteVisit;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TrackSiteVisit
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track successful GET requests for actual pages
        if ($request->isMethod('GET') && !$request->ajax() && $response->getStatusCode() < 400) {
            $this->recordVisitSafely($request);
        }

        return $response;
    }

    /**
     * Record visit without affecting response time or causing exceptions.
     */
    protected function recordVisitSafely(Request $request): void
    {
        try {
            $path = $request->path();

            // Skip admin, api, debug, and assets paths
            if ($request->is('admin*', 'api*', 'storage*', 'assets*', 'images*', 'fonts*', 'build*', 'css*', 'js*', 'livewire*', '_debugbar*')) {
                return;
            }

            $userAgent = $request->userAgent() ?? '';
            $uaLower = strtolower($userAgent);

            // Skip common crawlers & bots
            if (empty($userAgent) || Str::contains($uaLower, [
                'bot', 'crawl', 'spider', 'slurp', 'mediapartners', 'lighthouse', 'googlebot', 'bingbot', 'yandex', 'baidu', 'facebookexternalhit'
            ])) {
                return;
            }

            // Salted IP hash for privacy
            $ipHash = hash('sha256', ($request->ip() ?? '127.0.0.1') . config('app.key'));

            // Route & Page Classification
            $routeName = $request->route() ? $request->route()->getName() : null;
            $pageType = 'page';
            $entityId = null;

            if ($routeName === 'home' || $path === '/') {
                $pageType = 'home';
            } elseif ($routeName === 'product') {
                $pageType = 'product';
                $productParam = $request->route('product');
                if ($productParam instanceof \App\Models\Product) {
                    $entityId = $productParam->id;
                }
            } elseif (Str::startsWith($routeName ?? '', 'doctor-videos')) {
                $pageType = 'doctor_video';
            } elseif (Str::startsWith($routeName ?? '', 'booking')) {
                $pageType = 'booking';
            } elseif (Str::startsWith($routeName ?? '', 'checkout')) {
                $pageType = 'checkout';
            } elseif ($routeName === 'search') {
                $pageType = 'search';
            }

            $referer = $request->headers->get('referer');
            $utmSource = $request->get('utm_source');
            $source = SiteVisit::detectSource($referer, $utmSource);
            $deviceType = SiteVisit::detectDevice($userAgent);
            $browser = SiteVisit::detectBrowser($userAgent);

            SiteVisit::create([
                'ip_hash'      => $ipHash,
                'url'          => Str::limit($request->fullUrl(), 500),
                'path'         => Str::limit($path, 250),
                'route_name'   => $routeName,
                'page_type'    => $pageType,
                'entity_id'    => $entityId,
                'referer'      => Str::limit($referer, 500),
                'source'       => $source,
                'utm_source'   => Str::limit($utmSource, 100),
                'utm_medium'   => Str::limit($request->get('utm_medium'), 100),
                'utm_campaign' => Str::limit($request->get('utm_campaign'), 100),
                'device_type'  => $deviceType,
                'browser'      => $browser,
                'platform'     => Str::limit($request->header('sec-ch-ua-platform'), 50),
                'user_id'      => Auth::id(),
                'created_at'   => now(),
            ]);
        } catch (\Throwable $e) {
            // Silently continue to prevent breaking user flow
        }
    }
}

