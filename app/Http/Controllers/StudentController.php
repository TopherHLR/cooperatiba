<?php
namespace App\Http\Controllers;

use App\Models\StudentModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderModel;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\OrderResource;
use Illuminate\Support\Facades\Log;

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
            Log::info('Attempting to create user with email: ' . $request->email);
            
            $user = User::create([
                'name' => $request->first_name.' '.$request->last_name,
                'email' => $request->email,
                'student_number' => $request->student_number,
                'password' => Hash::make($request->password),
            ]);
            
            Log::info('User created with ID: ' . $user->id);

            // Log student creation attempt
            Log::info('Attempting to create student for user ID: ' . $user->id);

            $student = StudentModel::create([
                'student_id' => $user->id, 
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
                'bmi' => $request->bmi,
                'suggested_size' => $request->suggested_size // only if not generated
            ]);

            Log::info('Student created with ID: ' . $student->id);

            DB::commit();
            Log::info('Transaction committed successfully for user ID: ' . $user->id);

            Auth::login($user);
            return redirect()->route('web.items')->with('success', 'Registration successful!');
        } 
        catch (\Exception $e) 
        {
            DB::rollBack();
            Log::error('Registration error: ' . $e->getMessage());
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
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginInput = $request->input('login');
        $passwordInput = $request->input('password');

        // Determine user by email or student_number
        if (filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $loginInput)->where('role', 'admin')->first();
        } else {
            $user = User::where('student_number', $loginInput)->where('role', 'student')->first();
        }
        if ($user) {
            Log::info('User found', [
                'user_id' => $user->id,
                'email' => $user->email,
                'student_number' => $user->student_number,
            ]);

            if (Hash::check($passwordInput, $user->password)) {
                Log::info('Password match successful', ['user_id' => $user->id]);


                $remember = $request->has('remember');
                Auth::login($user, $remember);
                $request->session()->regenerate();

                return $user->isAdmin()
                    ? redirect()->route('admin.dashboard')
                    : redirect()->route('web.items');
            } else {
                Log::warning('Password mismatch', [
                    'user_id' => $user->id,
                    'input_password' => $passwordInput,
                    'stored_hash' => $user->password,
                ]);
            }
        } else {
            Log::warning('User not found for login input', ['login_input' => $loginInput]);
        }

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('login'));
    }
    // Show account settings
    public function accountSettings()
    {
        $user = Auth::user();
        $student = $user->student;

        return view('accountsettings', compact('student', 'user'));
    }
    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('web.login'); // or wherever you want to redirect after logout
    }
    public function update(Request $request)
    {

        /** @var \App\Models\User $user */
        $user = Auth::user();

        /** @var \App\Models\StudentModel $student */
        $student = $user->student;
        
        if (!$student) {
            Log::error('Student record not found for user', ['user_id' => $user->id]);
            return back()->withErrors(['error' => 'Student record not found.']);
        }
        

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_initial' => 'nullable|string|max:1',
            'program' => 'required|string|max:255',
            'year_level' => 'required|integer|between:1,5',
            'section' => 'required|string|max:10',
            'phone_number' => 'nullable|string|max:20',
            'gender' => 'required|string|in:male,female,other',
            'height' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
        ]);
        

        DB::beginTransaction();
        Log::info('Database transaction started');

        try {
            // Update user info
            $userUpdateData = [
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
            ];
            
            Log::debug('Updating user with data', $userUpdateData);
            $user->update($userUpdateData);
            Log::info('User updated successfully');

            // Update student info
            $studentUpdateData = [
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
                'gender' => $request->gender,
                'height' => $request->height,
                'weight' => $request->weight,
                'bmi' => $request->bmi,
                'suggested_size' => $request->suggested_size,
            ];
            
            $student->update($studentUpdateData);

            DB::commit();
            
            return back()->with('success', 'Account updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Update error', [
                'message' => $e->getMessage(),
                'exception' => $e,
                'request_data' => $request->all(),
                'user_id' => $user->id
            ]);
            
            return back()->withErrors(['error' => 'Update failed. Please try again.'])->withInput();
        }
    }
    public function orders(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated'
                ], 401);
            }

            $student = \App\Models\StudentModel::where('student_number', $user->student_number)->first();
            if (!$student) {

                return response()->json([
                    'success' => false,
                    'message' => 'Student record not found.'
                ], 404);
            }

            $orders = \App\Models\OrderModel::where('student_id', $student->student_id)
                ->with(['orderItems.uniform', 'statusHistories'])
                ->orderBy('order_date', 'desc')
                ->get();


            return response()->json([
                'success' => true,
                'orders' => OrderResource::collection($orders)
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to fetch orders', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch orders: ' . $e->getMessage()
            ], 500);
        }
    }



}
