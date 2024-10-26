<!DOCTYPE html>
<html>
<head>
    <title>Supervisor Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- CSRF Token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Include CSS styles directly for testing -->
    <style>
        /* Status Text Styles */
        .status-text {
            font-weight: bold;
        }

        /* Submitted - Gray */
        .status-text-submitted {
            color: gray;
        }

        /* Confirmed - Green */
        .status-text-confirmed {
            color: green;
        }

        /* Pending - Orange */
        .status-text-pending {
            color: orange;
        }

        /* Rejected - Red */
        .status-text-rejected {
            color: red;
        }

        /* On Progress - Blue */
        .status-text-on-progress {
            color: blue;
        }

        /* Ready - Purple */
        .status-text-ready {
            color: purple;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>Welcome, Supervisor</h2>
    <p>This is your dashboard.</p>
    <!-- Logout Button -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>

    <!-- Sparepart Requests Table -->
    <h3 class="mt-4">All Sparepart Requests</h3>
    @if($sparepartRequests->isEmpty())
        <p>No sparepart requests found.</p>
    @else
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Distributor</th>
                    <th>Sparepart</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Request Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sparepartRequests as $request)
                    @php
                        // Clean and standardize the status value
                        $status = strtolower(trim($request->status));
                        $statusClass = 'status-text-' . str_replace(' ', '-', $status);
                    @endphp
                    <tr>
                        <td>{{ $request->id }}</td>
                        <td>{{ $request->distributor->name }}</td>
                        <td>{{ $request->sparepart->name }}</td>
                        <td>{{ $request->qty }}</td>
                        <td class="status-text {{ $statusClass }}">{{ $request->status }}</td>
                        <td>{{ $request->request_date }}</td>
                        <td>
                            <!-- Accept Button -->
                            @if($status != 'confirmed')
                                <button type="button" class="btn btn-success btn-sm action-button" data-action="Confirmed" data-id="{{ $request->id }}">Accept</button>
                            @endif
                            <!-- Pending Button -->
                            @if($status != 'pending')
                                <button type="button" class="btn btn-warning btn-sm action-button" data-action="Pending" data-id="{{ $request->id }}">Pending</button>
                            @endif
                            <!-- Reject Button -->
                            @if($status != 'rejected')
                                <button type="button" class="btn btn-danger btn-sm action-button" data-action="Rejected" data-id="{{ $request->id }}">Reject</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<!-- SweetAlert2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Add event listeners to all action buttons
    document.querySelectorAll('.action-button').forEach(button => {
        button.addEventListener('click', function() {
            const action = this.getAttribute('data-action');
            const requestId = this.getAttribute('data-id');

            // Confirmation dialog using SweetAlert2
            Swal.fire({
                title: `Are you sure you want to ${action.toLowerCase()} this request?`,
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, ${action.toLowerCase()} it!`
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to update the status
                    fetch('{{ route('supervisor.update-status') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ id: requestId, status: action })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Success alert
                            Swal.fire(
                                'Updated!',
                                'The request status has been updated.',
                                'success'
                            ).then(() => {
                                // Reload the page to reflect changes
                                location.reload();
                            });
                        } else {
                            // Error alert
                            Swal.fire(
                                'Error!',
                                'There was an error updating the request status.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
</body>
</html>
