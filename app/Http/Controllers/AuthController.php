<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Str;
use App\Mail\OtpMail;
use App\Services\UserServices;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{

    private $user;

    public function __construct(UserServices $user)
    {
        $this->user = $user;
    }


    //! funcion para mostrar la vista del inicio de sesion
    public function loginPage()
    {
        return view('pages.actions_auth.login');
    }

    //! funcion para mostrar la vista de ingreso de correo para restablecer contraseña
    public function forgotPasswordPage()
    {
        return view('pages.actions_auth.email');
    }

    //! funcion para mostrar la vista del registro
    public function signUpPage()
    {
        return view('pages.actions_auth.signUp');
    }


    //! funcion para redirigir al usuario para que inicie sesion con cuneta de google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    //! funcion para que el usuario pueda iniciar sesion o crear su cuenta mediante google
    public function handelGoogleCallback()
    {
        try {
            $googleUSer = Socialite::driver('google')->stateless()->user();

            $user = User::firstOrCreate(
                ["email" => $googleUSer->email],

                [
                    "name" => $googleUSer->name,
                    "email" => $googleUSer->email,
                    "email_verified_at" => now()->format("Y-m-d H:i:s"),
                    "password" => Hash::make(Str::random(10)),
                ]
            )->assignRole('user');

            Auth::login($user);

            return redirect()->route('dashboard');
        } catch (\Throwable $e) {
            Log::info('Error al iniciar sesión con Google: ' . $e->getMessage());
            return redirect()->route('loginPage')->with('error', 'Error al iniciar sesión con Google');
        }
    }

    //! funcion para crear una cuenta manualmente
    public function sigUp(Request $request)
    {
        try {
            $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users,email',
                'password' => 'required|min:6|string',
            ]);

            //! el cero con comillas significa que se le agregaran ceros a la izquierda hasta completar los digitos
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);


            //! se guarda el id del usuario en la sesion para luego verificar el codigo de verificacion
            //! la sesion es un espacio de almacenamiento temporal que se utiliza para guardar datos
            Session([
                "pending_user" => [
                    "name" => $request->name,
                    "email" => $request->email,
                    "password" => Hash::make($request->password),
                    'otp_code' => $code,
                    'otp_expires_at' => now()->addMinutes(10)->toDateTimeString(),
                ]
            ]);

            //! en send se le pasa el correo del usuario y se le envia el codigo de verificacion mediante el correo
            Mail::to($request->email)->send(new OtpMail($code));

            return redirect()->route('otp.form');
        } catch (\Exception $e) {
            Log::info('Error al crear la cuenta: ' . $e->getMessage());
            return redirect()->route('signUpPage')->with('error', 'Error al crear la cuenta');
        }
    }

    //! funcion para mostrar el formulario de codigo de verificacion
    public function showOtp()
    {
        try {
            if (!session()->has('pending_user') || !session()->has('pending_user.otp_code')) {
                return redirect()->route('signUpPage');
            }

            return view('pages.actions_auth.verify_otp');
        } catch (\Exception $e) {
            Log::info('Error al mostrar el formulario de OTP: ' . $e->getMessage());
            return redirect()->route('signUpPage')->with('error', 'Error al mostrar el formulario de OTP');
        }
    }



    //! funcion para verificar el codigo de validacion del email y crear el usuario
    public function verifyOtp(Request $request)
    {
        try {
            $request->validate(['code' => 'required|digits:6']);

            if (!session()->has('pending_user') || !session()->has('pending_user.otp_code')) {
                return redirect()->route('signUpPage')->withErrors(['email' => 'La sesión expiró. Inténtalo de nuevo.']);
            }

            $userData = session('pending_user');

            //! se convierte la fecha de expiracion del codigo a un objeto Carbon para poder compararlo con la fecha actual
            $otpExpiresAt = \Carbon\Carbon::parse($userData['otp_expires_at']);

            if ($request->code !== $userData['otp_code'] || now()->isAfter($otpExpiresAt)) {
                return back()->withErrors(['code' => 'Código incorrecto o expirado.']);
            }

            $this->user->createUser($userData);

            session()->forget('pending_user'); //! se elimina la sesion del usuario correspondiente

            return redirect()->route('loginPage')->with('message', '¡Cuenta creada exitosamente! Ya puedes iniciar sesión.');
        } catch (\Exception $e) {
            Log::info('Error al verificar el codigo de verificacion: ' . $e->getMessage());
            return redirect()->route('signUpPage')->with('error', 'Error al verificar el codigo de verificacion');
        }
    }

    //! funcion para el reenvio del codigo de validacion del email
    public function resendOtpCode()
    {
        try {
            //! determina si el reenvio es para registro o para recuperacion de contraseña
            if (session()->has('pending_user')) {

                $newCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                $pendingUser = session('pending_user');
                $pendingUser['otp_code'] = $newCode;
                $pendingUser['otp_expires_at'] = now()->addMinutes(10)->toDateTimeString();
                session(['pending_user' => $pendingUser]);
                Mail::to($pendingUser['email'])->send(new OtpMail($newCode));

            } elseif (session()->has('pending_forgot_password')) {

                $newCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                $pendingForgot = session('pending_forgot_password');
                $pendingForgot['otp_code'] = $newCode;
                $pendingForgot['otp_expires_at'] = now()->addMinutes(10)->toDateTimeString();
                session(['pending_forgot_password' => $pendingForgot]);
                Mail::to($pendingForgot['email'])->send(new OtpMail($newCode));

            } else {
                return redirect()->route('loginPage')->withErrors(['email' => 'La sesión expiró. Inténtalo de nuevo.']);
            }

            return back()->with('message', '¡Se ha reenviado un nuevo código a tu correo electrónico!');
        } catch (\Exception $e) {
            Log::info('Error al reenviar el codigo de verificacion: ' . $e->getMessage());
            return back()->with('error', 'Error al reenviar el codigo de verificacion');
        }
    }


    //! funcion para iniciar sesion manualmente
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email'    => 'required|email|exists:users,email',
                'password' => 'required|min:6|string',
            ]);

            $remenberSession = $request->has('remember');

            if (Auth::attempt($credentials, $remenberSession)) { //!Auth::attempt() es un metodo que se utiliza para verificar si las credenciales del usuario son correctas
                $request->session()->regenerate();

                return redirect()->intended('/dashboard'); //! intended sirve para redirigir al usuario a la pagina que intentaba acceder antes de ser autenticado
            }

            return back()->withErrors([
                'email' => 'Las credenciales no coinciden con nuestros registros.',
            ])->onlyInput('email'); //! onlyInput sirve para que solo se muestre el error en el campo de correo electronico

        } catch (\Exception $e) {
            Log::info('Error al iniciar sesion: ' . $e->getMessage());
            return redirect()->route('loginPage')->with('error', 'Error al iniciar sesion');
        }
    }



    //! funcion para mostrar el formulario de codigo de verificacion
    public function showOtpPass()
    {
        try {
            if (!session()->has('pending_forgot_password') || !session()->has('pending_forgot_password.otp_code')) {
                return redirect()->route('forgotPasswordPage');
            }

            return view('pages.actions_auth.otp_pass');
        } catch (\Exception $e) {
            Log::info('Error al mostrar el formulario de OTP: ' . $e->getMessage());
            return redirect()->route('forgotPasswordPage')->with('error', 'Error al mostrar el formulario de OTP');
        }
    }


    public function forgotPasswordPost(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
            ]);

            //! el cero con comillas significa que se le agregaran ceros a la izquierda hasta completar los digitos
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            //! se guarda el id del usuario en la sesion para luego verificar el codigo de verificacion
            //! la sesion es un espacio de almacenamiento temporal que se utiliza para guardar datos
            Session([
                "pending_forgot_password" => [
                    "email" => $request->email,
                    'otp_code' => $code,
                    'otp_expires_at' => now()->addMinutes(10)->toDateTimeString(),
                ]
            ]);

            //! en send se le pasa el correo del usuario y se le envia el codigo de verificacion mediante el correo
            Mail::to($request->email)->send(new OtpMail($code));

            return redirect()->route('otp.form.pass');
        } catch (\Exception $e) {
            Log::info('Error al crear la cuenta: ' . $e->getMessage());
            return redirect()->route('forgotPassword')->with('error', 'Error al crear la cuenta');
        }
    }



    //! funcion para verificar el codigo OTP del proceso de recuperacion de contraseña
    public function verifyOtpPass(Request $request)
    {
        try {
            $request->validate(['code' => 'required|digits:6']);

            if (!session()->has('pending_forgot_password') || !session()->has('pending_forgot_password.otp_code')) {
                return redirect()->route('password.request')->withErrors(['email' => 'La sesión expiró. Inténtalo de nuevo.']);
            }

            $sessionData = session('pending_forgot_password');

            //! se convierte la fecha de expiracion del codigo a un objeto Carbon para poder compararlo con la fecha actual
            $otpExpiresAt = \Carbon\Carbon::parse($sessionData['otp_expires_at']);

            if ($request->code !== $sessionData['otp_code'] || now()->isAfter($otpExpiresAt)) {
                return back()->withErrors(['code' => 'Código incorrecto o expirado.']);
            }

            //! Creamos una URL firmada que expira en 15 minutos
            //! Pasamos el email del usuario en la URL para saber a quién le cambiaremos la clave
            $urlFirmada = URL::temporarySignedRoute(
                'password.reset.form',
                now()->addMinutes(15),
                ['email' => $sessionData['email']]
            );

            session()->forget('pending_forgot_password'); //! se elimina la sesion del usuario correspondiente

            return redirect($urlFirmada);
        } catch (\Exception $e) {
            Log::info('Error al verificar el codigo de verificacion (forgot password): ' . $e->getMessage());
            return redirect()->route('password.request')->with('error', 'Error al verificar el código');
        }
    }


    //! muestra el formulario para ingresar la nueva contraseña (requiere URL firmada)
    public function showPasswordResetForm(Request $request, $email)
    {
        if (!$request->hasValidSignature()) {
            abort(403, 'El enlace ha expirado o no es válido.');
        }

        return view('pages.actions_auth.password', ['email' => $email]);
    }

    //! actualiza la contraseña del usuario
    public function updatePassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
                'password' => 'required|min:8|string|confirmed',
            ]);

            $updated = $this->user->updatePassword($request->email, $request->password);

            if (!$updated) {
                return back()->with('error', 'No se encontró el usuario.');
            }

            return redirect()->route('loginPage')->with('message', '¡Contraseña actualizada correctamente! Ya puedes iniciar sesión.');
        } catch (\Exception $e) {
            Log::info('Error al actualizar la contraseña: ' . $e->getMessage());
            return back()->with('error', 'Error al actualizar la contraseña.');
        }
    }



    //! funcion para cerrar sesion
    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate(); //! desctruye la sesion actual
            $request->session()->regenerateToken(); //! regenera el token csrf

            return redirect()->route('loginPage');
        } catch (\Exception $e) {
            Log::info('Error al cerrar sesion: ' . $e->getMessage());
            return redirect()->route('loginPage')->with('error', 'Error al cerrar sesion');
        }
    }
}
