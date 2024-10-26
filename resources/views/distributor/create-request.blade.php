<!DOCTYPE html>
<html>
<head>
    <title>Create Sparepart Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Create Sparepart Request</h2>
    <form method="POST" action="{{ route('distributor.store-request') }}">
        @csrf
        <div class="mb-3">
            <label for="sparepart_id" class="form-label">Sparepart</label>
            <select class="form-select" id="sparepart_id" name="sparepart_id" required>
                @foreach($spareparts as $sparepart)
                    <option value="{{ $sparepart->id }}">{{ $sparepart->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="qty" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="qty" name="qty" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>