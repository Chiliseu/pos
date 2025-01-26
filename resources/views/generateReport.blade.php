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
        <h1>Report: {{ ucfirst(str_replace('-', ' ', $reportType)) }}</h1>

        <!-- Filters -->
        <form method="POST" action="{{ route('generateReport') }}" id="filterForm">
            <input type="hidden" name="reportType" value="{{ $reportType }}">
            @foreach ($filters as $filter)
                <div class="mb-3">
                    @if ($filter === 'start_date' || $filter === 'end_date')
                        <!-- Date Picker -->
                        <label for="{{ $filter }}" class="form-label">{{ ucfirst(str_replace('_', ' ', $filter)) }}</label>
                        @component('components.datepicker', ['name' => $filter, 'defaultDate' => $filter === 'start_date' ? '2019-01-01' : now()->format('Y-m-d')])
                        @endcomponent
                    @elseif ($filter === 'user_id' || $filter === 'customer_id')
                        <!-- Searchable Dropdown -->
                        <label for="{{ $filter }}" class="form-label">{{ ucfirst(str_replace('_', ' ', $filter)) }}</label>
                        <select name="{{ $filter }}" id="{{ $filter }}" class="form-select w-full">
                            <option value="">All</option>
                            @foreach ($users as $user) <!-- Adjust for customers if needed -->
                                <option value="{{ $user->id }}">{{ $user->firstname }} {{ $user->lastname }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            @endforeach
        </form>

        <!-- Table -->
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
                            @foreach ($headers as $header)
                                <td>{{ $row[$header] ?? 'N/A' }}</td> <!-- Adjust mapping logic -->
                            @endforeach
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

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.1/js/dataTables.bootstrap5.js"></script>

    <script>
        new DataTable('#example');

        // Auto-refresh on filter change
        document.querySelectorAll('#filterForm input, #filterForm select').forEach(element => {
            element.addEventListener('change', () => {
                document.getElementById('filterForm').submit();
            });
        });
    </script>
</body>
</html>
