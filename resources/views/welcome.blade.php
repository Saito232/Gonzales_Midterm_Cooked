<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Unilibrary - Your Modern Book Collection</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
        
        @keyframes fade-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fade-up 0.6s ease-out forwards; }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-indigo-50 via-white to-purple-50 min-h-screen">
    <!-- Animated Background Blobs -->
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute top-0 -left-4 w-96 h-96 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
        <div class="absolute top-0 -right-4 w-96 h-96 bg-indigo-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-1/2 w-96 h-96 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 glass-effect">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-xl">📚</span>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Unilibrary</span>
                </div>
                
                @if (Route::has('login'))
                    <div class="flex gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transform transition duration-200">
                                Dashboard →
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-5 py-2 bg-white text-gray-700 rounded-lg font-medium hover:shadow-md transition duration-200">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-5 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transform transition duration-200">
                                    Get Started
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center space-y-8 animate-fade-up">
                <div class="inline-block">
                    <span class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 rounded-full text-sm font-semibold mb-4">
                        🎉 Your Personal Library Management System
                    </span>
                </div>
                
                <h1 class="text-6xl md:text-7xl font-extrabold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent leading-tight">
                    Organize Your Books<br/>Like Never Before
                </h1>
                
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Experience a modern, intuitive platform to manage your book collection. Track genres, ratings, authors, and more with our beautiful interface.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center pt-4">
                    @guest
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold text-lg hover:shadow-2xl hover:scale-105 transform transition duration-200">
                            Start For Free →
                        </a>
                        <a href="#features" class="px-8 py-4 bg-white text-gray-700 rounded-xl font-semibold text-lg hover:shadow-lg transition duration-200">
                            Learn More
                        </a>
                    @else
                        <a href="{{ url('/dashboard') }}" class="px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold text-lg hover:shadow-2xl hover:scale-105 transform transition duration-200">
                            Go to Dashboard →
                        </a>
                    @endguest
                </div>
            </div>
            
            <!-- Hero Image/Screenshot Placeholder -->
            <div class="mt-16 relative">
                <div class="glass-effect rounded-2xl p-4 shadow-2xl max-w-5xl mx-auto">
                    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl aspect-video flex items-center justify-center">
                        <div class="text-center text-white p-8">
                            <div class="text-8xl mb-4">📚</div>
                            <h3 class="text-3xl font-bold mb-2">Beautiful Dashboard</h3>
                            <p class="text-lg opacity-90">Manage your entire collection in one place</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 px-4 bg-white/50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Powerful Features</h2>
                <p class="text-xl text-gray-600">Everything you need to manage your book collection</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="glass-effect rounded-2xl p-8 hover:shadow-xl transition duration-300 hover:scale-105 transform">
                    <div class="w-14 h-14 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center mb-6">
                        <span class="text-3xl">📖</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Book Management</h3>
                    <p class="text-gray-600">
                        Add, edit, and organize your books with ease. Track titles, authors, publication years, and descriptions.
                    </p>
                </div>
                
                <!-- Feature 2 -->
                <div class="glass-effect rounded-2xl p-8 hover:shadow-xl transition duration-300 hover:scale-105 transform">
                    <div class="w-14 h-14 bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl flex items-center justify-center mb-6">
                        <span class="text-3xl">🎭</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Genre Classification</h3>
                    <p class="text-gray-600">
                        Create custom genres and categorize your books. Browse by genre and discover patterns in your collection.
                    </p>
                </div>
                
                <!-- Feature 3 -->
                <div class="glass-effect rounded-2xl p-8 hover:shadow-xl transition duration-300 hover:scale-105 transform">
                    <div class="w-14 h-14 bg-gradient-to-r from-pink-600 to-red-600 rounded-xl flex items-center justify-center mb-6">
                        <span class="text-3xl">⭐</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Rating System</h3>
                    <p class="text-gray-600">
                        Rate your books and keep track of your favorites. See your top-rated books at a glance.
                    </p>
                </div>
                
                <!-- Feature 4 -->
                <div class="glass-effect rounded-2xl p-8 hover:shadow-xl transition duration-300 hover:scale-105 transform">
                    <div class="w-14 h-14 bg-gradient-to-r from-indigo-600 to-blue-600 rounded-xl flex items-center justify-center mb-6">
                        <span class="text-3xl">📊</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Statistics Dashboard</h3>
                    <p class="text-gray-600">
                        View comprehensive statistics about your collection, including total books, genres, and top ratings.
                    </p>
                </div>
                
                <!-- Feature 5 -->
                <div class="glass-effect rounded-2xl p-8 hover:shadow-xl transition duration-300 hover:scale-105 transform">
                    <div class="w-14 h-14 bg-gradient-to-r from-green-600 to-teal-600 rounded-xl flex items-center justify-center mb-6">
                        <span class="text-3xl">🌙</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Dark Mode</h3>
                    <p class="text-gray-600">
                        Comfortable reading experience with built-in dark mode support for day and night browsing.
                    </p>
                </div>
                
                <!-- Feature 6 -->
                <div class="glass-effect rounded-2xl p-8 hover:shadow-xl transition duration-300 hover:scale-105 transform">
                    <div class="w-14 h-14 bg-gradient-to-r from-yellow-600 to-orange-600 rounded-xl flex items-center justify-center mb-6">
                        <span class="text-3xl">⚡</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Fast & Modern</h3>
                    <p class="text-gray-600">
                        Built with Laravel and Tailwind CSS for a lightning-fast, responsive experience on all devices.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-4">
        <div class="max-w-4xl mx-auto">
            <div class="glass-effect rounded-3xl p-12 text-center">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    Ready to Get Started?
                </h2>
                <p class="text-xl text-gray-600 mb-8">
                    Join thousands of book lovers managing their collections with Unilibrary
                </p>
                @guest
                    <a href="{{ route('register') }}" class="inline-block px-10 py-5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-bold text-lg hover:shadow-2xl hover:scale-105 transform transition duration-200">
                        Create Your Free Account
                    </a>
                @else
                    <a href="{{ url('/dashboard') }}" class="inline-block px-10 py-5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-bold text-lg hover:shadow-2xl hover:scale-105 transform transition duration-200">
                        Open Your Dashboard
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 px-4 text-center text-gray-600 border-t border-gray-200">
        <p class="text-sm">
            © {{ date('Y') }} Unilibrary. Built with ❤️ using Laravel v{{ Illuminate\Foundation\Application::VERSION }}
        </p>
    </footer>
</body>
</html>
