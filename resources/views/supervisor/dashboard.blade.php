<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* Custom styles for the sidebar and content layout */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }
        .sidebar {
            width: 250px;
            position: fixed;
            top: 0;
            left: -250px;
            height: 100%;
            background-color: #343a40;
            color: white;
            transition: 0.3s;
            overflow-y: auto;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 15px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .sidebar.active {
            left: 0;
        }
        .content {
            margin-left: 0;
            transition: 0.3s;
            padding: 20px;
            text-align: center;
        }
        .content.shifted {
            margin-left: 250px;
        }
        .navbar {
            background-color: #007bff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .navbar .navbar-brand, .navbar .nav-link {
            color: #fff;
            transition: color 0.3s;
        }
        .navbar .nav-link:hover {
            color: #d4d4d4;
        }
        .card {
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.1);
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        }
        .status-text { font-weight: bold; }
        .status-text-submitted { color: gray; }
        .status-text-confirmed { color: green; }
        .status-text-pending { color: orange; }
        .status-text-rejected { color: red; }
        .status-text-on-progress { color: blue; }
        .status-text-ready { color: purple; }
        .status-text-done { color: green; }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .table thead {
            background-color: #007bff;
            color: white;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        footer {
            background-color: #343a40;
            color: white;
            padding: 10px 0;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div id="sidebar" class="sidebar">
    <a href="#" class="text-white mb-3" onclick="toggleSidebar()">✕ Close</a>
    <a href="#newRequests" onclick="showSection(event, 'newRequests')">New Sparepart Requests</a>
    <a href="#ongoingRequests" onclick="showSection(event, 'ongoingRequests')">Ongoing Sparepart Requests</a>
    <a href="#historyRequests" onclick="showSection(event, 'historyRequests')">History of Sparepart Requests</a>
</div>

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid d-flex align-items-center">
        <img src="{{ asset('frontend/assets/images/auth-login-dark.png') }}" alt="Company Logo" class="me-3" style="height: 30px;">
        <button class="btn btn-dark ms-2" onclick="toggleSidebar()">☰</button>
        <div class="ms-auto text-white d-flex align-items-center">
            <span class="me-2">Supervisor: <strong>supervisor@example.com</strong></span>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div id="mainContent" class="content container mt-5">
    

    <!-- New Sparepart Requests Section -->
    <section id="newRequests" class="mt-4">
        <h3>New Sparepart Requests</h3>
        @if($newRequests->isEmpty())
            <p>No new sparepart requests found.</p>
        @else
            <table class="table table-bordered mt-3 table-hover">
                <thead>
                    <tr>
                        <th class="text-start">ID</th>
                        <th class="text-start">Distributor</th>
                        <th class="text-start">Sparepart</th>
                        <th class="text-start">Quantity</th>
                        <th class="text-start">Status</th>
                        <th class="text-start">Request Date</th>
                        <th class="text-start">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($newRequests as $request)
                        @php
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
                                @if($status != 'confirmed')
                                    <button class="btn btn-success btn-sm action-button" data-action="Confirmed" data-id="{{ $request->id }}">Accept</button>
                                @endif
                                @if($status != 'pending')
                                    <button class="btn btn-warning btn-sm action-button" data-action="Pending" data-id="{{ $request->id }}">Pending</button>
                                @endif
                                @if($status != 'rejected')
                                    <button class="btn btn-danger btn-sm action-button" data-action="Rejected" data-id="{{ $request->id }}">Reject</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>

    <!-- Ongoing Sparepart Requests Section -->
    <section id="ongoingRequests" class="mt-4" style="display: none;">
        <h3>Ongoing Sparepart Requests</h3>
        @if($ongoingRequests->isEmpty())
            <p>No ongoing sparepart requests found.</p>
        @else
            <table class="table table-bordered mt-3 table-hover">
                <thead>
                    <tr>
                        <th class="text-start">ID</th>
                        <th class="text-start">Distributor</th>
                        <th class="text-start">Sparepart</th>
                        <th class="text-start">Quantity</th>
                        <th class="text-start">Status</th>
                        <th class="text-start">Request Date</th>
                        <th class="text-start">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ongoingRequests as $request)
                        @php
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
                                @if($status != 'confirmed')
                                    <button type="button" class="btn btn-success btn-sm action-button" data-action="Confirmed" data-id="{{ $request->id }}">Accept</button>
                                @endif
                                @if($status != 'pending')
                                    <button type="button" class="btn btn-warning btn-sm action-button" data-action="Pending" data-id="{{ $request->id }}">Pending</button>
                                @endif
                                @if($status != 'rejected')
                                    <button type="button" class="btn btn-danger btn-sm action-button" data-action="Rejected" data-id="{{ $request->id }}">Reject</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>

    <!-- History of Sparepart Requests Section -->
    <section id="historyRequests" class="mt-4" style="display: none;">
        <h3>History of Sparepart Requests</h3>
        @if($historyRequests->isEmpty())
            <p>No history of sparepart requests found.</p>
        @else
            <table class="table table-bordered mt-3 table-hover">
                <thead>
                    <tr>
                        <th class="text-start">ID</th>
                        <th class="text-start">Distributor</th>
                        <th class="text-start">Sparepart</th>
                        <th class="text-start">Quantity</th>
                        <th class="text-start">Status</th>
                        <th class="text-start">Request Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($historyRequests as $request)
                        @php
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>
</div>

<!-- Footer -->
<footer>
    <p>&copy; 2024 PT. My Spare Parts. <br> All Rights Reserved. </br></p>
    <p></p>
</footer>

<!-- JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('active');
        document.getElementById('mainContent').classList.toggle('shifted');
    }

    function showSection(event, sectionId) {
        event.preventDefault();
        
        // Hide all sections
        document.getElementById('newRequests').style.display = 'none';
        document.getElementById('ongoingRequests').style.display = 'none';
        document.getElementById('historyRequests').style.display = 'none';
        
        // Display the selected section
        document.getElementById(sectionId).style.display = 'block';
        
        // Close the sidebar after clicking
        toggleSidebar();
    }

    // SweetAlert2 example for action buttons
    document.querySelectorAll('.action-button').forEach(button => {
        button.addEventListener('click', function() {
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
