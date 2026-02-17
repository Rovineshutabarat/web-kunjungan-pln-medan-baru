@extends('layouts.app')

@section('content')
    <div class="flex h-screen overflow-hidden bg-gray-50">
        <aside class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 h-16 border-b border-gray-100">
                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('logo.png') }}" alt="Logo" class="h-full w-10 object-cover">
                        <span class="text-xl font-semibold text-gray-900">Admin Panel</span>
                    </div>
                </div>

                <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">

                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('adminpage.dashboard.index') }}"
                            class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 
        {{ request()->routeIs('adminpage.dashboard.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fas fa-tachometer-alt w-5 text-center mr-3"></i>
                            <span>Dashboard</span>
                        </a>
                    @endif

                    <a href="{{ route('adminpage.visit.index') }}"
                        class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 
   {{ request()->routeIs('adminpage.visit.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-calendar-check w-5 text-center mr-3"></i>
                        <span>Kunjungan</span>
                    </a>

                    <a href="{{ route('adminpage.visitor.index') }}"
                        class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 
        {{ request()->routeIs('adminpage.visitor.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-user-friends w-5 text-center mr-3"></i>
                        <span>Pengunjung</span>
                    </a>

                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('adminpage.employee.index') }}"
                            class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 
{{ request()->routeIs('adminpage.employee.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fas fa-user-tie w-5 text-center mr-3"></i>
                            <span>Pegawai</span>
                        </a>
                    @endif

                </nav>


                <div class="p-3 border-t border-gray-100">
                    <div
                        class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-200 cursor-pointer transition-all duration-200">
                        <img src="https://ui-avatars.com/api/?name=Admin+User&background=3b82f6&color=fff&size=128"
                            alt="Profile" class="w-9 h-9 rounded-full ring-2 ring-gray-100">
                        <div class="flex-1 min-w-0 ml-3">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->username }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class=" shadow-sm">
                <div class="px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                    <button
                        class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-lg p-2">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <div class="flex-1 max-w-2xl mx-4 sm:mx-8">
                        <div class="relative">
                            <i
                                class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" placeholder="Search anything..."
                                class="w-full pl-11 pr-4 py-2.5 text-sm bg-gray-50 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-200">
                        </div>
                    </div>

                    <div class="flex items-center space-x-2 sm:space-x-3">
                        <div class="relative hidden sm:block">
                            <button
                                class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                                <img src="https://ui-avatars.com/api/?name=Admin+User&background=3b82f6&color=fff&size=128"
                                    alt="Profile" class="w-8 h-8 rounded-full ring-2 ring-gray-100">
                                <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto bg-gray-50">
                <div class="px-4 sm:px-6 lg:px-8 py-6">
                    @yield('admin-content')
                </div>
            </main>
        </div>
    </div>

    <div class="fixed inset-0 z-50 hidden" id="mobile-menu">
        <div class="absolute inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm transition-opacity"></div>
        <div class="relative flex-1 flex flex-col max-w-xs w-full h-full bg-white shadow-xl">
            <div class="flex items-center justify-between px-6 h-16 border-b border-gray-100">
                <div class="flex items-center space-x-2">
                    <div
                        class="w-9 h-9 bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg flex items-center justify-center shadow-sm">
                        <img src="{{ asset('logo.png') }}" alt="Logo" class="h-full w-10 object-cover">
                    </div>
                    <span class="text-lg font-semibold text-gray-900">AdminPanel</span>
                </div>
                <button class="text-gray-400 hover:text-gray-600 focus:outline-none"
                    onclick="document.getElementById('mobile-menu').classList.add('hidden')">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                <a href="#"
                    class="flex items-center px-3 py-2.5 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg">
                    <i class="fas fa-home w-5 text-center mr-3"></i>
                    <span>Dashboard</span>
                </a>
            </nav>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('.md\\:hidden');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
@endsection
