<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sparepart;
use App\Models\SparepartRequest;

class DistributorController extends Controller
{
    public function dashboard()
    {
        $distributor = Auth::guard('distributor')->user();
        $sparepartRequests = SparepartRequest::where('distributor_id', $distributor->id)->get();
        return view('distributor.dashboard', compact('sparepartRequests'));
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
            'status' => 'pending',
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
}