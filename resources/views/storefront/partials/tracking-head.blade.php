@php
    $metaPixelEnabled   = \App\Models\Setting::get('meta_pixel_enabled', '0') === '1';
    $metaPixelId        = trim(\App\Models\Setting::get('meta_pixel_id', ''));

    $tiktokPixelEnabled = \App\Models\Setting::get('tiktok_pixel_enabled', '0') === '1';
    $tiktokPixelId      = trim(\App\Models\Setting::get('tiktok_pixel_id', ''));

    $ga4Enabled         = \App\Models\Setting::get('ga4_enabled', '0') === '1';
    $ga4Id              = trim(\App\Models\Setting::get('ga4_measurement_id', ''));

    $gtmEnabled         = \App\Models\Setting::get('gtm_enabled', '0') === '1';
    $gtmId              = trim(\App\Models\Setting::get('gtm_container_id', ''));

    $adsenseEnabled     = \App\Models\Setting::get('adsense_enabled', '0') === '1';
    $adsensePublisherId = trim(str_replace('ca-pub-', '', \App\Models\Setting::get('adsense_publisher_id', '')));

    $customHeadScripts  = \App\Models\Setting::get('custom_head_scripts', '');
@endphp

<!-- 1. Meta / Facebook & Instagram Pixel -->
@if($metaPixelEnabled && !empty($metaPixelId))
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '{{ $metaPixelId }}');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id={{ $metaPixelId }}&ev=PageView&noscript=1"
/></noscript>
@endif

<!-- 2. TikTok Pixel -->
@if($tiktokPixelEnabled && !empty($tiktokPixelId))
<script>
!function (w, d, t) {
  w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie","holdConsent","revokeConsent","grantConsent"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(
var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var r="https://analytics.tiktok.com/i18n/pixel/events.js",o=n&&n.partner;ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=r,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};var a=document.createElement("script");a.type="text/javascript",a.async=!0,a.src=r+"?sdkid="+e+"&lib="+t;var c=document.getElementsByTagName("script")[0];c.parentNode.insertBefore(a,c)};
  ttq.load('{{ $tiktokPixelId }}');
  ttq.page();
}(window, document, 'ttq');
</script>
@endif

<!-- 3. Google Analytics 4 (GA4) -->
@if($ga4Enabled && !empty($ga4Id))
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga4Id }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '{{ $ga4Id }}');
</script>
@endif

<!-- 4. Google Tag Manager (GTM) -->
@if($gtmEnabled && !empty($gtmId))
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','{{ $gtmId }}');</script>
@endif

<!-- 5. Google AdSense (Auto Ads enabled, excluded on checkout) -->
@if($adsenseEnabled && !empty($adsensePublisherId) && !request()->is('checkout*'))
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-{{ $adsensePublisherId }}"
     crossorigin="anonymous"></script>
@endif

<!-- 6. Custom Head Scripts -->
@if(!empty($customHeadScripts))
{!! $customHeadScripts !!}
@endif

