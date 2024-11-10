<!DOCTYPE html>
<html>
<head>
    <title>Factory Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        /* Optional: Customize the appearance of alerts */
        .alert {
            position: relative;
            transition: opacity 0.5s ease-out;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>Welcome, {{ $factory->name }}</h2>
    <p>This is your dashboard.</p>

    <!-- Logout Form -->
    <form method="POST" action="{{ route('logout') }}" class="mt-3">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>

    <!-- Display Success or Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert" id="success-alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert" id="error-alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Machines Table -->
    @if($factory->machines->isEmpty())
        <p class="mt-4">You have no machines assigned.</p>
    @else
    <h3 class="mt-5">Your Machines</h3>
    <table class="table table-striped table-hover mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Action</th> <!-- Action column -->
            </tr>
        </thead>
        <tbody>
            @foreach($factory->machines as $machine)
                <tr>
                    <td>{{ $machine->id }}</td>
                    <td>{{ $machine->name }}</td>
                    <td>{{ $machine->status }}</td>
                    <td>
                        @if($machine->status !== 'Maintenance')
                            <form action="{{ route('factory.machine.maintenance', $machine->id) }}" method="POST" class="d-inline maintenance-form">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm">Maintenance</button>
                            </form>
                        @else
                            <form action="{{ route('factory.machine.available', $machine->id) }}" method="POST" class="d-inline available-form">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Available</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Workloads Table -->
    <h3 class="mt-5">Your Workloads</h3>
    <table class="table table-striped table-hover mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Request ID</th>
                <th>Machine ID</th>
                <th>Start Date</th>
                <th>Completion Date</th>
                <th>Status</th>
                <th>Supervisor Approval</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th> <!-- New Action Column -->
            </tr>
        </thead>
        <tbody>
            @if($workloads->isEmpty())
                <tr>
                    <td colspan="10" class="text-center">No workloads available.</td>
                </tr>
            @else
                @foreach($workloads as $workload)
                    <tr>
                        <td>{{ $workload->id }}</td>
                        <td>{{ $workload->request_id }}</td>
                        <td>{{ $workload->machine_id ?? 'N/A' }}</td>
                        <td>{{ $workload->start_date ? $workload->start_date->format('Y-m-d H:i') : 'N/A' }}</td>
                        <td>{{ $workload->completion_date ? $workload->completion_date->format('Y-m-d H:i') : 'N/A' }}</td>
                        <td>{{ $workload->status }}</td>
                        <td>{{ $workload->supervisor_approval }}</td>
                        <td>{{ $workload->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $workload->updated_at->format('Y-m-d H:i') }}</td>
                        <td>
                            @if($workload->status !== 'Working' && $workload->status !== 'Completed')
                                <button type="button" class="btn btn-primary btn-sm accept-button" data-bs-toggle="modal" data-bs-target="#acceptModal" data-workload-id="{{ $workload->id }}">
                                    Accept
                                </button>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <!-- Accept Workload Modal -->
    <div class="modal fade" id="acceptModal" tabindex="-1" aria-labelledby="acceptModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="" id="acceptWorkloadForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="acceptModalLabel">Accept Workload</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="machineSelect" class="form-label">Select Machine</label>
                            <select class="form-select" id="machineSelect" name="machine_id" required>
                                <option value="" selected disabled>Choose a machine</option>
                                @foreach($availableMachines as $machine)
                                    <option value="{{ $machine->id }}">{{ $machine->name }} (ID: {{ $machine->id }})</option>
                                @endforeach
                            </select>
                        </div>
                        @if($availableMachines->isEmpty())
                            <p class="text-danger">No available machines to assign.</p>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        @if(!$availableMachines->isEmpty())
                            <button type="submit" class="btn btn-primary">Assign Machine</button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- Bootstrap JS Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- SweetAlert Confirmation and Auto-hide Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle Maintenance Button Click with SweetAlert Confirmation
        const maintenanceForms = document.querySelectorAll('.maintenance-form');
        maintenanceForms.forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent the form from submitting immediately

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to set this machine to Maintenance?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, set it!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit the form if confirmed
                    }
                });
            });
        });

        // Auto-hide Success Alert after 5 Seconds
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(function() {
                // Use Bootstrap's alert close method
                const alert = new bootstrap.Alert(successAlert);
                alert.close();
            }, 5000); // 5000 milliseconds = 5 seconds
        }

        // Auto-hide Error Alert after 5 Seconds
        const errorAlert = document.getElementById('error-alert');
        if (errorAlert) {
            setTimeout(function() {
                // Use Bootstrap's alert close method
                const alert = new bootstrap.Alert(errorAlert);
                alert.close();
            }, 5000); // 5000 milliseconds = 5 seconds
        }

        // Handle Accept Button Click to Populate Modal
        const acceptButtons = document.querySelectorAll('.accept-button');
        acceptButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const workloadId = this.getAttribute('data-workload-id');
                // Update the form action URL with the workload ID
                const form = document.getElementById('acceptWorkloadForm');
                form.action = `{{ url('/factory/workload') }}/${workloadId}/accept`;
            });
        });
    });
</script>
</body>
</html>