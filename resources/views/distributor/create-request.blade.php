<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Sparepart Request</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="font-sans bg-gray-100 text-gray-800">

    <!-- Header -->
    <nav class="bg-gray-900 text-white p-4 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <span>Distributor Dashboard</span>
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
    <div class="container mx-auto mt-10 p-6 bg-white rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold mb-6">Create Sparepart Request</h2>
        <form method="POST" action="{{ route('distributor.store-request') }}" id="createRequestForm">
            @csrf
            <div class="mb-4">
                <label for="sparepart_id" class="block text-gray-700 font-semibold mb-2">Sparepart</label>
                <select class="w-full px-3 py-2 border rounded-lg text-gray-700" id="sparepart_id" name="sparepart_id" required>
                    @foreach($spareparts as $sparepart)
                        <option value="{{ $sparepart->id }}">{{ $sparepart->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="qty" class="block text-gray-700 font-semibold mb-2">Quantity</label>
                <input type="number" class="w-full px-3 py-2 border rounded-lg text-gray-700" id="qty" name="qty" required>
            </div>
            <button type="button" onclick="confirmSubmission()" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">Submit</button>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white text-center py-4 mt-10">
        <p>&copy; 2024 PT. My Spare Parts. <br> All Rights Reserved. </p>
    </footer>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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

        function confirmSubmission() {
            Swal.fire({
                title: 'Confirm Submission',
                text: "Are you sure you want to submit this sparepart request?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('createRequestForm').submit();
                }
            });
        }
    </script>
</body>

</html>
