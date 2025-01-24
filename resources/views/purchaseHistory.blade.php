<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Pagination Buttons Format & Design-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Sort Buttons Format & Design-->
    <link href="https://cdn.datatables.net/2.2.1/css/dataTables.bootstrap5.css" rel="stylesheet">
    <link href="{{ asset('css/report.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Purchase History</h1>
        <div class="dataTable">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Transaction Date</th>
                        <th>Order ID</th>
                        <th>Total Points Used</th>
                        <th>Points Earned</th>
                        <th>Unique Identifier</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->TransactionDate }}</td>
                        <td>{{ $transaction->OrderID }}</td>
                        <td>{{ $transaction->TotalPointsUsed }}</td>
                        <td>{{ $transaction->PointsEarned }}</td>
                        <td>{{ $transaction->UniqueIdentifier }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">No transactions found.</td>
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
        $(document).ready(function () {
            $('#example').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                autoWidth: false,
                language: {
                    emptyTable: "No transactions available",
                }
            });
        });
    </script>
</body>
</html>
