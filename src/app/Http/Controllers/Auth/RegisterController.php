<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $request->session()->put('registered_user', [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            event(new Registered($user));

            Auth::login($user);
        } catch (Throwable $exception) {
            $request->session()->put('logged_in_user', [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            return redirect('/verify-email');
        }

        return redirect('/verify-email');
    }
}
