<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\FileUploader;
use App\Models\User;
use App\Models\ZapierSetting;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    public function StudentRegisterForm(): View
    {

        return view('auth.student_register');
    }


    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $input = $request->all();
        // dd($input);
        if (get_frontend_settings('recaptcha_status') == true && check_recaptcha($input['g-recaptcha-response']) == false) {

            Session::flash('error', get_phrase('Recaptcha verification failed'));

            return redirect(route('register.form'));
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string',  'regex:/^[A-Za-z\s]+$/', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'phone' => ['required', 'regex:/^\+[1-9]\d{6,14}$/', 'unique:users,phone'],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user_data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => 'student',
            'source' => 'web',
            'status' => 1,
            'password' => Hash::make($request->password),
        ];

        if (get_settings('student_email_verification') != 1) {
            $user_data['email_verified_at'] = Carbon::now();
        }

        $user = User::create($user_data);

        // if (zapier_status_check('user_registration')) {
        //     // Fetch the Zapier setting for 'user_registration'
        //     $zap = ZapierSetting::where('slug', 'user_registration')->where('status', 1)->first();

        //     if ($zap && !empty($zap->webhook_url)) {
        //         // Send webhook to Zapier
        //         Http::post($zap->webhook_url, [
        //             'user' => [
        //                 'name' => $user->name,
        //                 'email' => $user->email,
        //                 'registered_at' => now()->toDateTimeString(),
        //             ]
        //         ]);
        //     }
        // }


        event(new Registered($user));

        Auth::login($user);

        // If applying as an instructor, process the application
        if ($request->has('instructor')) {

            // Check if application already exists
            if (Application::where('user_id', $user->id)->exists()) {
                Session::flash('error', get_phrase('Your request is in process. Please wait for admin to respond.'));
                return redirect()->route('become.instructor');
            }

            // Process instructor application
            $application['user_id'] = $user->id;
            $application['phone'] = $request->phone;
            $application['description'] = $request->description;

            // Upload document
            $doc = $request->file('document');
            $application['document'] = 'uploads/applications/' . $user->id . Str::random(20) . '.' . $doc->extension();

            FileUploader::upload($doc, $application['document'], null, null, 300);

            // Store application
            Application::insert($application);

            Session::flash('success', get_phrase('Your application has been submitted.'));
        }

        return redirect(RouteServiceProvider::HOME);
    }

    public function StudentRegister(Request $request)
    {
        // die(' plplpl');
        $input = $request->all();
        // echo "<pre>";
        // print_R($input);
        // die(' plplplp');

        if (get_frontend_settings('recaptcha_status') == true && check_recaptcha($input['g-recaptcha-response']) == false) {
            Session::flash('error', get_phrase('Recaptcha verification failed'));
            return redirect(route('register.form'));
        }

        // OTP verified check
        // if (!session('otp_verified')) {
        //     return redirect()->back()->with('error', 'Please verify OTP first')->withInput();
        // }

        $validator = Validator::make($request->all(), [
            // 'name'  => ['required', 'string', 'regex:/^[A-Za-z\s]+$/', 'max:255'],
            'phone' => ['required', 'regex:/^\+[1-9]\d{6,14}$/', 'unique:users,phone'],
            'password' => ['required', 'regex:/^[^\s]+$/'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // User data
        $user_data = [
            'name'   => $request->name,
            'phone'  => $request->phone,
            'password'  => Hash::make($request->password),
            'role'   => 'student',
            'source' => 'web',
            'status' => 1,
        ];

        // Create user
        $user = User::create($user_data);

        // OTP session clear after signup
        // session()->forget(['otp_verified', 'login_otp', 'login_phone']);

        // WhatsApp message after registration
        $phone = $user->phone;

        $message = "🎉 *TSBOS Registration Successfully!* 🎉\n\n" .
            "Hello *{$user->name}*,\n\n" .
            "Welcome! Your account has been successfully registered on our platform. ✅\n\n" .
            "📱 *Registered Mobile:* {$user->phone}\n\n" .
            "You can now login and start exploring our courses and services.\n\n" .
            "🙏 Regards,\n" .
            "The Sommnath Bhattacharyaa Occult Sciences";

        $message = urlencode($message);

        // $url = "https://listingbook.in/divine?number={$phone}&message={$message}";

        // try {
        //     file_get_contents($url);
        // } catch (\Exception $e) {
        //     Log::error('WhatsApp API Error: ' . $e->getMessage());
        // }

        return redirect()->route('student.login.form')
            ->with('success', get_phrase('Registration successfully completed. Please login.'));
    }

    public function sendRegisterOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required'
        ]);

        $otp = rand(1000, 9999);

        session([
            'register_otp' => $otp,
            'register_phone' => $request->phone,
            'register_name' => $request->name,
            'register_email' => $request->email,
            'register_password' => $request->password
        ]);

        $phone = $request->phone;

        $message = urlencode("Your TSBOS signup OTP is $otp");

        // $url = "https://listingbook.in/divine?number=$phone&message=$message";

        // file_get_contents($url);

        return response()->json([
            'status' => true
        ]);
    }

    public function verifyRegisterOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        if (session('register_otp') != $request->otp) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid OTP'
            ]);
        }

        $user = User::create([
            'name' => session('register_name'),
            'email' => session('register_email'),
            'phone' => session('register_phone'),
            'password' => Hash::make(session('register_password')),
            'role' => 'student',
            'status' => 1
        ]);

        Auth::login($user);

        session()->forget([
            'register_otp',
            'register_phone',
            'register_name',
            'register_email',
            'register_password'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'OTP Verified Successfully ✅'
        ]);
    }
}
