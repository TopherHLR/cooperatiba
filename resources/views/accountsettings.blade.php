@extends('accountslayout')

@section('title', 'Account Settings')

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
    
        /* Liquid UI Background Effects */
    body {
        background: linear-gradient(135deg, #1F1E1E 0%, #001C00 100%);
        min-height: 100vh;
        font-family: 'Inria Sans', sans-serif;
        overflow-x: hidden;
    }
    
    /* Enhanced Moving Background */
    body::before {
        content: '';
        position: fixed;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(
            to bottom right,
            rgba(18, 108, 7, 0.15) 0%,          /* #126C07 */
            rgba(113, 200, 98, 0.15) 25%,        /* #71C862 */
            rgba(210, 220, 50, 0.12) 50%,        /* New yellowish tone */
            rgba(113, 200, 98, 0.15) 75%,        /* #71C862 */
            rgba(10, 56, 14, 0.15) 100%          /* #0A380E */
        );
        transform: rotate(30deg);
        animation: liquidFlow 15s linear infinite;
        z-index: -1;
        opacity: 0.5;
    }
    
    @keyframes liquidFlow {
        0% { transform: rotate(30deg) translate(-10%, -10%); }
        50% { transform: rotate(30deg) translate(10%, 10%); }
        100% { transform: rotate(30deg) translate(-10%, -10%); }
    }      
</style>
@endsection

@section('account-content')
<div class="content-section min-h-screen">
    <div class="content-overlay min-h-screen">
        <div class="flex mx-2 justify-center gap-10">
            <!-- Container - Account Settings -->
            <div class="w-[100%] h-[750px]">
                <div class="bg-gradient-to-r from-[#1F1E1E]/100 to-[#100E00]/80 border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[30px] p-6 h-full backdrop-blur-sm flex flex-col">
                    <!-- Title Section -->
                    <div class="flex items-center mb-4">
                        <h2 class="text-2xl font-bold text-white flex items-center" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0px #047705;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Account Settings
                        </h2>
                    </div>
                    <hr class="border-[.5px] border-white mb-6 -mx-6">
                    
                    <!-- Scrollable Content -->
                    <div class="overflow-y-auto flex-1 pr-2">
                        <!-- User Information Form -->
                        <form class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Student Information Section -->
                            <div class="md:col-span-2 space-y-4">
                                <h3 class="text-lg font-semibold text-white flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Student Information
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-gray-800/30 p-4 rounded-xl">
                                    <!-- Student Number -->
                                    <div class="md:col-span-2">
                                        <label for="student_no" class="block text-white mb-1 text-xs font-medium uppercase tracking-wider">Student Number</label>
                                        <input type="text" id="student_no" name="student_no" 
                                            class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-lg px-3 py-2 text-sm" 
                                            required readonly>
                                    </div>
                                    
                                    <!-- Last Name -->
                                    <div>
                                        <label for="last_name" class="block text-white mb-1 text-xs font-medium uppercase tracking-wider">Last Name</label>
                                        <input type="text" id="last_name" name="last_name" 
                                            class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-lg px-3 py-2 text-sm" 
                                            required>
                                    </div>
                                    
                                    <!-- First Name -->
                                    <div>
                                        <label for="first_name" class="block text-white mb-1 text-xs font-medium uppercase tracking-wider">First Name</label>
                                        <input type="text" id="first_name" name="first_name" 
                                            class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-lg px-3 py-2 text-sm" 
                                            required>
                                    </div>
                                    
                                    <!-- Middle Initial -->
                                    <div>
                                        <label for="middle_initial" class="block text-white mb-1 text-xs font-medium uppercase tracking-wider">M.I.</label>
                                        <input type="text" id="middle_initial" name="middle_initial" 
                                            class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-lg px-3 py-2 text-center text-sm" 
                                            maxlength="1">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Personal Details Section -->
                            <div class="md:col-span-2 space-y-4">
                                <h3 class="text-lg font-semibold text-white flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Personal Details
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-800/30 p-4 rounded-xl">
                                    <!-- Gender -->
                                    <div class="md:col-span-2">
                                        <label class="block text-white mb-1 text-xs font-medium uppercase tracking-wider">Gender</label>
                                        <div class="grid grid-cols-2 gap-2">
                                            <label class="flex items-center space-x-2">
                                                <input type="radio" name="gender" value="male" class="h-4 w-4 text-green-500">
                                                <span class="text-white text-sm">Male</span>
                                            </label>
                                            <label class="flex items-center space-x-2">
                                                <input type="radio" name="gender" value="female" class="h-4 w-4 text-green-500">
                                                <span class="text-white text-sm">Female</span>
                                            </label>
                                            <label class="flex items-center space-x-2">
                                                <input type="radio" name="gender" value="other" class="h-4 w-4 text-green-500">
                                                <span class="text-white text-sm">Other</span>
                                            </label>
                                            <label class="flex items-center space-x-2">
                                                <input type="radio" name="gender" value="prefer_not" class="h-4 w-4 text-green-500">
                                                <span class="text-white text-sm">Prefer not to say</span>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <!-- Contact Number -->
                                    <div>
                                        <label for="contact_number" class="block text-white mb-1 text-xs font-medium uppercase tracking-wider">Contact No.</label>
                                        <input type="tel" id="contact_number" name="contact_number" 
                                            class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-lg px-3 py-2 text-sm">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Body Measurements Section -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-white flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    Body Measurements
                                </h3>
                                <div class="grid grid-cols-2 gap-4 bg-gray-800/30 p-4 rounded-xl">
                                    <!-- Height -->
                                    <div>
                                        <label for="height" class="block text-white mb-1 text-xs font-medium uppercase tracking-wider">Height (cm)</label>
                                        <input type="number" id="height" name="height" 
                                            class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-lg px-3 py-2 text-sm" 
                                            step="0.1" min="0">
                                    </div>
                                    
                                    <!-- Weight -->
                                    <div>
                                        <label for="weight" class="block text-white mb-1 text-xs font-medium uppercase tracking-wider">Weight (kg)</label>
                                        <input type="number" id="weight" name="weight" 
                                            class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-lg px-3 py-2 text-sm" 
                                            step="0.1" min="0">
                                    </div>
                                    
                                    <!-- BMI -->
                                    <div>
                                        <label class="block text-white mb-1 text-xs font-medium uppercase tracking-wider">BMI</label>
                                        <div class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-lg px-3 py-2 text-sm">
                                            N/A
                                        </div>
                                    </div>
                                    
                                    <!-- Recommended Size -->
                                    <div>
                                        <label class="block text-white mb-1 text-xs font-medium uppercase tracking-wider">Size</label>
                                        <div class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-lg px-3 py-2 text-sm">
                                            N/A
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Academic Information Section -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-white flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    Academic Information
                                </h3>
                                <div class="grid grid-cols-1 gap-4 bg-gray-800/30 p-4 rounded-xl">
                                    <!-- Department -->
                                    <div>
                                        <label for="department" class="block text-white mb-1 text-xs font-medium uppercase tracking-wider">Department</label>
                                        <select id="department" name="department" class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-lg px-3 py-2 text-sm">
                                            <option value="">Select Department</option>
                                            <option value="CCS">College of Computer Studies</option>
                                            <option value="COE">College of Engineering</option>
                                            <option value="CBA">College of Business and Accountancy</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Program -->
                                    <div>
                                        <label for="program" class="block text-white mb-1 text-xs font-medium uppercase tracking-wider">Program</label>
                                        <input type="text" id="program" name="program" 
                                            class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-lg px-3 py-2 text-sm">
                                    </div>
                                    
                                    <!-- Year and Section -->
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="year" class="block text-white mb-1 text-xs font-medium uppercase tracking-wider">Year Level</label>
                                            <select id="year" name="year" class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-lg px-3 py-2 text-sm">
                                                <option value="">Select Year</option>
                                                <option value="1">1st Year</option>
                                                <option value="2">2nd Year</option>
                                                <option value="3">3rd Year</option>
                                                <option value="4">4th Year</option>
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label for="section" class="block text-white mb-1 text-xs font-medium uppercase tracking-wider">Section</label>
                                            <input type="text" id="section" name="section" 
                                                class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-lg px-3 py-2 text-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="md:col-span-2 flex justify-end mt-2">
                                <button type="button" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg transition duration-300 text-sm shadow-md">
                                    Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection