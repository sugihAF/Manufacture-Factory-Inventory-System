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
        <h3 class="mt-4">Your Machines</h3>
        <table class="table table-striped mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Machine ID</th>
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
                                <span class="text-muted">In Maintenance</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
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
    });
</script>
</body>
</html>