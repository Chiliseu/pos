

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Dipensa Teknolohiya Grocery - Admin Menu</title>
        <link rel="stylesheet" href="/css/adminMenu.css">
        <link rel="icon" type="image/png" href="/Picture/StoreLogo.png">
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var modal = document.getElementById('WelcomeAdmin-Modal');
                modal.classList.add('show'); // Show the modal
                modal.style.display = 'flex'; // Ensure display is set to flex

                // Auto-dismiss the modal after 5 seconds (5000 milliseconds)
                setTimeout(function() {
                    modal.classList.remove('show');
                    modal.classList.add('out');
                    setTimeout(function() {
                        modal.style.display = 'none'; // Hide the modal after animation
                    }, 1000); // Match the duration of the transform transition
                }, 5000);
            });
            </script>
                
            
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const chartElement = document.querySelector("#chart");
        const totalSalesElement = document.getElementById('total-sales');
        const todaysSalesElement = document.getElementById('todays-sales');
        const topProductElement = document.getElementById('top-product');

        // Initialize chart with empty data
        const chart = new ApexCharts(chartElement, {
            series: [{
                name: 'Total Sales',
                data: []
            }],
            chart: {
                type: 'area',
                height: 350,
                zoom: { enabled: true },
                toolbar: { autoSelected: 'zoom' }
            },
            dataLabels: { enabled: false },
            markers: { size: 0 },
            title: { text: 'Historical Sales Report', align: 'left' },
            fill: { gradient: { shadeIntensity: 1, opacityFrom: 0.5, opacityTo: 0 } },
            yaxis: { 
                labels: { formatter: val => val.toFixed(2) },
                title: { text: 'Total Sales' } 
            },
            xaxis: { type: 'datetime' },
            tooltip: { y: { formatter: val => val.toFixed(2) } }
        });
        chart.render();

        async function fetchLatestTransactions() {
            try {
                const response = await fetch('/latest-transactions');
                const dailySales = await response.json();
                
                //PROCESS DATA FOR CHART
                const sortedSales = dailySales.sort((a, b) => 
                    new Date(a.TransactionDate) - new Date(b.TransactionDate)
                );

                console.log(sortedSales)

                const chartData = sortedSales.map(day => ({
                    x: new Date(day.TransactionDate).getTime(),
                    y: parseFloat(day.TotalSales)
                }));


                // CALCULATE TOTALS
                const grandTotal = sortedSales.reduce((sum, day) => 
                    sum + parseFloat(day.TotalSales), 0);
                
                const today = new Date().toISOString().split('T')[0];
                const todayData = sortedSales.find(d => d.TransactionDate === today);

                // UPDATE DISPLAYS
                totalSalesElement.textContent = `₱${grandTotal.toFixed(2)}`;
                todaysSalesElement.textContent = todayData ? 
                    `₱${parseFloat(todayData.TotalSales).toFixed(2)}` : '₱0.00';

                // UPDATE CHART
                chart.updateSeries([{ name: 'Total Sales', data: chartData }]);

            } catch (error) {
                console.error('Fetch error:', error);
                alert('Error loading sales data. Please refresh!');
            }
        }

            async function fetchTopProduct() {
                try {
                    const response = await fetch('/top-product');
                    const topProduct = await response.json();

                    // Update top product in the HTML
                    if (topProductElement) {
                        topProductElement.textContent = `${topProduct.name} (${topProduct.quantity} sold)`;
                    }
                } catch (error) {
                    console.error('Error fetching top product:', error);
                }
            }

            // Fetch latest transactions and top product every 60 seconds
            setInterval(fetchLatestTransactions, 3000);
            setInterval(fetchTopProduct, 3000);

            // Initial fetch
            fetchLatestTransactions();
            fetchTopProduct();
        });
    </script>
    </head>

    <body>
        <div class="container">
            <div class="menulogo-container">
                <div class="menulogo">
                    <div class="logo-container">
                        <img src="/Picture/StoreLogo.png" alt="Store Logo" class="logo"> 
                    </div>
                    <h1>Dipensa Teknolohiya Grocery</h1>
                </div>
                <!-- contains dashboard -->
                <div class="dashboard">
                    <h2>Dashboard</h2>
                    <hr>
                    <div class="dashboard-row1">
                        <div class="stat">
                            <div id="chart"></div>
                        </div>
                        <div class="sales">
                            <div class="sales-data">
                                <div class="sales-item">
                                    <h6>Total Sales</h6>
                                    <p id="total-sales">No Sales Record</p>
                                </div>
                                <div class="sales-item">
                                    <h6>Today's Sales</h6>
                                    <p id="todays-sales">No Sales Record Today</p>
                                </div>
                                <div class="top-product">
                                    <h6>Top Product</h6>
                                    <p id="top-product">Nothing</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            
            <div class="menubtn-container">
                <!-- Point-of-Sale Button -->
                <form action="{{ route('checkout') }}">
                    <button type="submit">Point-of-Sale</button>
                </form>

                <!-- User Management Button -->
                <form action="{{ route('userManage') }}">
                    <button type="submit">User Management</button>
                </form>
                
                <!-- Select Report Type Button -->
                <form action="{{ route('selectReportType') }}">
                    <button type="submit" class="Reportbtn">Generate Report</button>
                </form>

                <!-- Logout Button -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" id="logout-btn">Logout</button>
                </form>
            </div>


        <!----------MODAL ----------->
        <div class="modal" id="WelcomeAdmin-Modal">
            <div class="content-modal">
            <h2>WELCOME</h2>  
            <h3 id="username">{{ Auth::user()->name }}</h3>         
            <p>You are now logged in as admin (^ v ^)</p>
            </div>
        </div>
    </body>
</html>