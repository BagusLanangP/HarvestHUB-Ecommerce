<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class DashboardUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('role');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('role') && $request->role != '') {
            $query->where('role_id', $request->role);
        }

        $users = $query->paginate(10);
        $roles = Role::all();
        
        return view('dashboard.user.index', compact('users', 'roles'));
    }

    public function show(User $user)
    {
        return view('dashboard.user.view', ['user' => $user]);
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('dashboard.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:14',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:aktif,banned',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'min:8';
        }

        $validated = $request->validate($rules);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }

    public function ban(User $user)
    {
        $newStatus = $user->status === 'banned' ? 'aktif' : 'banned';
        $user->update(['status' => $newStatus]);
        $message = $newStatus === 'banned' ? 'User has been banned.' : 'User ban revoked.';
        return redirect()->route('user.index')->with('success', $message);
    }

    public function backup(User $user)
    {
        $filename = "backup_user_{$user->email}.csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Name', 'Email', 'Phone', 'Role', 'Status', 'Joined Date'];

        $callback = function() use($user, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            $row['ID']  = $user->id;
            $row['Name']    = $user->name;
            $row['Email']    = $user->email;
            $row['Phone']  = $user->phone;
            $row['Role']  = $user->role->name ?? 'N/A';
            $row['Status']  = $user->status;
            $row['Joined Date']  = $user->created_at;

            fputcsv($file, array($row['ID'], $row['Name'], $row['Email'], $row['Phone'], $row['Role'], $row['Status'], $row['Joined Date']));

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
