<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use Carbon\Carbon;
use App\Models\Workload;

class PaymentController extends Controller
{
    private $client;

    public function __construct()
    {
        $paypalConfig = config('paypal');

        $environment = new SandboxEnvironment($paypalConfig['client_id'], $paypalConfig['secret']);
        $this->client = new PayPalHttpClient($environment);
    }

    public function payWithPayPal($invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'reference_id' => $invoice->id,
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => number_format($invoice->total_amount, 0, '.', '')
                ]
            ]],
            'application_context' => [
                'return_url' => route('payment.status', $invoice->id),
                'cancel_url' => route('payment.status', $invoice->id)
            ]
        ];

        try {
            $response = $this->client->execute($request);

            foreach ($response->result->links as $link) {
                if ($link->rel === 'approve') {
                    return redirect()->away($link->href);
                }
            }

            return redirect()
                ->route('distributor.dashboard')
                ->with('error', 'Could not obtain approval URL.');
        } catch (\Exception $ex) {
            return redirect()
                ->route('distributor.dashboard')
                ->with('error', 'An error occurred while processing the payment.');
        }
    }

    public function getPaymentStatus(Request $request, $invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);

        if ($request->query('token')) {
            $orderId = $request->query('token');

            $captureRequest = new OrdersCaptureRequest($orderId);
            $captureRequest->prefer('return=representation');

            try {
                $response = $this->client->execute($captureRequest);

                if ($response->result->status === 'COMPLETED') {
                    $invoice->status = 'Paid';
                    $invoice->payment_date = Carbon::now()->setTimezone('Asia/Jakarta');
                    $invoice->save();
                
                    // Retrieve the associated SparepartRequest
                    $sparepartRequest = $invoice->sparepartRequest;
                
                    if ($sparepartRequest) {
                        // Create new Workload record
                        Workload::create([
                            'request_id' => $sparepartRequest->id,
                            'factory_id' => 1, // Default factory ID
                            // Other nullable columns remain null for now
                        ]);
                
                        // Update the SparepartRequest status to 'On Progress'
                        $sparepartRequest->status = 'On Progress';
                        $sparepartRequest->save();
                    }
                
                    return redirect()
                        ->route('distributor.dashboard')
                        ->with('success', 'Payment completed successfully.');
                }

                return redirect()
                    ->route('distributor.dashboard')
                    ->with('error', 'Payment was not successful.');
            } catch (\Exception $ex) {
                return redirect()
                    ->route('distributor.dashboard')
                    ->with('error', 'An error occurred while processing the payment.');
            }
        }

        return redirect()
            ->route('distributor.dashboard')
            ->with('error', 'Payment was cancelled.');
    }
}