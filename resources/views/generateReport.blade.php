<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.2.1/css/dataTables.bootstrap5.css" rel="stylesheet">
    <link href="{{ asset('css/report.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h1>Report: {{ ucfirst(str_replace('_', ' ', $reportType)) }}</h1>

        <!-- Filters -->
        <form method="POST" action="{{ route('generateReport') }}" id="filterForm">
            @csrf <!-- CSRF protection for POST requests -->
            <input type="hidden" name="reportType" value="{{ $reportType }}">

            <!-- Date Filters -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="startDate" id="start_date" class="form-control" value="{{ request('startDate', '2023-01-01') }}">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" name="endDate" id="end_date" class="form-control" value="{{ request('endDate', now()->format('Y-m-d')) }}">
                </div>
            </div>

            <!-- Customer Filter -->
            <div class="mb-3">
                <label for="customer_id" class="form-label">Customer</label>
                <select name="customerId" id="customer_id" class="form-select">
                    <option value="">All Customers</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ request('customerId') == $user->id ? 'selected' : '' }}>
                            {{ $user->firstname }} {{ $user->lastname }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Apply Filters</button>
        </form>

        <!-- Data Table -->
        <div class="table-container mt-4">
            <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        @foreach ($headers as $header)
                            <th>{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $row)
                        <tr>
                            <td>{{ $row->CustomerName }}</td>
                            <td>{{ $row->ProductName }}</td>
                            <td>{{ $row->Quantity }}</td>
                            <td>{{ $row->TotalPrice }}</td>
                            <td>{{ $row->OrderDate }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($headers) }}">No data to display</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.1/js/dataTables.bootstrap5.js"></script>
    <script>
        new DataTable('#example');

        // Auto-submit form on filter change
        document.querySelectorAll('#filterForm input, #filterForm select').forEach(element => {
            element.addEventListener('change', () => {
                document.getElementById('filterForm').submit();
            });
        });
    </script>
</body>
</html>
