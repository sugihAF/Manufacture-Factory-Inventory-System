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
            transform: translateX(0);
        }

        .sidebar.inactive {
            transform: translateX(-100%);
        }

        .shifted {
            margin-left: 16rem;
        }
    </style>

    <style>
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #f1f1f1;
            text-align: center;
            padding: 10px 0;
            z-index: 1000;
        }
        body {
            margin: 0;
            padding-bottom: 50px; /* Adjusted to ensure content doesn't overlap footer */
            box-sizing: border-box;
        }
    </style>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('table').DataTable({
                "paging": true,
                "pageLength": 10
            });
        });
    </script>

</head>

<body class="font-sans bg-gray-100 text-gray-800">

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar inactive fixed top-0 left-0 w-64 h-full bg-gray-800 text-white p-4 overflow-y-auto shadow-md">
        <a href="#" class="block mb-3 text-xl font-bold" onclick="toggleSidebar()">✕ Close</a>
        <a href="#newRequests" onclick="showSection(event, 'newRequests')" class="block p-3 mb-2 hover:bg-gray-700 rounded">New Sparepart Requests</a>
        <a href="#ongoingRequests" onclick="showSection(event, 'ongoingRequests')" class="block p-3 mb-2 hover:bg-gray-700 rounded">Ongoing Sparepart Requests</a>
        <a href="#historyRequests" onclick="showSection(event, 'historyRequests')" class="block p-3 mb-2 hover:bg-gray-700 rounded">History of Sparepart Requests</a>
    </div>

    <!-- Header -->
    <nav class="bg-gray-900 text-white p-4 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <img src="{{ asset('frontend/assets/images/auth-login-dark.png') }}" alt="Company Logo" class="h-8">
            <button class="bg-gray-800 p-2 rounded-md hover:bg-gray-700" onclick="toggleSidebar()">☰</button>
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
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="py-3 px-4 text-left">ID</th>
                                <th class="py-3 px-4 text-left">Distributor</th>
                                <th class="py-3 px-4 text-left">Sparepart</th>
                                <th class="py-3 px-4 text-left">Quantity</th>
                                <th class="py-3 px-4 text-left">Status</th>
                                <th class="py-3 px-4 text-left">Request Date</th>
                                <th class="py-3 px-4 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($newRequests as $request)
                                @php
                                    $status = strtolower(trim($request->status));
                                    $statusClass = 'status-text-' . str_replace(' ', '-', $status);
                                @endphp
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="py-2 px-4">{{ $request->id }}</td>
                                    <td class="py-2 px-4">{{ $request->distributor->name }}</td>
                                    <td class="py-2 px-4">{{ $request->sparepart->name }}</td>
                                    <td class="py-2 px-4">{{ $request->qty }}</td>
                                    <td class="py-2 px-4 font-bold {{ $statusClass }}">{{ $request->status }}</td>
                                    <td class="py-2 px-4">{{ $request->request_date }}</td>
                                    <td class="py-2 px-4 flex space-x-2">
                                        @if($status != 'confirmed')
                                            <button class="bg-green-500 hover:bg-green-700 text-white py-1 px-2 rounded action-button" data-action="Confirmed" data-id="{{ $request->id }}">Accept</button>
                                        @endif
                                        @if($status != 'pending')
                                            <button class="bg-yellow-500 hover:bg-yellow-700 text-white py-1 px-2 rounded action-button" data-action="Pending" data-id="{{ $request->id }}">Pending</button>
                                        @endif
                                        @if($status != 'rejected')
                                            <button class="bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded action-button" data-action="Rejected" data-id="{{ $request->id }}">Reject</button>
                                        @endif
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
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="py-3 px-4 text-left">ID</th>
                                <th class="py-3 px-4 text-left">Distributor</th>
                                <th class="py-3 px-4 text-left">Sparepart</th>
                                <th class="py-3 px-4 text-left">Quantity</th>
                                <th class="py-3 px-4 text-left">Status</th>
                                <th class="py-3 px-4 text-left">Request Date</th>
                                <th class="py-3 px-4 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ongoingRequests as $request)
                                @php
                                    $status = strtolower(trim($request->status));
                                    $statusClass = 'status-text-' . str_replace(' ', '-', $status);
                                @endphp
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="py-2 px-4">{{ $request->id }}</td>
                                    <td class="py-2 px-4">{{ $request->distributor->name }}</td>
                                    <td class="py-2 px-4">{{ $request->sparepart->name }}</td>
                                    <td class="py-2 px-4">{{ $request->qty }}</td>
                                    <td class="py-2 px-4 font-bold {{ $statusClass }}">{{ $request->status }}</td>
                                    <td class="py-2 px-4">{{ $request->request_date }}</td>
                                    <td class="py-2 px-4 flex space-x-2">
                                        @if($status != 'confirmed')
                                            <button class="bg-green-500 hover:bg-green-700 text-white py-1 px-2 rounded action-button" data-action="Confirmed" data-id="{{ $request->id }}">Accept</button>
                                        @endif
                                        @if($status != 'pending')
                                            <button class="bg-yellow-500 hover:bg-yellow-700 text-white py-1 px-2 rounded action-button" data-action="Pending" data-id="{{ $request->id }}">Pending</button>
                                        @endif
                                        @if($status != 'rejected')
                                            <button class="bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded action-button" data-action="Rejected" data-id="{{ $request->id }}">Reject</button>
                                        @endif
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
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="py-3 px-4 text-left">ID</th>
                                <th class="py-3 px-4 text-left">Distributor</th>
                                <th class="py-3 px-4 text-left">Sparepart</th>
                                <th class="py-3 px-4 text-left">Quantity</th>
                                <th class="py-3 px-4 text-left">Status</th>
                                <th class="py-3 px-4 text-left">Request Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($historyRequests as $request)
                                @php
                                    $status = strtolower(trim($request->status));
                                    $statusClass = 'status-text-' . str_replace(' ', '-', $status);
                                @endphp
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="py-2 px-4">{{ $request->id }}</td>
                                    <td class="py-2 px-4">{{ $request->distributor->name }}</td>
                                    <td class="py-2 px-4">{{ $request->sparepart->name }}</td>
                                    <td class="py-2 px-4">{{ $request->qty }}</td>
                                    <td class="py-2 px-4 font-bold {{ $statusClass }}">{{ $request->status }}</td>
                                    <td class="py-2 px-4">{{ $request->request_date }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white text-center py-4 mt-10">
        <p>&copy; 2024 PT. My Spare Parts. <br> All Rights Reserved. </p>
    </footer>

    <!-- JavaScript -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
            sidebar.classList.toggle('inactive');
            document.getElementById('mainContent').classList.toggle('shifted');
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
