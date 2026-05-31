<?php

namespace App\Http\Controllers;

use App\Models\RoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleRequestController extends Controller
{
    // For Users: Show the form to request a role upgrade
    public function create()
    {
        $roles = Role::whereIn('name', ['Tenaga Kerja', 'Ahli Pakar', 'Penjual'])->get();
        return view('role_requests.create', compact('roles'));
    }

    // For Users: Submit the role upgrade request
    public function store(Request $request)
    {
        $request->validate([
            'requested_role_id' => 'required|exists:roles,id',
            'reason' => 'required|string',
            'document' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('role_requests', 'public');
        }

        RoleRequest::create([
            'user_id' => Auth::id(),
            'requested_role_id' => $request->requested_role_id,
            'reason' => $request->reason,
            'document_path' => $path,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Pengajuan role berhasil dikirim dan sedang menunggu persetujuan.');
    }

    // For Admins: View pending requests
    public function index()
    {
        $requests = RoleRequest::with(['user', 'role'])
                                ->where('status', 'pending')
                                ->orderBy('created_at', 'desc')
                                ->get();
        return view('dashboard.role_requests.index', compact('requests'));
    }

    // For Admins: Approve or Reject a request
    public function update(Request $request, RoleRequest $roleRequest)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $roleRequest->update(['status' => $request->status]);

        if ($request->status === 'approved') {
            $roleRequest->user->update(['role_id' => $roleRequest->requested_role_id]);
        }

        return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }
}
