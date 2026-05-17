<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Griffith WIL Platform</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gu-light min-h-screen">
        <div class="min-h-screen flex">

            <!-- Left panel — branding -->
            <div class="hidden lg:flex lg:flex-col lg:w-1/2 bg-gu-navy px-12 py-16 justify-between">
                <!-- Brand -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gu-gold flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gu-gold font-bold text-lg leading-tight">Griffith University</p>
                        <p class="text-white/60 text-xs leading-tight">Work Integrated Learning</p>
                    </div>
                </div>

                <!-- Hero text -->
                <div>
                    <h1 class="text-4xl font-bold text-white leading-tight mb-4">
                        Connect. Learn.<br>
                        <span class="text-gu-gold">Grow.</span>
                    </h1>
                    <p class="text-white/60 text-base leading-relaxed max-w-sm">
                        The WIL Platform connects Griffith students with real-world industry projects, enabling hands-on experience that complements your degree.
                    </p>

                    <div class="mt-10 space-y-4">
                        @foreach([
                            ['icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'text' => 'Browse real industry projects'],
                            ['icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z', 'text' => 'Apply to up to 3 projects per trimester'],
                            ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'text' => 'Get automatically matched by GPA & skills'],
                        ] as $feature)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-gu-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feature['icon'] }}"/>
                                    </svg>
                                </div>
                                <span class="text-white/70 text-sm">{{ $feature['text'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Footer -->
                <p class="text-white/30 text-xs">&copy; {{ date('Y') }} Griffith University. All rights reserved.</p>
            </div>

            <!-- Right panel — form -->
            <div class="flex-1 flex flex-col justify-center px-6 py-12 sm:px-12 lg:px-16">
                <!-- Mobile brand -->
                <div class="lg:hidden flex items-center gap-2 mb-8">
                    <div class="w-8 h-8 rounded-md bg-gu-gold flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        </svg>
                    </div>
                    <span class="font-bold text-gu-navy"><span class="text-gu-gold">Griffith</span> WIL</span>
                </div>

                <div class="w-full max-w-md mx-auto">
                    {{ $slot }}
                </div>
            </div>

        </div>
    </body>
</html>
