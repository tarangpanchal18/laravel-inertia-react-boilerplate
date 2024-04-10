<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard');
    }

    public function profile(): View
    {
        return view('admin.profile', [
            'actionUrl' => route('admin.updateProfile'),
            'user' => auth()->user(),
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'email' => [
                'required','email','min:4','max:40',Rule::unique('admins', 'email')->ignore(auth()->user()->id),
            ],
            'name' => ['required', 'string', 'min:3'],
            'password' => ['nullable', 'min:6', 'max:12'],
        ]);

        if ($validatedData['password']) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        Admin::where('id', auth()->user()->id)
            ->update($validatedData);

        return redirect()->route('admin.profile')
            ->with('success', 'Profile updated successfully !');
    }


}
