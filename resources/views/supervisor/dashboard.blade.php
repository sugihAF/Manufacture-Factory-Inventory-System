<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .sidebar {
            transition: transform 0.3s;
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

        /* Hover style for sidebar menu */
        .sidebar a:hover {
            background-color: #4a5568;
            border-radius: 0.25rem;
            color : rgba(0,185,185,255)
        }

        .action-column {
        width: 1%;
        white-space: nowrap;
        }

        .action-button {
        padding: 0.25rem 0.5rem;
        }

            /* Table header background */
        .table-header {
            background-color: #0D475D; /* Dark gray (or choose any preferred color) */
            color: white; /* White text for readability */
        }

        /* Table body background */
        .table-body {
            background-color: #f7fafc; /* Light gray  */
            color: #2d3748; /* Dark text for readability */
        }

    </style>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('table').DataTable({
            "paging": true,
            "pageLength": 10,
            "columnDefs": [
                { "width": "10%", "targets": -1 } // Sets the last column (Action column) to 10% width
            ],
            "autoWidth": false // Disables automatic column width calculation
        });
    });
</script>


</head>

<body class="font-sans bg-gray-100 text-gray-800">

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar inactive fixed top-0 left-0 w-64 h-full bg-gray-900 text-white p-4 overflow-y-auto shadow-md">
        <a href="#" class="block mb-3 text-xl font-bold" onclick="toggleSidebar()">✕ Close</a>
        <a href="#newRequests" onclick="showSection(event, 'newRequests')" class="block p-3 mb-2 hover:bg-gray-700 rounded">New Sparepart Requests</a>
        <a href="#ongoingRequests" onclick="showSection(event, 'ongoingRequests')" class="block p-3 mb-2 hover:bg-gray-700 rounded">Ongoing Sparepart Requests</a>
        <a href="#historyRequests" onclick="showSection(event, 'historyRequests')" class="block p-3 mb-2 hover:bg-gray-700 rounded">History of Sparepart Requests</a>
        <a href="#workloads" onclick="showSection(event, 'workloads')" class="block p-3 mb-2 hover:bg-gray-700 rounded">Factory Workloads</a>
    </div>

    <!-- Header -->
    <nav class="bg-gray-900 text-white p-4 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <button class="bg-gray-800 p-2 rounded-md hover:bg-gray-700" onclick="toggleSidebar()">Menu ☰</button>
            <img src="{{ asset('frontend/assets/images/auth-login-dark.png') }}" alt="Company Logo" class="h-8">
        </div>
        <div class="flex items-center space-x-4">
            <span>Supervisor: <strong>supervisor@example.com</strong></span>
            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                @csrf
                <button type="button" onclick="confirmLogout()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Logout</button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <div id="mainContent" class="p-6 mt-6 transition-all">
        <!-- New Sparepart Requests Section -->
        <section id="newRequests" class="mt-6">
            <h3 class="text-2xl font-semibold mb-4">New Sparepart Requests</h3>
            @if($newRequests->isEmpty())
                <p class="text-gray-500">No new sparepart requests found.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                        <thead class="table-header">
                            <tr>
                                <th class="py-3 px-4 text-center">ID</th>
                                <th class="py-3 px-4 text-center">Distributor</th>
                                <th class="py-3 px-4 text-center">Sparepart</th>
                                <th class="py-3 px-4 text-center">Quantity</th>
                                <th class="py-3 px-4 text-center">Status</th>
                                <th class="py-3 px-4 text-center">Request Date</th>
                                <th class="py-3 px-4 text-center action-column">Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            @foreach($newRequests as $request)
                                @php
                                    $status = strtolower(trim($request->status));
                                    $statusClass = 'status-text-' . str_replace(' ', '-', $status);
                                @endphp
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="py-2 px-4 text-center">{{ $request->id }}</td>
                                    <td class="py-2 px-4 text-center">{{ $request->distributor->name }}</td>
                                    <td class="py-2 px-4 text-center">{{ $request->sparepart->name }}</td>
                                    <td class="py-2 px-4 text-center">{{ $request->qty }}</td>
                                    <td class="py-2 px-4 text-center font-bold {{ $statusClass }}">{{ $request->status }}</td>
                                    <td class="py-2 px-4 text-center">{{ $request->request_date }}</td>
                                    <td class="py-2 px-4 text-center">
                                        <div class="flex justify-center space-x-1">
                                            @if($status != 'confirmed')
                                                <button class="bg-green-500 hover:bg-green-700 text-white py-1 px-2 rounded action-button" data-action="Confirmed" data-id="{{ $request->id }}">Accept</button>
                                            @endif
                                            @if($status != 'pending')
                                                <button class="bg-yellow-500 hover:bg-yellow-700 text-white py-1 px-2 rounded action-button" data-action="Pending" data-id="{{ $request->id }}">Pending</button>
                                            @endif
                                            @if($status != 'rejected')
                                                <button class="bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded action-button" data-action="Rejected" data-id="{{ $request->id }}">Reject</button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

        <!-- Ongoing Sparepart Requests Section -->
        <section id="ongoingRequests" class="mt-6" style="display: none;">
            <h3 class="text-2xl font-semibold mb-4">Ongoing Sparepart Requests</h3>
            @if($ongoingRequests->isEmpty())
                <p class="text-gray-500">No ongoing sparepart requests found.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                        <thead class="table-header">
                            <tr>
                                <th class="py-3 px-4 text-center">ID</th>
                                <th class="py-3 px-4 text-center">Distributor</th>
                                <th class="py-3 px-4 text-center">Sparepart</th>
                                <th class="py-3 px-4 text-center">Quantity</th>
                                <th class="py-3 px-4 text-center">Status</th>
                                <th class="py-3 px-4 text-center">Request Date</th>
                                <th class="py-3 px-4 text-center action-column">Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            @foreach($ongoingRequests as $request)
                                @php
                                    $status = strtolower(trim($request->status));
                                    $statusClass = 'status-text-' . str_replace(' ', '-', $status);
                                @endphp
                                <tr class="hover:bg-gray-100">
                                    <td class="py-2 px-3 text-center border border-gray-150">{{ $request->id }}</td>
                                    <td class="py-2 px-3 text-center border border-gray-150">{{ $request->distributor->name }}</td>
                                    <td class="py-2 px-3 text-center border border-gray-150">{{ $request->sparepart->name }}</td>
                                    <td class="py-2 px-3 text-center border border-gray-150">{{ $request->qty }}</td>
                                    <td class="py-2 px-3 text-center font-bold border border-gray-150 {{ $statusClass }}">{{ $request->status }}</td>
                                    <td class="py-2 px-3 text-center border border-gray-150">{{ $request->request_date }}</td>
                                    <td class="py-2 px-3 text-center border border-gray-150">
                                        <div class="flex justify-center space-x-1">
                                            @if($status != 'confirmed')
                                                <button class="bg-green-500 hover:bg-green-700 text-white py-1 px-2 rounded action-button" data-action="Confirmed" data-id="{{ $request->id }}">Accept</button>
                                            @endif
                                            @if($status != 'pending')
                                                <button class="bg-yellow-500 hover:bg-yellow-700 text-white py-1 px-2 rounded action-button" data-action="Pending" data-id="{{ $request->id }}">Pending</button>
                                            @endif
                                            @if($status != 'rejected')
                                                <button class="bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded action-button" data-action="Rejected" data-id="{{ $request->id }}">Reject</button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>


        <!-- History of Sparepart Requests Section -->
    <section id="historyRequests" class="mt-6" style="display: none;">
        <h3 class="text-2xl font-semibold mb-4">History of Sparepart Requests</h3>
        @if($historyRequests->isEmpty())
            <p class="text-gray-500">No history of sparepart requests found.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                    <thead class="table-header">
                        <tr>
                            <th class="py-3 px-4 text-center">ID</th>
                            <th class="py-3 px-4 text-center">Distributor</th>
                            <th class="py-3 px-4 text-center">Sparepart</th>
                            <th class="py-3 px-4 text-center">Quantity</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-center">Request Date</th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
                        @foreach($historyRequests as $request)
                            @php
                                $status = strtolower(trim($request->status));
                                $statusClass = 'status-text-' . str_replace(' ', '-', $status);
                            @endphp
                            <tr class="border-b hover:bg-gray-100">
                                <td class="py-2 px-4 text-center">{{ $request->id }}</td>
                                <td class="py-2 px-4 text-center">{{ $request->distributor->name }}</td>
                                <td class="py-2 px-4 text-center">{{ $request->sparepart->name }}</td>
                                <td class="py-2 px-4 text-center">{{ $request->qty }}</td>
                                <td class="py-2 px-4 text-center font-bold {{ $statusClass }}">{{ $request->status }}</td>
                                <td class="py-2 px-4 text-center">{{ $request->request_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
        
        <!-- Workloads Section -->
    <section id="workloads" class="mt-6" style="display: none;">
        <h3 class="text-2xl font-semibold mb-4">Factory Workloads</h3>
        @if($workloads->isEmpty())
            <p class="text-gray-500">No workloads found.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                    <thead class="table-header">
                        <tr>
                            <th class="py-3 px-4 text-center">ID</th>
                            <th class="py-3 px-4 text-center">Request ID</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-center">Start Date</th>
                            <th class="py-3 px-4 text-center">Completion Date</th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
                        @foreach($workloads as $workload)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="py-2 px-4 text-center">{{ $workload->id }}</td>
                                <td class="py-2 px-4 text-center">{{ $workload->request_id }}</td>
                                <td class="py-2 px-4 text-center">{{ $workload->status }}</td>
                                <td class="py-2 px-4 text-center">{{ $workload->start_date }}</td>
                                <td class="py-2 px-4 text-center">{{ $workload->completion_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>

    </div>

    <!-- Footer -->
    <footer class="footer bg-gray-900 text-white text-center py-4">
        <p>&copy; 2024 PT. My Spare Parts. <br> All Rights Reserved. </p>
    </footer>

    <!-- JavaScript -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            sidebar.classList.toggle('active');
            sidebar.classList.toggle('inactive');

            if (sidebar.classList.contains('active')) {
                mainContent.classList.add('shifted');
            } else {
                mainContent.classList.remove('shifted');
            }
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

        document.querySelectorAll('.action-button').forEach(button => {
            button.addEventListener('click', function () {
                const action = this.getAttribute('data-action');
                const requestId = this.getAttribute('data-id');
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
                        fetch('{{ route('supervisor.update-status') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ id: requestId, status: action })
                        }).then(response => response.json()).then(data => {
                            if (data.success) {
                                Swal.fire('Updated!', 'The request status has been updated.', 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error!', 'There was an error updating the request status.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>
