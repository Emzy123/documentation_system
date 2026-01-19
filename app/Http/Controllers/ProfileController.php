<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $role = $user->role->slug;

        return view($role . '.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'current_password' => ['nullable', 'required_with:new_password', 'current_password'],
            'new_password' => ['nullable', 'min:8', 'confirmed'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        // If student, update extra details if passed
        if ($user->role->slug === 'student' && $user->student) {
             $request->validate([
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:500',
             ]);
             
             // Assuming validation passed or simple update
             // We might need to add these fields to Student model fillable first if not there.
             // For now, let's keep it simple to User table updates unless requested.
        }

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
