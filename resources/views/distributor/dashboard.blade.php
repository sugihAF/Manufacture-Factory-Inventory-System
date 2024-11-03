<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distributor Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
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
</head>

<body class="font-sans bg-gray-100 text-gray-800">

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar inactive fixed top-0 left-0 w-64 h-full bg-gray-800 text-white p-4 overflow-y-auto shadow-md">
        <a href="#" class="block mb-3 text-xl font-bold" onclick="toggleSidebar()">✕ Close</a>
        <a href="#sparepartRequests" onclick="showSection(event, 'sparepartRequests')" class="block p-3 mb-2 hover:bg-gray-700 rounded">Your Sparepart Requests</a>
        <a href="#invoices" onclick="showSection(event, 'invoices')" class="block p-3 mb-2 hover:bg-gray-700 rounded">Your Invoices</a>
    </div>

    <!-- Header -->
    <nav class="bg-gray-900 text-white p-4 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <span>Distributor Dashboard</span>
            <button class="bg-gray-800 p-2 rounded-md hover:bg-gray-700" onclick="toggleSidebar()">☰</button>
        </div>
        <div class="flex items-center space-x-4">
            <span>Distributor: <strong>{{ Auth::user()->email }}</strong></span>
            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                @csrf
                <button type="button" onclick="confirmLogout()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Logout</button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <div id="mainContent" class="p-6 mt-6 transition-all">

        <!-- Sparepart Requests Section -->
        <section id="sparepartRequests" class="mt-6">
            <h3 class="text-2xl font-semibold mb-4">Your Sparepart Requests</h3>
            <a href="{{ route('distributor.create-request') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">Create Request</a>
            @if($sparepartRequests->isEmpty())
                <p class="text-gray-500">No sparepart requests found.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="py-3 px-4 text-left">ID</th>
                                <th class="py-3 px-4 text-left">Sparepart</th>
                                <th class="py-3 px-4 text-left">Quantity</th>
                                <th class="py-3 px-4 text-left">Status</th>
                                <th class="py-3 px-4 text-left">Request Date</th>
                                <th class="py-3 px-4 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sparepartRequests as $request)
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="py-2 px-4">{{ $request->id }}</td>
                                    <td class="py-2 px-4">{{ $request->sparepart->name }}</td>
                                    <td class="py-2 px-4">{{ $request->qty }}</td>
                                    <td class="py-2 px-4">{{ $request->status }}</td>
                                    <td class="py-2 px-4">{{ $request->request_date }}</td>
                                    <td class="py-2 px-4">
                                        <form action="{{ route('distributor.delete-request', $request->id) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded delete-button">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

        <!-- Invoices Section -->
        <section id="invoices" class="mt-6" style="display: none;">
            <h3 class="text-2xl font-semibold mb-4">Your Invoices</h3>
            @if($invoices->isEmpty())
                <p class="text-gray-500">No invoices found.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="py-3 px-4 text-left">ID</th>
                                <th class="py-3 px-4 text-left">Request ID</th>
                                <th class="py-3 px-4 text-left">Total Amount</th>
                                <th class="py-3 px-4 text-left">Invoice Date</th>
                                <th class="py-3 px-4 text-left">Payment Date</th>
                                <th class="py-3 px-4 text-left">Status</th>
                                <th class="py-3 px-4 text-left">Due Date</th>
                                <th class="py-3 px-4 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="py-2 px-4">{{ $invoice->id }}</td>
                                    <td class="py-2 px-4">{{ $invoice->request_id }}</td>
                                    <td class="py-2 px-4">{{ formatRupiah($invoice->total_amount) }}</td>
                                    <td class="py-2 px-4">{{ $invoice->invoice_date }}</td>
                                    <td class="py-2 px-4">{{ $invoice->payment_date }}</td>
                                    <td class="py-2 px-4">{{ $invoice->status }}</td>
                                    <td class="py-2 px-4">{{ $invoice->due_date }}</td>
                                    <td class="py-2 px-4">
                                        <a href="{{ route('invoices.pdf', $invoice->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded">Download PDF</a>
                                        @if($invoice->status === 'Pending')
                                            <a href="{{ route('payment.pay', $invoice->id) }}" class="bg-green-500 hover:bg-green-700 text-white py-1 px-2 rounded">Pay Now</a>
                                        @elseif($invoice->status === 'Paid')
                                            <span class="bg-green-200 text-green-700 py-1 px-2 rounded">Paid</span>
                                        @else
                                            <span class="bg-gray-200 text-gray-700 py-1 px-2 rounded">{{ $invoice->status }}</span>
                                        @endif
                                    </td>
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

        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.delete-form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        $(document).ready(function() {
            $('table').DataTable({
                "paging": true,
                "pageLength": 10
            });
        });
    </script>
</body>

</html>
