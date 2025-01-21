<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Report Type</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .card {
            margin: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .card-header {
            background-color: #f8f9fa;
            font-size: 1.25rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">Generate Report</div>
            <div class="card-body">
                <div class="row">
                    @php
                        $reports = [
                            [
                                'title' => 'Loyalty Transaction Summary',
                                'description' => 'View detailed summary of all loyalty program transactions',
                                'route' => 'generateReport',
                                'type' => 'loyaltyTransactionSummary' // Updated to match the controller
                            ],
                            [
                                'title' => 'Customer Points Summary',
                                'description' => 'Analysis of points earned and redeemed by loyalty members',
                                'route' => 'generateReport',
                                'type' => 'customerPointsSummary' // Updated
                            ],
                            [
                                'title' => 'Product Performance for Loyalty Customers',
                                'description' => 'Track most popular products among loyalty members',
                                'route' => 'generateReport',
                                'type' => 'productPerformance' // Updated
                            ],
                            [
                                'title' => 'Loyalty Customer Purchase History',
                                'description' => 'Detailed purchase records for loyalty program members',
                                'route' => 'generateReport',
                                'type' => 'loyaltyCustomerHistory' // Updated
                            ]
                        ];
                    @endphp

                    @foreach ($reports as $report)
                        <div class="col-md-6">
                            <form action="{{ route($report['route']) }}" method="POST">
                                @csrf
                                <input type="hidden" name="reportType" value="{{ $report['type'] }}">
                                <button class="btn btn-outline-primary w-100 p-3 text-start" type="submit">
                                    <h5>{{ $report['title'] }}</h5>
                                    <p class="text-muted">{{ $report['description'] }}</p>
                                </button>
                            </form>
                        </div>
                    @endforeach

                    <!--<form action="{{ route('generateReport') }}" method="POST">
                        <input type="hidden" name="reportType" value="{{ $report['type'] }}">
                        <button class="btn btn-primary">Generate {{ $report['title'] }}</button>
                    </form>-->

                </div>
            </div>
        </div>
    </div>
</body>
</html>
