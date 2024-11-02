<!DOCTYPE html>
<html>
<head>
    <title>Factory Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Welcome, Factory</h2>
    <p>This is your dashboard.</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
</div>
</body>
</html>
