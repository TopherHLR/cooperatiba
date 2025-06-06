<!-- resources/views/layouts/accountslayout.blade.php -->
@extends('layouts.sharedlayout')

@section('account-styles')
<style>
    .account-liquid-card {
        position: relative;
        overflow: hidden;
        border-radius: 20px;
        backdrop-filter: blur(10px);
        background: rgba(31, 30, 30, 0.7);
        box-shadow: 0 8px 32px rgba(0, 28, 0, 0.3);
        transition: all 0.5s ease;
    }
    
    .account-liquid-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            45deg,
            rgba(4, 119, 5, 0.1) 0%,
            rgba(237, 209, 0, 0.1) 50%,
            rgba(4, 119, 5, 0.1) 100%
        );
        animation: accountCardShine 8s ease infinite;
        z-index: -1;
    }
    
    @keyframes accountCardShine {
        0% { opacity: 0.3; }
        50% { opacity: 0.1; }
        100% { opacity: 0.3; }
    }

    /* Enhanced Liquid Button Styles */
    .account-nav-btn {
        position: relative;
        display: flex;
        align-items: center;
        overflow: hidden;
        transition: all 0.4s ease;
        background: linear-gradient(90deg, rgba(4, 119, 5, 0.3) 0%, rgba(4, 119, 5, 0.5) 100%);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 10px 16px;
    }
    
    .account-nav-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
        transition: all 0.6s ease;
    }
    
    .account-nav-btn:hover::before {
        left: 100%;
    }
    
    .account-nav-btn.active {
        background: linear-gradient(90deg, rgba(4, 119, 5, 0.6) 0%, rgba(10, 173, 10, 0.6) 100%);
        box-shadow: 0 4px 15px rgba(4, 119, 5, 0.4);
    }
    
    .account-nav-btn .account-btn-icon {
        margin-right: 10px;
        transition: all 0.3s ease;
    }
    
    .account-nav-btn:hover .account-btn-icon {
        transform: translateX(3px);
    }
    
    /* Profile icon specific */
    .account-profile-icon {
        width: 20px;
        height: 20px;
    }
    
    /* Orders icon specific */
    .account-orders-icon {
        width: 20px;
        height: 20px;
    }
        /* Cancel state (red version) */
    .account-nav-btn.cancel-state {
        background: linear-gradient(90deg, rgba(220, 38, 38, 0.3) 0%, rgba(220, 38, 38, 0.5) 100%) !important;
    }

    .account-nav-btn.cancel-state.active {
        background: linear-gradient(90deg, rgba(220, 38, 38, 0.6) 0%, rgba(248, 113, 113, 0.6) 100%) !important;
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.4) !important;
    }

    .account-nav-btn.cancel-state:hover::before {
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent) !important;
    }
</style>
@endsection

@section('content')
<div class="flex mx-10 justify-center gap-10 min-h-full">
    <!-- Sidebar Navigation - 20% width -->
    <div class="w-[20%] mt-40 mr-2 mb-20">
        <div class="account-liquid-card border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[15px] p-6 h-auto backdrop-blur-sm">
            <h2 class="text-white text-xl font-semibold mb-6">Account</h2>
            <nav class="space-y-2">
                <a href="{{ route('web.accountsettings') }}" 
                   class="account-nav-btn text-white @if(request()->routeIs('web.accountsettings')) active @endif">
                    <svg class="account-btn-icon account-profile-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profile Settings
                </a>
                <a href="{{ route('web.orders') }}" 
                   class="account-nav-btn text-white @if(request()->routeIs('web.orders')) active @endif">
                    <svg class="account-btn-icon account-orders-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    My Orders
                </a>

                <!-- Logout button -->
                <form method="POST" action="{{ route('web.logout') }}" class="w-full">
                    @csrf
                    <button type="submit" 
                            class="account-nav-btn cancel-state text-white w-full text-left flex items-center"
                            onclick="return confirm('Are you sure you want to logout?');">
                        <svg class="account-btn-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
                        </svg>
                        <span >Logout</span>
                    </button>
                </form>
            </nav>
        </div>
    </div>

    <!-- Main Content Area - 80% width -->
    <div class="w-[80%] mt-40 mb-20">
        @yield('account-content')
        @yield('account-styles')
    </div>
</div>
@endsection