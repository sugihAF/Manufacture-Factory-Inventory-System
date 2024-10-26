<!DOCTYPE html>
<html>
<head>
    <title>Distributor Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="{{ asset('css/status-colors.css') }}" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Welcome, Distributor</h2>
    <p>This is your dashboard.</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>

    <h3 class="mt-4">Your Sparepart Requests</h3>
    <a href="{{ route('distributor.create-request') }}" class="btn btn-success mb-3">Create Request</a>
    @if($sparepartRequests->isEmpty())
        <p>No sparepart requests found.</p>
    @else
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sparepart</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Request Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sparepartRequests as $request)
                    <tr class="status-{{ strtolower(str_replace(' ', '-', $request->status)) }}">
                        <td>{{ $request->id }}</td>
                        <td>{{ $request->sparepart->name }}</td>
                        <td>{{ $request->qty }}</td>
                        <td>{{ $request->status }}</td>
                        <td>{{ $request->request_date }}</td>
                        <td>
                            <form action="{{ route('distributor.delete-request', $request->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm delete-button">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
</script>
</body>
</html>