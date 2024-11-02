<?php

namespace App\Http\Controllers;

use App\Models\SparepartRequest;
use App\Models\Distributor;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SparepartRequestController extends Controller
{
    /**
     * Display a listing of the sparepart requests for Distributors.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check if the user is a Distributor or Supervisor
        if (Auth::guard('distributor')->check()) {
            // Get the authenticated Distributor
            $distributor = Auth::guard('distributor')->user();

            // Retrieve sparepart requests for this Distributor
            $requests = SparepartRequest::where('distributor_id', $distributor->id)
                                        ->with('sparepart')
                                        ->orderBy('request_date', 'desc')
                                        ->paginate(10);

            return view('sparepart_requests.distributor.index', compact('requests'));
        } elseif (Auth::guard('supervisor')->check()) {
            // For Supervisors, retrieve all sparepart requests
            $requests = SparepartRequest::with(['sparepart', 'distributor'])
                                        ->orderBy('request_date', 'desc')
                                        ->paginate(15);

            return view('sparepart_requests.supervisor.index', compact('requests'));
        }

        // If not authenticated as Distributor or Supervisor, redirect to login
        return redirect()->route('login')->with('error', 'Access denied.');
    }

    /**
     * Show the form for creating a new sparepart request (Distributor only).
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Ensure the user is a Distributor
        if (!Auth::guard('distributor')->check()) {
            return redirect()->route('sparepart-requests.index')->with('error', 'Access denied.');
        }

        $distributor = Auth::guard('distributor')->user();

        // Retrieve all spareparts
        $spareparts = Sparepart::all();

        return view('sparepart_requests.distributor.create', compact('distribute
r', 'spareparts'));
    }

    /**
     * Store a newly created sparepart request in storage (Distributor only).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        // Ensure the user is a Distributor
        if (!Auth::guard('distributor')->check()) {
            return redirect()->route('sparepart-requests.index')->with('error', 'Access denied.');
        }

        // Validate the incoming request data
        $validated = $request->validate([
            'sparepart_id' => 'required|exists:spareparts,id',
            'invoice_id' => 'nullable|string|max:255',
            'qty' => 'required|integer|min:1',
        ]);

        $distributor = Auth::guard('distributor')->user();

        // Create the sparepart request
        SparepartRequest::create([
            'distributor_id' => $distributor->id,
            'sparepart_id' => $validated['sparepart_id'],
            'invoice_id' => $validated['invoice_id'],
            'qty' => $validated['qty'],
            // 'status' defaults to 'Submitted'
        ]);

        return redirect()->route('sparepart-requests.index')->with('success', 'Sparepart request submitted successfully.');
    }

    /**
     * Display the specified sparepart request.
     *
     * @param  \App\Models\SparepartRequest  $sparepartRequest
     * @return \Illuminate\Http\Response
     */
    public function show(SparepartRequest $sparepartRequest)
    {
        // Check if the user is authorized to view this request
        if (Auth::guard('distributor')->check()) {
            $distributor = Auth::guard('distributor')->user();
            if ($sparepartRequest->distributor_id !== $distributor->id) {
                return redirect()->route('sparepart-requests.index')->with('error', 'Access denied.');
            }
        }

        // Load relationships
        $sparepartRequest->load(['sparepart', 'distributor']);

        return view('sparepart_requests.show', compact('sparepartRequest'));
    }

    /**
     * Remove the specified sparepart request from storage (Distributor only).
     *
     * @param  \App\Models\SparepartRequest  $sparepartRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(SparepartRequest $sparepartRequest)
    {
        // Ensure the user is a Distributor and owns the request
        if (Auth::guard('distributor')->check()) {
            $distributor = Auth::guard('distributor')->user();
            if ($sparepartRequest->distributor_id !== $distributor->id) {
                return redirect()->route('sparepart-requests.index')->with('error', 'Access denied.');
            }

            $sparepartRequest->delete();

            return redirect()->route('sparepart-requests.index')->with('success', 'Sparepart request deleted successfully.');
        }

        // If not a Distributor, deny access
        return redirect()->route('sparepart-requests.index')->with('error', 'Access denied.');
    }

    // Optional: Implement edit and update methods if editing is allowed
}
