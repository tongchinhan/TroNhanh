<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    // public function store(LoginRequest $request): JsonResponse
    // {
    //     try {
    //         $request->authenticate();
    //         $request->session()->regenerate();

    //         // Lấy URL trước đó (trang mà người dùng ở trước khi đăng nhập)
    //         $previousUrl = url()->previous();

    //         // Trả về URL trước đó trong phản hồi JSON
    //         return response()->json(['redirect' => $previousUrl]);
    //     } catch (ValidationException $e) {
    //         return response()->json(['errors' => $e->errors()], 422);
    //     }
    // }

    public function store(LoginRequest $request): JsonResponse|RedirectResponse
    {
        try {
            $request->authenticate();
            $request->session()->regenerate();

            $previousUrl = url()->previous();

            if ($request->wantsJson()) {
                return response()->json(['redirect' => $previousUrl]);
            }

            return redirect()->intended($previousUrl);
        } catch (ValidationException $e) {
            if ($request->wantsJson()) {
                return response()->json(['errors' => $e->errors()], 422);
            }

            return back()->withErrors($e->errors())->withInput();
        }
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
