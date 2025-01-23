@php
    $reports = [
        [
            'title' => 'Loyalty Transaction Summary',
            'description' => 'View detailed summary of all loyalty program transactions',
            'endpoint' => 'loyalty-transaction-summary'
        ],
        [
            'title' => 'Customer Points Summary',
            'description' => 'Analysis of points earned and redeemed by loyalty members',
            'endpoint' => 'customer-points-summary'
        ],
        [
            'title' => 'Product Performance for Loyalty Customers',
            'description' => 'Track most popular products among loyalty members',
            'endpoint' => 'product-performance'
        ],
        [
            'title' => 'Loyalty Customer Purchase History',
            'description' => 'Detailed purchase records for loyalty program members',
            'endpoint' => 'loyalty-customer-history'
        ]
    ];
@endphp

@foreach ($reports as $report)
    <div class="card">
        <div class="card-body">
            <form id="form-{{ $report['endpoint'] }}" onsubmit="generateReport(event, '{{ $report['endpoint'] }}')">
                @csrf
                <h5 class="card-title">{{ $report['title'] }}</h5>
                <p class="card-text">{{ $report['description'] }}</p>

                <div class="form-group mb-3">
                    <label for="startDate-{{ $report['endpoint'] }}">Start Date</label>
                    <input type="date"
                           class="form-control"
                           id="startDate-{{ $report['endpoint'] }}"
                           name="startDate"
                           required>
                </div>

                <div class="form-group mb-3">
                    <label for="endDate-{{ $report['endpoint'] }}">End Date</label>
                    <input type="date"
                           class="form-control"
                           id="endDate-{{ $report['endpoint'] }}"
                           name="endDate"
                           required>
                </div>

                <button type="submit" class="btn btn-primary">
                    Generate Report
                </button>
            </form>
        </div>
    </div>
@endforeach

<script>
function generateReport(event, endpoint) {
    event.preventDefault();

    const form = document.getElementById(`form-${endpoint}`);
    const startDate = document.getElementById(`startDate-${endpoint}`).value;
    const endDate = document.getElementById(`endDate-${endpoint}`).value;

    // Create the URL with query parameters
    const url = `/report/${endpoint}?startDate=${startDate}&endDate=${endDate}`;

    // Create a temporary link element
    const link = document.createElement('a');
    link.href = url;
    link.target = '_blank'; // Opens in new tab

    // Append to document, click it, and remove it
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
