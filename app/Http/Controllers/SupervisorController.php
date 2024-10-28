<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SparepartRequest;

class SupervisorController extends Controller
{
    public function dashboard()
    {
        $newRequests = SparepartRequest::with(['sparepart', 'distributor'])
            ->where('status', 'Submitted')
            ->get();

        $ongoingRequests = SparepartRequest::with(['sparepart', 'distributor'])
            ->whereIn('status', ['Confirmed', 'Pending', 'On Progress', 'Ready'])
            ->get();

        $historyRequests = SparepartRequest::with(['sparepart', 'distributor'])
            ->whereIn('status', ['Done', 'Rejected'])
            ->get();

        return view('supervisor.dashboard', compact('newRequests', 'ongoingRequests', 'historyRequests'));
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