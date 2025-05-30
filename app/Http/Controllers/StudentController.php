<?php
namespace App\Http\Controllers;

use App\Models\StudentModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    // Show registration form
    public function showRegisterForm()
    {
        return view('web.register');
    }

    // Handle registration
    public function register(Request $request)
    {

        DB::beginTransaction();

        try {
            $request->validate([
                'student_number' => 'required|regex:/^\d{2}-\d{5}$/|unique:student,student_number',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed|min:8',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'program' => 'required|string|max:255',
                'year_level' => 'required|integer|between:1,5',
                'section' => 'required|string|max:10',
                'phone_number' => 'nullable|string|max:20',
                'address' => 'nullable|string',
                'age' => 'nullable|integer|min:16|max:99',
                'gender' => 'nullable|string',
                'height' => 'nullable|numeric|min:0',
                'weight' => 'nullable|numeric|min:0',
                // bmi and suggested_size are calculated fields, no validation needed
            ]);
        // Log user creation attempt
            \Log::info('Attempting to create user with email: ' . $request->email);
            
            $user = User::create([
                'name' => $request->first_name.' '.$request->last_name,
                'email' => $request->email,
                'student_number' => $request->student_number,
                'password' => Hash::make($request->password),
            ]);
            
            \Log::info('User created with ID: ' . $user->id);

            // Log student creation attempt
            \Log::info('Attempting to create student for user ID: ' . $user->id);

            $student = StudentModel::create([
                'user_id' => $user->id,
                'student_number' => $request->student_number,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'middle_initial' => $request->middle_initial,
                'program' => $request->program,
                'year_level' => $request->year_level,
                'section' => $request->section,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'age' => $request->age,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
                'height' => $request->height,
                'weight' => $request->weight,

            ]);

            \Log::info('Student created with ID: ' . $student->id);

            DB::commit();
            \Log::info('Transaction committed successfully for user ID: ' . $user->id);

            Auth::login($user);
            return redirect()->route('web.items')->with('success', 'Registration successful!');
        } 
        catch (\Exception $e) 
        {
            DB::rollBack();
            \Log::error('Registration error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Registration failed. Please try again.'])->withInput();
        }
    }

    // Show login form
    public function showLoginForm()
    {
        return view('web.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'student_number' => 'required|string',
            'password' => 'required|string',
        ]);
        $user = User::where('student_number', $request->student_number)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // 'remember' will be "on" when checked, null when not
            $remember = $request->has('remember');
            Auth::login($user, $remember);
            
            $request->session()->regenerate();
            return redirect()->route('web.items');
        }
        
        // If login fails, redirect back with error
        return back()->withErrors([
            'student_number' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('student_number'));
    }

    // Show dashboard (sample)
    public function dashboard()
    {
        $student = Auth::user()->student;
        return view('web.items', compact('student'));
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('web.login'); // or wherever you want to redirect after logout
    }
}
