<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SparepartRequest;
use App\Models\Invoice;
use Carbon\Carbon;
use App\Models\Workload;
use Illuminate\Support\Facades\Validator;
use App\Models\Factory;

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

            $workloads = Workload::with('sparepartRequest')->get();

            $factories = Factory::all();

            return view('supervisor.dashboard', compact('newRequests', 'ongoingRequests', 'historyRequests', 'workloads', 'factories'));
    }

    /**
     * Update the status of a sparepart request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:sparepart_requests,id',
            'status' => 'required|in:Confirm,Reject,Pending',
            'note' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        // Retrieve the sparepart_request
        $sparepartRequest = SparepartRequest::find($request->id);
        
        // Update status
        switch ($request->status) {
            case 'Confirm':
                $sparepartRequest->status = 'Confirmed';
                // Create an invoice if the status is 'Confirmed'
                Invoice::create([
                    'distributor_id' => $sparepartRequest->distributor_id,
                    'request_id' => $sparepartRequest->id,
                    'total_amount' => $sparepartRequest->qty * $sparepartRequest->sparepart->price,
                    'invoice_date' => Carbon::now(),
                    'due_date' => Carbon::now()->addWeek(),
                ]);
                break;
            case 'Pending':
                $sparepartRequest->status = 'Pending';
                break;
            case 'Reject':
                $sparepartRequest->status = 'Rejected';
                break;
            default:
                return response()->json(['success' => false, 'message' => 'Invalid status.'], 400);
        }

        // Ensure note is empty before adding new note
        if (in_array($request->status, ['Reject', 'Pending']) && $request->note) {
            $sparepartRequest->note = trim($request->note);
        }

        // Save changes
        $sparepartRequest->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
    }

    /**
     * Fetch machines based on the selected factory.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMachines($factoryId)
    {
        $factory = Factory::with('machines')->find($factoryId);

        if (!$factory) {
            return response()->json(['machines' => []]);
        }

        return response()->json([
            'machines' => $factory->machines->map(function($machine) {
                return [
                    'id' => $machine->id,
                    'name' => $machine->name,
                    'status' => $machine->status,
                ];
            }),
        ]);
    }
}