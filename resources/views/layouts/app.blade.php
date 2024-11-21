<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>WIL WEBAPP</title>
        <style>
            /* Style for the alert container */
            .alert-container {
                margin-top: 20px; /* Add margin to separate from other content */
            }
        
            /* Style for the alert itself */
            .alert-danger {
                background-color: #f8d7da; /* Red background color for danger alerts */
                border-color: #f5c6cb; /* Border color for danger alerts */
                color: #721c24; /* Text color for danger alerts */
            }
        
            /* Add padding and rounded corners to the alert */
            .alert {
                padding: 1rem;
                border-radius: 0.25rem;
            }
        </style>
        

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
