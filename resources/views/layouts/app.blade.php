<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ERP System') }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-indigo-600">
                        {{ config('app.name', 'ERP System') }}
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('admin.sales.list') }}" class="text-sm hover:text-indigo-600">Sales</a>
                        <a href="#" class="text-sm hover:text-indigo-600">Products</a>
                        <a href="#" class="text-sm hover:text-indigo-600">Customers</a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-red-600 hover:underline">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm hover:text-indigo-600">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="py-6 px-4 sm:px-6 lg:px-8 min-h-[81vh]">
        @yield('content')
    </main>

    
    <footer class="bg-white mt-12">
        <div class="max-w-7xl mx-auto py-4 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} {{ config('app.name', 'ERP System') }}. All rights reserved.
        </div>
    </footer>
</body>
</html>
