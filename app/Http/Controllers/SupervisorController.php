<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SparepartRequest;

class SupervisorController extends Controller
{
    public function dashboard()
    {
        $sparepartRequests = SparepartRequest::with(['sparepart', 'distributor'])->get();
        return view('supervisor.dashboard', compact('sparepartRequests'));
    }

    public function updateStatus(Request $request)
{
    $request->validate([
        'id' => 'required|exists:sparepart_requests,id',
        'status' => 'required|in:Confirmed,Pending,Rejected',
    ]);

    $sparepartRequest = SparepartRequest::findOrFail($request->id);
    $sparepartRequest->status = $request->status;
    $sparepartRequest->save();

    return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
}
}