
<head>
    <!-- ... andere Meta-Tags ... -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ... restlicher Head-Inhalt ... -->
</head><img src="{{ Vite::asset('resources/js/components/assets/tricept.jpg') }}" alt="Logo" style="width: 200px; height: 52px; position: absolute; top: 20px; left: 20px;">
<div id="app"></div>

@vite('resources/js/app.js')
