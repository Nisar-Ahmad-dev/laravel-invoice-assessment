<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'نظام الفواتير' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        body { font-family: 'Noto Sans Arabic', 'Segoe UI', Tahoma, sans-serif; }
    </style>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 py-8">
        {{ $slot }}
    </div>
    @livewireScripts
</body>
</html>
