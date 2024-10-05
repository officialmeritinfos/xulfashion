{
"name": "{{config('app.name')}} Business",
"short_name": "Xul Business",
"description": "Xulfashion Business helps fashion creators manage their storefront and clients with ease.",
"start_url": "{{ route('mobile.index') }}",
"scope": "/",
"display": "standalone",
"background_color": "#ffffff",
"theme_color": "#000000",
"icons": [
{
"src": "{{ asset('home/image/xulfashion_business.png') }}",
"sizes": "72x72",
"type": "image/png"
},
{
"src": "{{ asset('home/image/xulfashion_business.png') }}",
"sizes": "96x96",
"type": "image/png"
},
{
"src": "{{ asset('home/image/xulfashion_business.png') }}",
"sizes": "128x128",
"type": "image/png"
},
{
"src": "{{ asset('home/image/xulfashion_business.png') }}",
"sizes": "144x144",
"type": "image/png"
},
{
"src": "{{ asset('home/image/xulfashion_business.png') }}",
"sizes": "152x152",
"type": "image/png"
},
{
"src": "{{ asset('home/image/xulfashion_business.png') }}",
"sizes": "192x192",
"type": "image/png"
},
{
"src": "{{ asset('home/image/xulfashion_business.png') }}",
"sizes": "384x384",
"type": "image/png"
},
{
"src": "{{ asset('home/image/xulfashion_business.png') }}",
"sizes": "512x512",
"type": "image/png"
}
],
"splash_screens": [
{
"src": "{{ asset('home/image/xulfashion_business.png') }}",
"sizes": "512x512",
"type": "image/png"
}
],
"orientation": "portrait",
"prefer_related_applications": false,
"dir": "ltr",
"lang": "en",
"categories": ["business", "fashion", "productivity"]
}
