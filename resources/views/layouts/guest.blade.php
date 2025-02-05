<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="relative min-h-screen flex flex-col sm:justify-center items-center">
            <!-- Animated Background -->
            <div class="absolute inset-0 bg-yellow-50">
                <div class="absolute inset-0 bg-gradient-to-br from-yellow-400/40 via-yellow-500/40 to-yellow-600/40 backdrop-blur-3xl"></div>
                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23000000' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
            </div>

            <!-- Content -->
            <div class="relative w-full flex flex-col items-center justify-center p-6">
                <div class="mb-8 transform hover:scale-105 transition-transform duration-300">
                    <a href="/" class="block">
                        <img src="{{ asset('images/ayam-gepuk-artisan.png') }}" alt="Ayam Gepuk Artisan Logo" 
                             class="h-70 w-auto bg-white/90 p-3 rounded-xl shadow-lg mx-auto backdrop-blur-sm
                                    border border-yellow-100/50">
                    </a>
                </div>

                <div class="w-full sm:max-w-md px-8 py-8 bg-white/90 shadow-xl backdrop-blur-sm rounded-2xl
                            border border-yellow-100/50 space-y-6 transform hover:shadow-2xl 
                            transition-all duration-300">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <style>
            body {
                font-family: 'Montserrat', sans-serif;
            }
            
            /* Modern Glassmorphism */
            .backdrop-blur-sm {
                backdrop-filter: blur(8px);
            }
            
            .backdrop-blur-3xl {
                backdrop-filter: blur(64px);
            }
            
            /* Smooth Animations */
            @keyframes float {
                0%, 100% {
                    transform: translateY(0);
                }
                50% {
                    transform: translateY(-10px);
                }
            }
            
            /* Enhanced Form Elements */
            input, select, textarea {
                @apply bg-white/70 backdrop-blur-sm border-yellow-200/50 focus:border-yellow-400 
                       focus:ring focus:ring-yellow-200/50 rounded-lg transition-all duration-300;
            }
            
            button {
                @apply bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 
                       hover:to-yellow-700 text-white font-semibold py-2 px-4 rounded-lg
                       transform hover:-translate-y-0.5 transition-all duration-300
                       focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2;
            }
            
            /* Link Styles */
            a {
                @apply text-yellow-700 hover:text-yellow-600 transition-colors duration-300;
            }
            
            /* Custom Scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
            }
            
            ::-webkit-scrollbar-track {
                @apply bg-yellow-50;
            }
            
            ::-webkit-scrollbar-thumb {
                @apply bg-yellow-400/50 rounded-full hover:bg-yellow-500/50;
            }
        </style>
    </body>
</html>
