<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta and Title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factory Dashboard</title>

    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap CSS (for modal) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        .sidebar {
            transition: transform 0.3s;
        }

        .sidebar a:hover {
            background-color: #4a5568 !important;
            border-radius: 0.25rem;
            color: rgba(0, 185, 185, 1) !important;
        }

        .sidebar.active {
            transform: translateX(0%);
        }

        .sidebar.inactive {
            transform: translateX(-100%);
        }

        .shifted {
            margin-left: 16rem;
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            text-align: center;
            padding: 5px 0;
            z-index: 1000;
        }

        body {
            margin: 0;
            padding-bottom: 50px;
            box-sizing: border-box;
        }

        .table-header {
            background-color: #0D475D;
            color: white;
        }

        .action-button-accept {
            background-color: #38A169;
            color: white;
        }

        .action-button-pending {
            background-color: #DD6B20;
            color: white;
        }

        .action-button-reject {
            background-color: #E53E3E;
            color: white;
        }

        .action-button {
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            font-weight: bold;
            margin-right: 0.25rem;
        }
    </style>
</head>

<body class="font-sans bg-gray-100 text-gray-800">

<!-- Sidebar -->
<div id="sidebar" class="sidebar inactive fixed top-0 left-0 w-64 h-full bg-gray-900 text-white p-4 overflow-y-auto shadow-md">
    <a href="#" class="block mb-3 text-xl font-bold text-white no-underline" onclick="toggleSidebar()">✕ Close</a>
    <a href="#machines" onclick="showSection(event, 'machines')" class="block p-3 mb-2 rounded text-white no-underline">Your Machines</a>
    <a href="#workloads" onclick="showSection(event, 'workloads')" class="block p-3 mb-2 rounded text-white no-underline">Your Workloads</a>
