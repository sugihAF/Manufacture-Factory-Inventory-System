<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\SparepartRequest;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['distributor', 'sparepartRequest'])->get();
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $sparepartRequests = SparepartRequest::where('status', 'Submitted')->get();
        return view('invoices.create', compact('sparepartRequests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'request_id' => 'required|exists:sparepart_requests,id',
        ]);

        $sparepartRequest = SparepartRequest::findOrFail($request->request_id);
        $distributor = $sparepartRequest->distributor;

        $invoice = Invoice::create([
            'distributor_id' => $distributor->id,
            'request_id' => $sparepartRequest->id,
        ]);

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function show($id)
    {
        $invoice = Invoice::with(['distributor', 'sparepartRequest'])->findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }

    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('invoices.edit', compact('invoice'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Paid,Failed',
            'payment_date' => 'nullable|date',
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->status = $request->status;
        $invoice->payment_date = $request->payment_date;
        $invoice->save();

        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}