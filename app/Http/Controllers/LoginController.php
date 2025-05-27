<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;


class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('previous_url', URL::previous());
        return view('FrontEnd.login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('FrontEnd.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 1. Kiểm tra reCAPTCHA
        $recaptcha = $request->input('g-recaptcha-response');

        if (!$recaptcha) {
            return back()->with('message_err', 'Vui lòng xác nhận bạn không phải là robot.');
        }

        // 2. Gửi xác minh reCAPTCHA đến Google
        $http = Http::asForm();

        // 👉 Nếu không phải production thì bỏ verify SSL
        if (!app()->environment('production')) {
            $http = $http->withoutVerifying();
        }

        $response = $http->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $recaptcha,
            'remoteip' => $request->ip(),
        ]);

        if (!$response->json('success')) {
            return back()->with('message_err', 'Xác thực captcha không thành công.');
        }

        // 3. Thử đăng nhập bằng email hoặc username
        $check_email = ['email' => $request->email_login, 'password' => $request->password_login];
        $check_username = ['username' => $request->email_login, 'password' => $request->password_login];

        if (Auth::attempt($check_username) || Auth::attempt($check_email)) {
            // 4. Gửi email sau đăng nhập
            Mail::to(Auth::user()->email)->send(new WelcomeMail(Auth::user()));

            // 5. Redirect theo quyền
            if (Auth::user()->level == 1) {
                return Redirect::to(Session::get('previous_url'))->with('message', 'Hi, ' . Auth::user()->name);
            } else {
                return redirect()->route('dashboard.index')->with('message', 'Hi, ' . Auth::user()->name);
            }
        } else {
            return redirect()->back()->withInput()->with('message_err', 'Tên đăng nhập hoặc mật khẩu không đúng!');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
