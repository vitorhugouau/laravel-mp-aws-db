<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeEmail;
use Illuminate\Support\Facades\Session;
use App\Models\Usuarios;
use Illuminate\Support\Carbon;

class EmailVerificationController extends Controller
{
    public function showForm()
    {
        return view('email.verification_email');
    }

    public function sendVerificationCode(Request $request)
    {
       
        $request->validate(['email' => 'required|email']);

        $verificationCode = random_int(100000, 999999);

        Session::put('verification_code', $verificationCode);
        Session::put('verification_email', $request->input('email'));
        Session::put('verification_code_time', now()); 

        Mail::to($request->input('email'))->send(new VerificationCodeEmail($verificationCode));

        return back()->with('success', 'Código de verificação enviado para o email.');
    }

    public function verifyCode(Request $request)
    {
       
        $request->validate(['code' => 'required|numeric']);

        $enteredCode = $request->input('code');
        $savedCode = Session::get('verification_code');
        $email = Session::get('verification_email');
        $savedTime = Session::get('verification_code_time');

     
        if ($enteredCode == $savedCode) {
           
            if (Carbon::parse($savedTime)->addMinutes(10)->isPast()) {
                return back()->withErrors(['code' => 'O código de verificação expirou. Solicite um novo código.']);
            }

            $usuario = Usuarios::where('email', $email)->first();
            if ($usuario) {
                $usuario->email_verified_at = Carbon::now();
                $usuario->save();
            }

            Session::forget('verification_code');
            Session::forget('verification_email');
            Session::forget('verification_code_time');

            return redirect()->route('biblioteca')->with('success', 'Email verificado com sucesso!');
        } else {
            return back()->withErrors(['code' => 'Código de verificação inválido.']);
        }
    }
}
