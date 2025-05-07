<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Cooperatiba</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Kalam:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inria+Sans:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Liquid UI Effects */
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
                rgba(4, 119, 5, 0.1) 0%,
                rgba(237, 209, 0, 0.1) 50%,
                rgba(4, 119, 5, 0.1) 100%
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
        
        .liquid-card {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            background: rgba(31, 30, 30, 0.7);
            box-shadow: 0 8px 32px rgba(0, 28, 0, 0.3);
            transition: all 0.5s ease;
        }
        
        .liquid-card::before {
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
            animation: cardShine 8s ease infinite;
            z-index: -1;
        }
        
        @keyframes cardShine {
            0% { opacity: 0.3; }
            50% { opacity: 0.1; }
            100% { opacity: 0.3; }
        }
        
        .liquid-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
            background: linear-gradient(90deg, #047705 0%, #0aad0a 100%);
            box-shadow: 0 4px 15px rgba(4, 119, 5, 0.4);
        }
        
        .liquid-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.6s ease;
        }
        
        .liquid-btn:hover::before {
            left: 100%;
        }
        
        .liquid-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .liquid-input:focus {
            border-color: #047705;
            box-shadow: 0 0 0 2px rgba(4, 119, 5, 0.3);
        }
        
        /* Registration form steps */
        .form-step {
            display: none;
        }
        
        .form-step.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }
        
        .step {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 10px;
            position: relative;
            font-size: 0.875rem;
            font-weight: bold;
        }
        
        .step.active {
            background-color: #047705;
        }
        
        .step.completed {
            background-color: rgba(4, 119, 5, 0.5);
        }
        
        .step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 100%;
            width: 20px;
            height: 2px;
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .step.completed:not(:last-child)::after {
            background-color: rgba(4, 119, 5, 0.5);
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">
    <!-- Simplified Navigation -->
    <nav class="w-full py-4 px-10 flex justify-between items-center">
        <!-- Logo (now static) -->
        <div class="flex items-center">
            <img src="/images/homepage/logo.png" alt="Logo" class="h-12">
            <a href="{{ route('web.home') }}" class="text-lg font-semibold text-white ml-2" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0px #047705;">
                COOPERATIBA
            </a>
        </div>

        <!-- Minimal Links -->
        <div class="flex items-center space-x-6">
            <a href="{{ route('web.home') }}" class="text-white hover:text-[#EDD100] transition">Home</a>
            <a href="#" class="text-white hover:text-[#EDD100] transition">About</a>
            <a href="{{ route('web.items') }}" class="text-white hover:text-[#EDD100] transition">Items</a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center p-4">
        <div class="w-full max-w-4xl mx-auto">
            <!-- Registration Card -->
            <div class="liquid-card p-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-white mb-2">Create Your Account</h2>
                    <p class="text-gray-300">Join Cooperatiba in just a few steps</p>
                </div>
                
                <!-- Step Indicator -->
                <div class="step-indicator">
                    <div class="step active" data-step="1">1</div>
                    <div class="step" data-step="2">2</div>
                    <div class="step" data-step="3">3</div>
                    <div class="step" data-step="4">4</div>
                </div>
                
                <form id="registrationForm">
                    <!-- Step 1: Account Information -->
                    <div class="form-step active" id="step1">
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-semibold text-white flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Account Information
                            </h3>
                        </div>
                        
                        <div class="space-y-4">
                            <!-- Student Number -->
                            <div>
                                <label for="student_number" class="block text-white mb-2">Student Number</label>
                                <input 
                                    type="text" 
                                    id="student_number" 
                                    name="student_number"
                                    class="w-full px-4 py-3 rounded-lg liquid-input text-white focus:outline-none" 
                                    placeholder="e.g. 23-12345"
                                    pattern="[0-9]{4}-[0-9]{5}"
                                    title="Please enter a valid student number (format: yy-XXXXX)"
                                    required
                                >
                                <p class="mt-1 text-xs text-gray-400">Format: yy-XXXXX (e.g. 23-12345)</p>
                            </div>
                            
                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-white mb-2">Password</label>
                                <div class="relative">
                                    <input 
                                        type="password" 
                                        id="password" 
                                        class="w-full px-4 py-3 pr-10 rounded-lg liquid-input text-white focus:outline-none" 
                                        placeholder="••••••••"
                                        required
                                    >
                                    <button 
                                        type="button" 
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-[#047705] transition"
                                        onclick="togglePasswordVisibility('password')"
                                        aria-label="Toggle password visibility"
                                    >
                                        <svg id="showPasswordIcon" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                        <svg id="hidePasswordIcon" class="h-5 w-5 hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                            <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Confirm Password -->
                            <div>
                                <label for="confirm_password" class="block text-white mb-2">Confirm Password</label>
                                <div class="relative">
                                    <input 
                                        type="password" 
                                        id="confirm_password" 
                                        class="w-full px-4 py-3 pr-10 rounded-lg liquid-input text-white focus:outline-none" 
                                        placeholder="••••••••"
                                        required
                                    >
                                    <button 
                                        type="button" 
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-[#047705] transition"
                                        onclick="togglePasswordVisibility('confirm_password')"
                                        aria-label="Toggle password visibility"
                                    >
                                        <svg id="showConfirmPasswordIcon" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                        <svg id="hideConfirmPasswordIcon" class="h-5 w-5 hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                            <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end mt-8">
                            <button type="button" onclick="nextStep(1, 2)" class="px-6 py-2 rounded-lg text-white font-medium liquid-btn hover:shadow-lg transition">
                                Next
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 2: Student Information -->
                    <div class="form-step" id="step2">
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-semibold text-white flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Student Information
                            </h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Last Name -->
                            <div>
                                <label for="last_name" class="block text-white mb-2">Last Name</label>
                                <input type="text" id="last_name" name="last_name" 
                                    class="w-full px-4 py-3 rounded-lg liquid-input text-white focus:outline-none" 
                                    required>
                            </div>
                            
                            <!-- First Name -->
                            <div>
                                <label for="first_name" class="block text-white mb-2">First Name</label>
                                <input type="text" id="first_name" name="first_name" 
                                    class="w-full px-4 py-3 rounded-lg liquid-input text-white focus:outline-none" 
                                    required>
                            </div>
                            
                            <!-- Middle Initial -->
                            <div>
                                <label for="middle_initial" class="block text-white mb-2">Middle Initial</label>
                                <input type="text" id="middle_initial" name="middle_initial" 
                                    class="w-full px-4 py-3 rounded-lg liquid-input text-white focus:outline-none text-center" 
                                    maxlength="1">
                            </div>
                            
                            <!-- Gender -->
                            <div class="md:col-span-2">
                                <label class="block text-white mb-2">Gender</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                    <label class="flex items-center space-x-2">
                                        <input type="radio" name="gender" value="male" class="h-4 w-4 text-green-500">
                                        <span class="text-white">Male</span>
                                    </label>
                                    <label class="flex items-center space-x-2">
                                        <input type="radio" name="gender" value="female" class="h-4 w-4 text-green-500">
                                        <span class="text-white">Female</span>
                                    </label>
                                    <label class="flex items-center space-x-2">
                                        <input type="radio" name="gender" value="other" class="h-4 w-4 text-green-500">
                                        <span class="text-white">Other</span>
                                    </label>
                                    <label class="flex items-center space-x-2">
                                        <input type="radio" name="gender" value="prefer_not" class="h-4 w-4 text-green-500">
                                        <span class="text-white">Prefer not to say</span>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Contact Number -->
                            <div class="md:col-span-2">
                                <label for="contact_number" class="block text-white mb-2">Contact Number</label>
                                <input type="tel" id="contact_number" name="contact_number" 
                                    class="w-full px-4 py-3 rounded-lg liquid-input text-white focus:outline-none">
                            </div>
                        </div>
                        
                        <div class="flex justify-between mt-8">
                            <button type="button" onclick="prevStep(2, 1)" class="px-6 py-2 rounded-lg text-white font-medium bg-gray-600 hover:bg-gray-700 transition">
                                Back
                            </button>
                            <button type="button" onclick="nextStep(2, 3)" class="px-6 py-2 rounded-lg text-white font-medium liquid-btn hover:shadow-lg transition">
                                Next
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 3: Body Measurements -->
                    <div class="form-step" id="step3">
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-semibold text-white flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                Body Measurements
                            </h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Height -->
                            <div>
                                <label for="height" class="block text-white mb-2">Height (cm)</label>
                                <input type="number" id="height" name="height" 
                                    class="w-full px-4 py-3 rounded-lg liquid-input text-white focus:outline-none" 
                                    step="0.1" min="0">
                            </div>
                            
                            <!-- Weight -->
                            <div>
                                <label for="weight" class="block text-white mb-2">Weight (kg)</label>
                                <input type="number" id="weight" name="weight" 
                                    class="w-full px-4 py-3 rounded-lg liquid-input text-white focus:outline-none" 
                                    step="0.1" min="0">
                            </div>
                            
                            <!-- BMI -->
                            <div>
                                <label class="block text-white mb-2">BMI</label>
                                <div class="w-full px-4 py-3 rounded-lg bg-gray-700/50 border border-gray-600 text-white">
                                    N/A
                                </div>
                            </div>
                            
                            <!-- Recommended Size -->
                            <div>
                                <label class="block text-white mb-2">Recommended Size</label>
                                <div class="w-full px-4 py-3 rounded-lg bg-gray-700/50 border border-gray-600 text-white">
                                    N/A
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-between mt-8">
                            <button type="button" onclick="prevStep(3, 2)" class="px-6 py-2 rounded-lg text-white font-medium bg-gray-600 hover:bg-gray-700 transition">
                                Back
                            </button>
                            <button type="button" onclick="nextStep(3, 4)" class="px-6 py-2 rounded-lg text-white font-medium liquid-btn hover:shadow-lg transition">
                                Next
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 4: Academic Information -->
                    <div class="form-step" id="step4">
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-semibold text-white flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                Academic Information
                            </h3>
                        </div>
                        
                        <div class="space-y-4">
                            <!-- Department -->
                            <div>
                                <label for="department" class="block text-white mb-2">Department</label>
                                <select id="department" name="department" class="w-full px-4 py-3 rounded-lg liquid-input text-white focus:outline-none">
                                    <option value="">Select Department</option>
                                    <option value="CCS">College of Computer Studies</option>
                                    <option value="COE">College of Engineering</option>
                                    <option value="CBA">College of Business and Accountancy</option>
                                </select>
                            </div>
                            
                            <!-- Program -->
                            <div>
                                <label for="program" class="block text-white mb-2">Program</label>
                                <input type="text" id="program" name="program" 
                                    class="w-full px-4 py-3 rounded-lg liquid-input text-white focus:outline-none">
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Year Level -->
                                <div>
                                    <label for="year" class="block text-white mb-2">Year Level</label>
                                    <select id="year" name="year" class="w-full px-4 py-3 rounded-lg liquid-input text-white focus:outline-none">
                                        <option value="">Select Year</option>
                                        <option value="1">1st Year</option>
                                        <option value="2">2nd Year</option>
                                        <option value="3">3rd Year</option>
                                        <option value="4">4th Year</option>
                                    </select>
                                </div>
                                
                                <!-- Section -->
                                <div>
                                    <label for="section" class="block text-white mb-2">Section</label>
                                    <input type="text" id="section" name="section" 
                                        class="w-full px-4 py-3 rounded-lg liquid-input text-white focus:outline-none">
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-between mt-8">
                            <button type="button" onclick="prevStep(4, 3)" class="px-6 py-2 rounded-lg text-white font-medium bg-gray-600 hover:bg-gray-700 transition">
                                Back
                            </button>
                            <button type="submit" class="px-6 py-2 rounded-lg text-white font-medium liquid-btn hover:shadow-lg transition">
                                Complete Registration
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-6 text-center text-gray-400 text-sm">
        <p>© 2023 Cooperatiba. All rights reserved.</p>
    </footer>
</body>
</html>

<script>
    // Toggle password visibility
    function togglePasswordVisibility(fieldId) {
        const passwordInput = document.getElementById(fieldId);
        const showIcon = document.getElementById(`show${fieldId.charAt(0).toUpperCase() + fieldId.slice(1)}Icon`);
        const hideIcon = document.getElementById(`hide${fieldId.charAt(0).toUpperCase() + fieldId.slice(1)}Icon`);
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            showIcon.classList.add('hidden');
            hideIcon.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            hideIcon.classList.add('hidden');
            showIcon.classList.remove('hidden');
        }
    }
    
    // Form navigation
    function nextStep(current, next) {
        // Validate current step before proceeding
        if (validateStep(current)) {
            document.getElementById(`step${current}`).classList.remove('active');
            document.getElementById(`step${next}`).classList.add('active');
            
            // Update step indicator
            document.querySelector(`.step[data-step="${current}"]`).classList.remove('active');
            document.querySelector(`.step[data-step="${current}"]`).classList.add('completed');
            document.querySelector(`.step[data-step="${next}"]`).classList.add('active');
        }
    }
    
    function prevStep(current, prev) {
        document.getElementById(`step${current}`).classList.remove('active');
        document.getElementById(`step${prev}`).classList.add('active');
        
        // Update step indicator
        document.querySelector(`.step[data-step="${current}"]`).classList.remove('active');
        document.querySelector(`.step[data-step="${prev}"]`).classList.add('active');
    }
    
    // Basic step validation
    function validateStep(step) {
        let isValid = true;
        
        if (step === 1) {
            const studentNumber = document.getElementById('student_number').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (!studentNumber.match(/^\d{2}-\d{5}$/)) {
                alert('Please enter a valid student number (format: YY-XXXXX)');
                isValid = false;
            }
            
            if (password.length < 8) {
                alert('Password must be at least 8 characters long');
                isValid = false;
            }
            
            if (password !== confirmPassword) {
                alert('Passwords do not match');
                isValid = false;
            }
        } else if (step === 2) {
            const lastName = document.getElementById('last_name').value;
            const firstName = document.getElementById('first_name').value;
            
            if (!lastName || !firstName) {
                alert('Please fill in all required fields');
                isValid = false;
            }
        }
        
        return isValid;
    }
    
    // Form submission
    document.getElementById('registrationForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate all steps
        if (validateStep(1)){
            // Here you would typically send the form data to the server
            alert('Registration successful!');
            // window.location.href = '/dashboard'; // Redirect after successful registration
        }
    });
    
    // Calculate BMI when height or weight changes
    document.getElementById('height').addEventListener('input', calculateBMI);
    document.getElementById('weight').addEventListener('input', calculateBMI);
    
    function calculateBMI() {
        const height = parseFloat(document.getElementById('height').value) / 100; // convert cm to m
        const weight = parseFloat(document.getElementById('weight').value);
        
        if (height && weight) {
            const bmi = (weight / (height * height)).toFixed(1);
            document.querySelector('#step3 div:nth-child(4) div').textContent = bmi;
            
            // Simple size recommendation based on BMI
            let size = 'N/A';
            if (bmi < 18.5) {
                size = 'XS or S';
            } else if (bmi >= 18.5 && bmi < 25) {
                size = 'M';
            } else if (bmi >= 25 && bmi < 30) {
                size = 'L';
            } else if (bmi >= 30) {
                size = 'XL or XXL';
            }
            
            document.querySelector('#step3 div:nth-child(5) div').textContent = size;
        }
    }
</script>