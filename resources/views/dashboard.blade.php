@extends('adminslayout')
@section('title', 'Dashboard')

@section('styles')
<style>
    /* Import Jost font from Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap');
    
    /* Apply Jost to all regular text elements */
    body, 
    p,
    ul, 
    li,
    a:not(.navbar-brand),
    button {
        font-family: 'Jost', sans-serif;
    }
    
    /* Admin-specific status colors */
    .admin-status-pending {
        color: #EDD100;
        background-color: rgba(237, 209, 0, 0.1);
    }
    
    .admin-status-processing {
        color: #047705;
        background-color: rgba(4, 119, 5, 0.1);
    }
    
    .admin-status-shipped {
        color: #3B82F6;
        background-color: rgba(59, 130, 246, 0.1);
    }
    
    .admin-status-completed {
        color: #10B981;
        background-color: rgba(16, 185, 129, 0.1);
    }
    
    .admin-status-cancelled {
        color: #EF4444;
        background-color: rgba(239, 68, 68, 0.1);
    }
    
    /* Admin Tracking Steps */
    .admin-step-container {
        position: relative;
        display: flex;
        align-items: flex-start;
    }
    
    .admin-step-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-right: 16px;
        position: relative;
        z-index: 2;
    }
    
    .admin-step-icon svg {
        width: 20px;
        height: 20px;
    }
    
    .admin-step-content {
        flex: 1;
        padding-top: 4px;
    }
    
    /* Active step styling */
    .admin-step-container.active .admin-step-icon {
        border-color: #047705;
        background-color: #047705;
    }
    
    .admin-step-container.active .admin-step-current {
        display: block;
        color: white;
    }
    
    /* Completed step styling */
    .admin-step-container.completed .admin-step-icon {
        border-color: #047705;
        background-color: #047705;
    }
    
    .admin-step-container.completed .admin-step-check {
        display: block;
        color: white;
    }
    
    .admin-step-container.completed .admin-step-current {
        display: none;
    }
    
    /* Approval buttons */
    .approve-btn {
        background-color: rgba(16, 185, 129, 0.2);
        color: #10B981;
        border: 1px solid #10B981;
        transition: all 0.3s ease;
    }
    
    .approve-btn:hover {
        background-color: rgba(16, 185, 129, 0.4);
    }
    
    .reject-btn {
        background-color: rgba(239, 68, 68, 0.2);
        color: #EF4444;
        border: 1px solid #EF4444;
        transition: all 0.3s ease;
    }
    
    .reject-btn:hover {
        background-color: rgba(239, 68, 68, 0.4);
    }
    
    /* Admin action panel */
    .admin-action-panel {
        background: rgba(31, 30, 30, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
    }
</style>
@endsection
@section('admin-content')
@php
    $today = now();
    if ($today->month >= 8) {
        $startDate = $today->copy()->year($today->year)->month(8)->startOfMonth();
    } else {
        $startDate = $today->copy()->subYear()->year($today->year - 1)->month(8)->startOfMonth();
    }
    $endDate = $startDate->copy()->addYear()->subDay();
@endphp
<!-- Order Metrics Container -->
<div class="w-full h-auto">
    <div class="bg-gradient-to-r from-[#1F1E1E]/100 to-[#100E00]/80 border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[15px] p-6 backdrop-blur-sm overflow-hidden">
        <!-- Title Section -->
        <div class="flex items-center mb-6">
            <h2 class="text-2xl font-bold text-white flex items-center" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0px #047705;">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M3 3v18M3 3l18 18M21 3v18" />
                </svg>
                ORDER METRICS
            </h2>
        </div>
        <hr class="border-[.5px] border-white mb-6 -mx-6">
        <!-- Order Flow Visualization -->
        <div class="mb-5">
            <h3 class="text-lg font-semibold text-white mb-4" style="font-family: 'Inter', sans-serif;">Order Flow</h3>
            <div class="flex items-center justify-between relative h-12">
                <!-- Line -->
                <div class="absolute top-1/2 left-0 right-0 h-1 bg-gray-700/50 transform -translate-y-1/2 z-0"></div>
                
                <!-- Flow Steps -->
                <div class="relative z-10 flex flex-col items-center w-1/5">
                    <div class="w-8 h-8 rounded-full bg-[#FFB74D] flex items-center justify-center mb-1">
                        <span class="text-white text-xs font-bold">1</span>
                    </div>
                    <span class="text-xs text-gray-300">Pending</span>
                </div>
                <div class="relative z-10 flex flex-col items-center w-1/5">
                    <div class="w-8 h-8 rounded-full bg-[#66BB6A] flex items-center justify-center mb-1">
                        <span class="text-white text-xs font-bold">2</span>
                    </div>
                    <span class="text-xs text-gray-300">Paid</span>
                </div>
                <div class="relative z-10 flex flex-col items-center w-1/5">
                    <div class="w-8 h-8 rounded-full bg-[#4FC3F7] flex items-center justify-center mb-1">
                        <span class="text-white text-xs font-bold">3</span>
                    </div>
                    <span class="text-xs text-gray-300">Processing</span>
                </div>
                <div class="relative z-10 flex flex-col items-center w-1/5">
                    <div class="w-8 h-8 rounded-full bg-[#BA68C8] flex items-center justify-center mb-1">
                        <span class="text-white text-xs font-bold">4</span>
                    </div>
                    <span class="text-xs text-gray-300">Ready</span>
                </div>
                <div class="relative z-10 flex flex-col items-center w-1/5">
                    <div class="w-8 h-8 rounded-full bg-[#81C784] flex items-center justify-center mb-1">
                        <span class="text-white text-xs font-bold">5</span>
                    </div>
                    <span class="text-xs text-gray-300">Completed</span>
                </div>
            </div>
        </div>
        <!-- Main Content: Metrics and Chart -->
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Metrics Grid (Left) -->
            <div class="lg:w-1/2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4"> <!-- Reduced gap from 6 to 4 -->
                    <!-- Total Orders -->
                    <div class="h-32 sm:h-36 md:h-30 lg:h-32 bg-gradient-to-br from-[#1F1E1E]/60 to-[#2D2C2C]/60 rounded-xl p-3 border border-white/10 hover:border-[#5A8BFF]/50 hover:scale-105 transition-all duration-300 backdrop-blur-md">
                        <div class="flex items-center justify-between mb-2"> <!-- Reduced mb-3 to mb-2 -->
                            <h3 class="text-white font-semibold text-base" style="font-family: 'Inter', sans-serif;">Total Orders</h3>
                            <div class="bg-[#5A8BFF]/20 p-2 rounded-full backdrop-blur-md border border-[#5A8BFF]/30"> <!-- Reduced p-3 to p-2 -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#5A8BFF]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-2xl font-semibold text-white mb-1">{{ \App\Models\OrderModel::whereBetween('order_date', [$startDate, $endDate])->count() }}</p> <!-- Reduced text-3xl to text-2xl, mb-2 to mb-1 -->
                        <div class="flex items-center text-xs">
                            <span class="text-gray-400 font-light">*Updated now</span>
                        </div>
                        
                    </div>

                    <!-- Pending Orders -->
                    <div class="h-32 sm:h-36 md:h-30 lg:h-32 bg-gradient-to-br from-[#1F1E1E]/60 to-[#2D2C2C]/60 rounded-xl p-3 border border-[#FFB74D]/10 hover:border-[#FFB74D]/50 hover:scale-105 transition-all duration-300 backdrop-blur-md">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-white font-semibold text-base" style="font-family: 'Inter', sans-serif;">Pending Orders</h3>
                            <div class="bg-[#FFB74D]/20 p-2 rounded-full backdrop-blur-md border border-[#FFB74D]/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#FFB74D]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-2xl font-semibold text-white mb-1">{{ \App\Models\OrderModel::whereHas('statusHistories', function($q) use ($startDate, $endDate) {
                            $q->where('status', 'pending')
                                ->whereBetween('updated_at', [$startDate, $endDate]);
                        })->count() }}</p>
                        <div class="flex items-center text-xs">
                            <span class="text-[#FFB74D] font-light">Awaiting payment</span>
                        </div>
                        
                    </div>

                    <!-- Paid Orders -->
                    <div class="h-32 sm:h-36 md:h-30 lg:h-32 bg-gradient-to-br from-[#1F1E1E]/60 to-[#2D2C2C]/60 rounded-xl p-3 border border-[#66BB6A]/10 hover:border-[#66BB6A]/50 hover:scale-105 transition-all duration-300 backdrop-blur-md">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-white font-semibold text-base" style="font-family: 'Inter', sans-serif;">Paid Orders</h3>
                            <div class="bg-[#66BB6A]/20 p-2 rounded-full backdrop-blur-md border border-[#66BB6A]/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#66BB6A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-2xl font-semibold text-white mb-1">{{ \App\Models\OrderModel::whereHas('statusHistories', function($q) use ($startDate, $endDate) {
                            $q->where('status', 'paid')
                                ->whereBetween('updated_at', [$startDate, $endDate]);
                        })->count() }}</p>
                        <div class="flex items-center text-xs">
                            <span class="text-[#66BB6A] font-light">Payment confirmed</span>
                        </div>
                        
                    </div>

                    <!-- Processing Orders -->
                    <div class="h-32 sm:h-36 md:h-30 lg:h-32 bg-gradient-to-br from-[#1F1E1E]/60 to-[#2D2C2C]/60 rounded-xl p-3 border border-[#4FC3F7]/10 hover:border-[#4FC3F7]/50 hover:scale-105 transition-all duration-300 backdrop-blur-md">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-white font-semibold text-base" style="font-family: 'Inter', sans-serif;">Processing Orders</h3>
                            <div class="bg-[#4FC3F7]/20 p-2 rounded-full backdrop-blur-md border border-[#4FC3F7]/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#4FC3F7]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-2xl font-semibold text-white mb-1">{{ \App\Models\OrderModel::whereHas('statusHistories', function($q) use ($startDate, $endDate) {
                            $q->where('status', 'processing')
                                ->whereBetween('updated_at', [$startDate, $endDate]);
                        })->count() }}</p>
                        <div class="flex items-center text-xs">
                            <span class="text-[#4FC3F7] font-light">In production</span>
                        </div>
                        
                    </div>

                    <!-- Ready for Pickup Orders -->
                    <div class="h-32 sm:h-36 md:h-30 lg:h-32 bg-gradient-to-br from-[#1F1E1E]/60 to-[#2D2C2C]/60 rounded-xl p-3 border border-[#BA68C8]/10 hover:border-[#BA68C8]/50 hover:scale-105 transition-all duration-300 backdrop-blur-md">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-white font-semibold text-base" style="font-family: 'Inter', sans-serif;">Ready for Pickup</h3>
                            <div class="bg-[#BA68C8]/20 p-2 rounded-full backdrop-blur-md border border-[#BA68C8]/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#BA68C8]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-2xl font-semibold text-white mb-1">{{ \App\Models\OrderModel::whereHas('statusHistories', function($q) use ($startDate, $endDate) {
                            $q->where('status', 'readyforpickup')
                                ->whereBetween('updated_at', [$startDate, $endDate]);
                        })->count() }}</p>
                        <div class="flex items-center text-xs">
                            <span class="text-[#BA68C8] font-light">Awaiting customer pickup</span>
                        </div>
                        
                    </div>

                    <!-- Completed Orders -->
                    <div class="h-32 sm:h-36 md:h-30 lg:h-32 bg-gradient-to-br from-[#1F1E1E]/60 to-[#2D2C2C]/60 rounded-xl p-3 border border-[#81C784]/10 hover:border-[#81C784]/50 hover:scale-105 transition-all duration-300 backdrop-blur-md">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-white font-semibold text-base" style="font-family: 'Inter', sans-serif;">Completed Orders</h3>
                            <div class="bg-[#81C784]/20 p-2 rounded-full backdrop-blur-md border border-[#81C784]/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#81C784]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-2xl font-semibold text-white mb-1">{{ \App\Models\OrderModel::whereHas('statusHistories', function($q) use ($startDate, $endDate) {
                            $q->where('status', 'completed')
                                ->whereBetween('updated_at', [$startDate, $endDate]);
                        })->count() }}</p>
                        <div class="flex items-center text-xs">
                            <span class="text-[#81C784] font-light">Successfully delivered</span>
                        </div>
                        
                    </div>

                    <!-- Cancelled Orders -->
                    <div class="h-32 sm:h-36 md:h-30 lg:h-32 bg-gradient-to-br from-[#1F1E1E]/60 to-[#2D2C2C]/60 rounded-xl p-3 border border-[#E57373]/10 hover:border-[#E57373]/50 hover:scale-105 transition-all duration-300 backdrop-blur-md">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-white font-semibold text-base" style="font-family: 'Inter', sans-serif;">Cancelled Orders</h3>
                            <div class="bg-[#E57373]/20 p-2 rounded-full backdrop-blur-md border border-[#E57373]/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#E57373]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-2xl font-semibold text-white mb-1">{{ \App\Models\OrderModel::whereHas('statusHistories', function($q) use ($startDate, $endDate) {
                            $q->where('status', 'cancelled')
                                ->whereBetween('updated_at', [$startDate, $endDate]);
                        })->count() }}</p>
                        <div class="flex items-center text-xs">
                            <span class="text-[#E57373] font-light">Order cancelled</span>
                        </div>
                        
                    </div>

                    <!-- Total Uniforms Sold -->
                    <div class="h-32 sm:h-36 md:h-30 lg:h-32 bg-gradient-to-br from-[#1F1E1E]/60 to-[#2D2C2C]/60 rounded-xl p-3 border border-white/10 hover:border-[#5A8BFF]/50 hover:scale-105 transition-all duration-300 backdrop-blur-md">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-white font-semibold text-base" style="font-family: 'Inter', sans-serif;">Total Uniforms Sold</h3>
                            <div class="bg-[#5A8BFF]/20 p-2 rounded-full backdrop-blur-md border border-[#5A8BFF]/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#5A8BFF]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10l-5 10-5-10z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-2xl font-semibold text-white mb-1">{{ \App\Models\OrderItemModel::whereHas('order', function($query) use ($startDate, $endDate) {
                            $query->whereBetween('order_date', [$startDate, $endDate]);
                        })->sum('quantity') }}</p>
                        <div class="flex items-center text-xs">
                            <span class="text-gray-400 font-light">*Updated now</span>
                        </div>
                        
                    </div>
                    <div class="text-lg text-gray-400 font-light mt-1">Computed per A.Y.</div>
                </div>
            </div>
            <!-- Order Status Distribution Chart and Average Order Value -->
            <div class="lg:w-1/2 flex flex-col h-full gap-4">
                <!-- Chart -->
                <div class="flex-1">
                    <div class="bg-gradient-to-br from-[#1F1E1E]/60 to-[#2D2C2C]/60 rounded-xl p-6 border border-white/10 backdrop-blur-md h-full">
                        <canvas id="orderStatusChart" style="max-height: 400px;"></canvas>
                    </div>
                </div>

                <!-- Average Order Value Card -->
                <div class="bg-gradient-to-br from-[#1F1E1E]/70 to-[#2D2C2C]/70 rounded-xl p-6 border border-white/10 hover:border-[#10B981]/70  transition-all duration-300 backdrop-blur-md shadow-lg">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-white font-semibold text-lg tracking-wide" style="font-family: 'Inter', sans-serif;">
                            Average Order Value
                        </h3>
                        <div class="bg-[#10B981]/20 p-3 rounded-full backdrop-blur-md border border-[#10B981]/30 shadow-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#10B981]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Value -->
                    <div class="mb-4">
                        <p class="text-3xl font-bold text-white">₱{{ number_format(\App\Models\OrderModel::avg('total_price'), 2) }}</p>
                        <span class="text-xs text-gray-400 font-light">*Updated now</span>
                    </div>


                    <div class="mt-2">
                        <canvas id="avgOrderChart" height="50"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@1.4.0/dist/chartjs-plugin-annotation.min.js"></script>
<script>
    const ctx = document.getElementById('orderStatusChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Pending", "Paid", "Processing", "Ready for Pickup", "Completed", "Cancelled"],
            datasets: [{
                label: 'Order Status Distribution',
                data: [
                    {{ $statusCounts['pending'] ?? 0 }},
                    {{ $statusCounts['paid'] ?? 0 }},
                    {{ $statusCounts['processing'] ?? 0 }},
                    {{ $statusCounts['readyforpickup'] ?? 0 }},
                    {{ $statusCounts['completed'] ?? 0 }},
                    {{ $statusCounts['cancelled'] ?? 0 }}
                ],
                backgroundColor: ['#F59E0B', '#3B82F6', '#8B5CF6', '#A855F7', '#22C55E', '#EF4444'],
                borderColor: ['#F59E0B80', '#3B82F680', '#8B5CF680', '#A855F780', '#22C55E80', '#EF444480'],
                borderWidth: 1,
                hoverOffset: 20
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { family: "'Inter', sans-serif", size: 12 },
                        color: '#E5E7EB',
                        padding: 20
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(31, 30, 30, 0.8)',
                    titleFont: { family: "'Inter', sans-serif", size: 14 },
                    bodyFont: { family: "'Inter', sans-serif", size: 12 },
                    cornerRadius: 8,
                    padding: 12,
                    callbacks: {
                        label: function (context) {
                            let label = context.label || '';
                            let value = context.raw || 0;
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            },
            animation: {
                animateScale: true,
                animateRotate: true,
                duration: 1000
            },
            cutout: '60%' // Doughnut cutout
        }
    });
    
    const avgLabels = {!! json_encode($labels) !!};
    const avgData = {!! json_encode($avgData) !!};

    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('avgOrderChart').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: avgLabels,
                datasets: [{
                    label: 'Average Order Total (₱)',
                    data: avgData,
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        ticks: { color: '#E5E7EB' },
                        grid: { color: '#374151' }
                    },
                    y: {
                        ticks: {
                            callback: value => `₱${value}`,
                            color: '#E5E7EB'
                        },
                        grid: { color: '#374151' }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: '#E5E7EB',
                            font: { family: "'Inter', sans-serif" }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: context => `₱${context.parsed.y}`
                        }
                    }
                }
            }
        });
    });
</script>

@endsection