</div>

    <!-- Header -->
    <nav class="bg-gray-900 text-white p-4 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <button class="bg-gray-800 p-2 rounded-md hover:bg-gray-700" onclick="toggleSidebar()">Menu ☰</button>
            <img src="{{ asset('frontend/assets/images/auth-login-dark.png') }}" alt="Company Logo" class="h-8">
        </div>
        <div class="flex items-center space-x-4">
            <span>Factory: <strong>{{ Auth::user()->email }}</strong></span>
            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                @csrf
                <button type="button" onclick="confirmLogout()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Logout</button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <div id="mainContent" class="p-6 mt-6 transition-all">

        <!-- Machines Section -->
        <section id="machines" class="mt-6">
            <h2 class="text-2xl font-semibold mb-4">Your Machines</h2>
            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4" id="success-alert">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4" id="error-alert">
                    {{ session('error') }}
                </div>
            @endif
            @if($factory->machines->isEmpty())
                <p class="text-gray-500">You have no machines assigned.</p>
            @else
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md mb-6 display" id="machinesTable">
                    <thead class="table-header">
                        <tr>
                            <th class="py-3 px-4 text-center">ID</th>
                            <th class="py-3 px-4 text-center">Name</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($factory->machines as $machine)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="py-2 px-4 text-center">{{ $machine->id }}</td>
                                <td class="py-2 px-4 text-center">{{ $machine->name }}</td>
                                <td class="py-2 px-4 text-center">{{ $machine->status }}</td>
                                <td class="py-2 px-4 text-center">
                                    @if($machine->status !== 'Maintenance' && $machine->status !== 'Busy')
                                        <form action="{{ route('factory.machine.maintenance', $machine->id) }}" method="POST" class="inline maintenance-form">
                                            @csrf
                                            <button type="submit" class="action-button action-button-pending">Maintenance</button>
                                        </form>
                                    @elseif($machine->status === 'Maintenance')
                                        <form action="{{ route('factory.machine.available', $machine->id) }}" method="POST" class="inline available-form">
                                            @csrf
                                            <button type="submit" class="action-button action-button-accept">Available</button>
                                        </form>
                                    @else
                                        <span class="text-gray-500">In Use</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </section>

        <!-- Workloads Section -->
        <section id="workloads" class="mt-6" style="display: none;">
            <h2 class="text-2xl font-semibold mb-4">Your Workloads</h2>
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md display" id="workloadsTable">
                <thead class="table-header">
                    <tr>
                        <th class="py-3 px-4 text-center">ID</th>
                        <th class="py-3 px-4 text-center">Request ID</th>
                        <th class="py-3 px-4 text-center">Machine ID</th>
                        <th class="py-3 px-4 text-center">Start Date</th>
                        <th class="py-3 px-4 text-center">Completion Date</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Supervisor Approval</th>
                        <th class="py-3 px-4 text-center">Created At</th>
                        <th class="py-3 px-4 text-center">Updated At</th>
                        <th class="py-3 px-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($workloads->isEmpty())
                        <tr>
                            <td colspan="10" class="text-center py-4">No workloads available.</td>
                        </tr>
                    @else
                        @foreach($workloads as $workload)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="py-2 px-4 text-center">{{ $workload->id }}</td>
                                <td class="py-2 px-4 text-center">{{ $workload->request_id }}</td>
                                <td class="py-2 px-4 text-center">{{ $workload->machine_id ?? 'N/A' }}</td>
                                <td class="py-2 px-4 text-center">{{ $workload->start_date ? $workload->start_date->format('Y-m-d H:i') : 'N/A' }}</td>
                                <td class="py-2 px-4 text-center">{{ $workload->completion_date ? $workload->completion_date->format('Y-m-d H:i') : 'N/A' }}</td>
                                <td class="py-2 px-4 text-center">{{ $workload->status }}</td>
                                <td class="py-2 px-4 text-center">{{ $workload->supervisor_approval }}</td>
                                <td class="py-2 px-4 text-center">{{ $workload->created_at->format('Y-m-d H:i') }}</td>
                                <td class="py-2 px-4 text-center">{{ $workload->updated_at->format('Y-m-d H:i') }}</td>
                                <td class="py-2 px-4 text-center">
                                    @if($workload->status === 'Working')
                                    <!-- Show Submit button -->
                                    <form action="{{ route('factory.workload.submit', $workload->id) }}" method="POST" class="inline submit-form">
                                        @csrf
                                        <button type="button" class="btn btn-primary btn-sm submit-button">Submit</button>
                                    </form>
                                    @elseif($workload->status === 'Submitted')
                                        <!-- Display 'Workload Submitted' text -->
                                        <span class="text-blue-500 font-semibold">Workload Submitted</span>
                                    @elseif($workload->status === 'Done')
                                        <!-- Display 'Workload Done' text -->
                                        <span class="text-green-500 font-semibold">Workload Done</span>
                                    @elseif($workload->status !== 'Completed')
                                        <!-- Show Accept button -->
                                        <button type="button" class="btn btn-primary btn-sm accept-button" data-bs-toggle="modal" data-bs-target="#acceptModal" data-workload-id="{{ $workload->id }}">
                                            Accept
                                        </button>
                                    @else
                                        <span class="text-gray-500">N/A</span>
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
                                @if($availableMachines->isEmpty())
                                    <p class="text-danger">No available machines to assign.</p>
                                @else
                                    <div class="mb-3">
                                        <label for="machineSelect" class="form-label">Select Machine</label>
                                        <select class="form-select" id="machineSelect" name="machine_id" required>
                                            <option value="" selected disabled>Choose a machine</option>
                                            @foreach($availableMachines as $machine)
                                                <option value="{{ $machine->id }}">{{ $machine->name }} (ID: {{ $machine->id }})</option>
                                            @endforeach
                                        </select>
                                    </div>
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

        </section>
    </div>

    <!-- Footer -->
    <footer class="footer bg-gray-900 text-white text-center py-4">
        <p>&copy; 2024 PT. My Spare Parts. <br> All Rights Reserved. </p>
    </footer>

    <!-- JavaScript -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    
    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    
    <!-- Bootstrap JS (for modal) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            sidebar.classList.toggle('active');
            sidebar.classList.toggle('inactive');
            mainContent.classList.toggle('shifted');
        }

        function showSection(event, sectionId) {
            event.preventDefault();
            document.querySelectorAll('section').forEach(section => section.style.display = 'none');
            document.getElementById(sectionId).style.display = 'block';
            toggleSidebar();
        }

        function confirmLogout() {
            Swal.fire({
                title: 'Are you sure you want to logout?',
                text: "You can cancel if you change your mind.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, logout'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        }

        $(document).ready(function() {
            $('#machinesTable, #workloadsTable').DataTable({
                "paging": true,
                "pageLength": 10,
                "autoWidth": false
            });
        });

        // Accept Modal JavaScript
        var acceptModal = document.getElementById('acceptModal');
        acceptModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var workloadId = button.getAttribute('data-workload-id');
            var form = acceptModal.querySelector('#acceptWorkloadForm');
            form.action = `{{ url('/factory/workload') }}/${workloadId}/accept`;
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.submit-button').forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('.submit-form');
                    Swal.fire({
                        title: 'Confirm Submission',
                        text: "Are you sure you want to submit this workload?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, submit it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>
