<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SparepartRequest;
use App\Models\Invoice;
use Carbon\Carbon;

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

        // Create an invoice if the status is 'Confirmed'
        if ($request->status === 'Confirmed') {
            Invoice::create([
                'distributor_id' => $sparepartRequest->distributor_id,
                'request_id' => $sparepartRequest->id,
                'total_amount' => $sparepartRequest->qty * $sparepartRequest->sparepart->price,
                'invoice_date' => Carbon::now(),
                'due_date' => Carbon::now()->addWeek(),
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
    }
}