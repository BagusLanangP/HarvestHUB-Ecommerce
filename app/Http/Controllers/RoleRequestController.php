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
            'identity_id' => 'required|string|max:50',
            'whatsapp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'birth_date' => 'required|date',
            'domicile' => 'required|string|max:255',
            'reason' => 'required|string',
            'document' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:2048',
        ]);

        $requestedRole = Role::findOrFail($request->requested_role_id);
        $roleName = $requestedRole->name;

        $metaRules = [];
        if ($roleName === 'Penjual') {
            $metaRules = [
                'meta.shop_name' => 'required|string|max:255',
                'meta.shop_address' => 'required|string|max:255',
            ];
        } elseif ($roleName === 'Ahli Pakar') {
            $metaRules = [
                'meta.expertise' => 'required|string|max:255',
                'meta.experience' => 'required|string|max:255',
            ];
        } elseif ($roleName === 'Tenaga Kerja') {
            $metaRules = [
                'meta.skills' => 'required|string|max:255',
                'meta.rate' => 'required|string|max:255',
            ];
        }

        if (!empty($metaRules)) {
            $request->validate($metaRules);
        }

        $path = null;
        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('role_requests', 'public');
        }

        RoleRequest::create([
            'user_id' => Auth::id(),
            'requested_role_id' => $request->requested_role_id,
            'identity_id' => $request->identity_id,
            'whatsapp' => $request->whatsapp,
            'email' => $request->email,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'domicile' => $request->domicile,
            'metadata' => $request->input('meta', []),
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

    // For Admins: View details of a specific role request
    public function show(RoleRequest $roleRequest)
    {
        $roleRequest->load(['user', 'role']);
        return view('dashboard.role_requests.show', compact('roleRequest'));
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
            
            return redirect()->back()->with([
                'success' => 'Status pengajuan berhasil diperbarui menjadi DISETUJUI.',
                'notify_approved' => true,
                'notify_whatsapp_number' => $roleRequest->whatsapp,
                'notify_email_address' => $roleRequest->email,
                'notify_user_name' => $roleRequest->user->name,
                'notify_role_name' => $roleRequest->role->name
            ]);
        }

        return redirect()->back()->with([
            'success' => 'Status pengajuan berhasil diperbarui menjadi DITOLAK.',
            'notify_rejected' => true,
            'notify_whatsapp_number' => $roleRequest->whatsapp,
            'notify_email_address' => $roleRequest->email,
            'notify_user_name' => $roleRequest->user->name,
            'notify_role_name' => $roleRequest->role->name
        ]);
    }
}
