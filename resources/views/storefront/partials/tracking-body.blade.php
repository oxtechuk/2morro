@php
    $gtmEnabled        = \App\Models\Setting::get('gtm_enabled', '0') === '1';
    $gtmId             = trim(\App\Models\Setting::get('gtm_container_id', ''));
    $customBodyScripts = \App\Models\Setting::get('custom_body_scripts', '');
@endphp

<!-- Google Tag Manager (noscript) -->
@if($gtmEnabled && !empty($gtmId))
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmId }}"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
@endif

<!-- Global E-commerce Tracking Bridge Helper -->
<script>
window.trackEcommerceEvent = function(eventName, payload) {
    payload = payload || {};
    
    // 1. Meta / Facebook Pixel
    if (typeof fbq === 'function') {
        fbq('track', eventName, payload);
    }

    // 2. TikTok Pixel
    if (typeof ttq === 'object' && typeof ttq.track === 'function') {
        let ttEvent = eventName;
        if (eventName === 'Purchase') ttEvent = 'CompletePayment';
        ttq.track(ttEvent, payload);
    }

    // 3. Google Analytics 4 (gtag)
    if (typeof gtag === 'function') {
        gtag('event', eventName, payload);
    }
};
</script>

<!-- Custom Body End Scripts -->
@if(!empty($customBodyScripts))
{!! $customBodyScripts !!}
@endif

