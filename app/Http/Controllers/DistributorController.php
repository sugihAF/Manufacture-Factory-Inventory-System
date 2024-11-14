<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SparepartRequest;
use App\Models\Invoice;
use App\Models\Sparepart;

class DistributorController extends Controller
{
    public function dashboard()
    {
        $distributor = Auth::guard('distributor')->user();
        $sparepartRequests = SparepartRequest::where('distributor_id', $distributor->id)->get();
        $invoices = Invoice::where('distributor_id', $distributor->id)->get();

        return view('distributor.dashboard', compact('sparepartRequests', 'invoices'));
    }

    public function createRequest()
    {
        $spareparts = Sparepart::all();
        return view('distributor.create-request', compact('spareparts'));
    }

    public function storeRequest(Request $request)
    {
        $request->validate([
            'sparepart_id' => 'required|exists:spareparts,id',
            'qty' => 'required|integer|min:1',
        ]);

        $distributor = Auth::guard('distributor')->user();

        SparepartRequest::create([
            'distributor_id' => $distributor->id,
            'sparepart_id' => $request->sparepart_id,
            'qty' => $request->qty,
            'status' => 'Submitted',
            'request_date' => now(),
        ]);

        return redirect()->route('distributor.dashboard')->with('success', 'Request created successfully.');
    }

    public function deleteRequest($id)
    {
        $distributor = Auth::guard('distributor')->user();
        $request = SparepartRequest::where('id', $id)->where('distributor_id', $distributor->id)->firstOrFail();
        $request->delete();

        return redirect()->route('distributor.dashboard')->with('success', 'Request deleted successfully.');
    }
    public function pickupRequest(Request $request)
{
    $request->validate([
        'id' => 'required|exists:sparepart_requests,id',
    ]);

    $distributor = Auth::guard('distributor')->user();
    $sparepartRequest = SparepartRequest::where('id', $request->id)
        ->where('distributor_id', $distributor->id)
        ->first();

    if (!$sparepartRequest || $sparepartRequest->status !== 'Ready') {
        return response()->json(['success' => false, 'message' => 'Invalid request.'], 400);
    }

    // Update the request status to 'Done'
    $sparepartRequest->status = 'Done';
    $sparepartRequest->save();

    // Update the associated Workload status to 'Done'
    $workload = Workload::where('request_id', $sparepartRequest->id)->first();
    if ($workload) {
        $workload->status = 'Done';
        $workload->save();
    }

    return response()->json(['success' => true]);
}
}