<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $usersCount = \App\Models\User::count();
        $documentsCount = \App\Models\Document::count();
        $pendingCount = \App\Models\Document::where('status', 'pending')->count();
        
        return view('admin.dashboard', compact('usersCount', 'documentsCount', 'pendingCount'));
    }

    public function index()
    {
        $users = \App\Models\User::with('role')->paginate(10);
        $roles = \App\Models\Role::all();
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->back()->with('success', 'User created successfully.');
    }

    public function show($id)
    {
        $user = \App\Models\User::with('role', 'documents.verificationLogs', 'student.generatedDocuments')->findOrFail($id);
        
        return view('admin.users.show', compact('user'));
    }
}
