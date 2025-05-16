<!-- resources/views/layouts/accountslayout.blade.php -->
@extends('layouts.sharedlayout')

@section('content')
<div class="flex min-h-screen">
    <!-- Sidebar Navigation -->
    <div class="w-64 bg-[#1F1E1E]/90 border-r border-[#047705]/50">
        <div class="p-4">
            <h2 class="text-white text-xl font-semibold mb-6">Account</h2>
            <nav>
                <a href="{{ route('web.accountsettings') }}" class="block py-2 px-4 text-white hover:bg-[#047705]/50 rounded transition mb-2 @if(request()->routeIs('web.accountsettings')) bg-[#047705]/50 @endif">
                    Profile Settings
                </a>
                <a href="{{ route('web.orders') }}" class="block py-2 px-4 text-white hover:bg-[#047705]/50 rounded transition mb-2 @if(request()->routeIs('web.orders')) bg-[#047705]/50 @endif">
                    My Orders
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="flex-1 p-8">
        @yield('account-content')
    </div>
</div>
@endsection