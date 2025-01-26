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

        /* Back button styling */
        .backBtn {
            margin: 20px 0;
            margin-left: 0px;
            width: 100%;
            text-align: left;
        }

        .backBtn a {
            text-decoration: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 20px;
            background-color: #2b4b2f; /* Dark green background */
            border: 2px solid #2b4b2f; /* Dark green border */
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .backBtn:hover {
            /* scale up */
            transform: scale(1.1);
            width: 250px;
            margin: 20px 0;
            margin-left: 0px;
            transition: ease 0.5s;
        }

        .backBtn:hover a span.back {
            display: inline-block;
        }

        .backBtn a span.back {
            display: none;
        }

        .backBtn a:hover {
            background-color: #1f3622; /* Darker green on hover */
            color: white;
            text-decoration: none;
            transform: scale(1.1); /* Slight scaling effect */
        }
    </style>
</head>
<body>
    <div class="backBtn">
        <a href="javascript:history.back()" id="back">&larr; <span class="back">Back</span></a>
    </div>
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
                                'type' => 'loyaltyTransactionSummary'
                            ],
                            [
                                'title' => 'Customer Points Summary',
                                'description' => 'Analysis of points earned and redeemed by loyalty members',
                                'route' => 'generateReport',
                                'type' => 'customerPointsSummary'
                            ],
                            [
                                'title' => 'Product Performance for Loyalty Customers',
                                'description' => 'Track most popular products among loyalty members',
                                'route' => 'generateReport',
                                'type' => 'productPerformance'
                            ],
                            [
                                'title' => 'Loyalty Customer Purchase History',
                                'description' => 'Detailed purchase records for loyalty program members',
                                'route' => 'generateReport',
                                'type' => 'loyaltyCustomerHistory'
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
                </div>
            </div>
        </div>
    </div>
</body>
</html>
