{
"name": "{{config('app.name')}}",
"short_name": "{{config('app.name')}}",
"description": "{{config('app.name')}} Marketplace allows users to browse, book, and purchase fashion items from various creators.",
"start_url": "{{ route('mobile.app.base') }}",
"scope": "/mobile/app",
"display": "standalone",
"background_color": "#ffffff",
"theme_color": "#000000",
"icons": [
{
"src": "{{ asset('home/image/xulfashion_client.png') }}",
"sizes": "72x72",
"type": "image/png"
},
{
"src": "{{ asset('home/image/xulfashion_client.png') }}",
"sizes": "96x96",
"type": "image/png"
},
{
"src": "{{ asset('home/image/xulfashion_client.png') }}",
"sizes": "128x128",
"type": "image/png"
},
{
"src": "{{ asset('home/image/xulfashion_client.png') }}",
"sizes": "144x144",
"type": "image/png"
},
{
"src": "{{ asset('home/image/xulfashion_client.png') }}",
"sizes": "152x152",
"type": "image/png"
},
{
"src": "{{ asset('home/image/xulfashion_client.png') }}",
"sizes": "192x192",
"type": "image/png"
},
{
"src": "{{ asset('home/image/xulfashion_client.png') }}",
"sizes": "384x384",
"type": "image/png"
},
{
"src": "{{ asset('home/image/xulfashion_client.png') }}",
"sizes": "512x512",
"type": "image/png"
}
],
"splash_screens": [
{
"src": "{{ asset('home/image/xulfashion_client.png') }}",
"sizes": "72x72",
"type": "image/png"
},
{
"src": "{{ asset('home/image/xulfashion_client.png') }}",
"sizes": "96x96",
"type": "image/png"
},
{
"src": "{{ asset('home/image/xulfashion_client.png') }}",
"sizes": "128x128",
"type": "image/png"
},
{
"src": "{{ asset('home/image/xulfashion_client.png') }}",
"sizes": "144x144",
"type": "image/png"
},
{
"src": "{{ asset('home/image/xulfashion_client.png') }}",
"sizes": "152x152",
"type": "image/png"
},
{
"src": "{{ asset('home/image/xulfashion_client.png') }}",
"sizes": "192x192",
"type": "image/png"
},
{
"src": "{{ asset('home/image/xulfashion_client.png') }}",
"sizes": "384x384",
"type": "image/png"
},
{
"src": "{{ asset('home/image/xulfashion_client.png') }}",
"sizes": "512x512",
"type": "image/png"
}
],
"orientation": "any",
"prefer_related_applications": false,
"dir": "ltr",
"lang": "en",
"categories": ["shopping", "lifestyle", "fashion"]
}
