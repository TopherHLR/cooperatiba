<!-- resources/views/layouts/adminlayout.blade.php -->
@extends('layouts.sharedlayout')

@section('admin-styles')
<style>
    .admin-liquid-card {
        position: relative;
        overflow: hidden;
        border-radius: 20px;
        backdrop-filter: blur(10px);
        background: rgba(31, 30, 30, 0.7);
        box-shadow: 0 8px 32px rgba(0, 28, 0, 0.3);
        transition: all 0.5s ease;
    }
    
    .admin-liquid-card::before {
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
        animation: adminCardShine 8s ease infinite;
        z-index: -1;
    }
    
    @keyframes adminCardShine {
        0% { opacity: 0.3; }
        50% { opacity: 0.1; }
        100% { opacity: 0.3; }
    }

    /* Enhanced Liquid Button Styles */
    .admin-nav-btn {
        position: relative;
        display: flex;
        align-items: center;
        overflow: hidden;
        transition: all 0.4s ease;
        background: linear-gradient(90deg, rgba(4, 119, 5, 0.3) 0%, rgba(4, 119, 5, 0.5) 100%);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 10px 16px;
        margin-bottom: 8px;
    }
    
    .admin-nav-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
        transition: all 0.6s ease;
    }
    
    .admin-nav-btn:hover::before {
        left: 100%;
    }
    
    .admin-nav-btn.active {
        background: linear-gradient(90deg, rgba(4, 119, 5, 0.6) 0%, rgba(10, 173, 10, 0.6) 100%);
        box-shadow: 0 4px 15px rgba(4, 119, 5, 0.4);
    }
    
    .admin-nav-btn .admin-btn-icon {
        margin-right: 10px;
        transition: all 0.3s ease;
        width: 18px;
        height: 18px;
    }
    
    .admin-nav-btn:hover .admin-btn-icon {
        transform: translateX(3px);
    }
    
    /* Section headers */
    .admin-section-header {
        color: #a0aec0;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin: 20px 0 10px 0;
        padding-left: 16px;
    }
</style>
@endsection

@section('content')
<div class="flex mx-10 justify-center gap-10 min-h-full">
    <!-- Admin Sidebar Navigation - 20% width -->
    <div class="w-[20%] mt-40 mr-2 mb-20">
        <div class="admin-liquid-card border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[15px] p-6 h-auto backdrop-blur-sm">
            <h2 class="text-white text-xl font-semibold mb-6">Admin Control Panel</h2>
            <nav class="space-y-2">
                <div class="admin-section-header">Management</div>
                <a href="#" 
                   class="admin-nav-btn text-white @if(request()->routeIs('admin.dashboard')) active @endif">
                    <svg class="admin-btn-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    Dashboard
                </a>
                
                <a href="#" 
                   class="admin-nav-btn text-white @if(request()->routeIs('admin.users')) active @endif">
                    <svg class="admin-btn-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    User Management
                </a>
                
                <a href="#" 
                   class="admin-nav-btn text-white @if(request()->routeIs('admin.productcatalog')) active @endif">
                    <svg class="admin-btn-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Product Catalog
                </a>
                
                <a href="{{ route('admin.orderManage') }}" 
                   class="admin-nav-btn text-white @if(request()->routeIs('admin.orderManage')) active @endif">
                    <svg class="admin-btn-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    Order Management
                </a>               
                
                <div class="admin-section-header">Settings</div>
                <a href="#" 
                   class="admin-nav-btn text-white @if(request()->routeIs('admin.settings')) active @endif">
                    <svg class="admin-btn-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    System Settings
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Content Area - 80% width -->
    <div class="w-[80%] mt-40 mb-20">
        @yield('admin-content')
        @yield('admin-styles')
    </div>
</div>
@endsection