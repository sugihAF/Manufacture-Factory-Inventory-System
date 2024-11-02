<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #555; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; }
        .heading { background: #f5f5f5; padding: 10px; }
        table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; }
        table td { padding: 5px; vertical-align: top; }
        table tr.heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; }
        table tr.item td { border-bottom: 1px solid #eee; }
        .total { font-size: 1.2em; font-weight: bold; }
        /* Add more styles as needed */
    </style>
</head>
<body>
    <div class="invoice-box">
        <h1>Invoice</h1>
        <table>
            <tr>
                <td>
                    <strong>Invoice ID:</strong> {{ $invoice->id }}<br>
                    <strong>Invoice Date:</strong> {{ $invoice->invoice_date->format('Y-m-d') }}<br>
                    <strong>Due Date:</strong> {{ $invoice->due_date->format('Y-m-d') }}<br>
                    <strong>Status:</strong> {{ $invoice->status }}
                </td>
                <td style="text-align: right;">
                    <strong>Distributor:</strong><br>
                    {{ $invoice->distributor->name }}<br>
                    {{ $invoice->distributor->address }}<br>
                    {{ $invoice->distributor->contact_info }}
                </td>
            </tr>
        </table>
        <br><br>
        <table>
            <tr class="heading">
                <td>Spare Part</td>
                <td>Quantity</td>
                <td>Unit Price</td>
                <td>Total</td>
            </tr>
            <tr class="item">
                <td>{{ $invoice->sparepartRequest->sparepart->name }}</td>
                <td>{{ $invoice->sparepartRequest->qty }}</td>
                <td>{{ formatRupiah($invoice->sparepartRequest->sparepart->price) }}</td>
                <td>{{ formatRupiah($invoice->total_amount) }}</td>
            </tr>
            <tr>
                <td colspan="3" class="total">Total Amount:</td>
                <td class="total">{{ formatRupiah($invoice->total_amount) }}</td>
            </tr>
        </table>
        <br>
        <p>Thank you for your business!</p>
    </div>
</body>
</html>
