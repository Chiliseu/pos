

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

            const options = {
                series: [{
                    name: 'Total Sales',
                    data: []
                }],
                chart: {
                    type: 'area',
                    stacked: false,
                    height: 350,
                    zoom: {
                        type: 'x',
                        enabled: true,
                        autoScaleYaxis: true
                    },
                    toolbar: {
                        autoSelected: 'zoom'
                    }
                },
                dataLabels: {
                    enabled: false
                },
                markers: {
                    size: 0
                },
                title: {
                    text: 'Total Sales Over Time',
                    align: 'left'
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        inverseColors: false,
                        opacityFrom: 0.5,
                        opacityTo: 0,
                        stops: [0, 90, 100]
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function (val) {
                            return val.toFixed(2);
                        }
                    },
                    title: {
                        text: 'Total Sales'
                    }
                },
                xaxis: {
                    type: 'datetime'
                },
                tooltip: {
                    shared: false,
                    y: {
                        formatter: function (val) {
                            return val.toFixed(2);
                        }
                    }
                }
            };

            const chart = new ApexCharts(chartElement, options);
            chart.render();

            async function fetchLatestTransactions() {
                try {
                    const response = await fetch('/latest-transactions');
                    const transactions = await response.json();

                    const data = transactions.map(transaction => {
                        return {
                            x: new Date(transaction.TransactionDate).getTime(),
                            y: transaction.TotalSales
                        };
                    });

                    // Calculate total sales
                    const totalSales = transactions.reduce((sum, transaction) => sum + transaction.TotalSales, 0);

                    // Update total sales in the HTML
                    if (totalSalesElement) {
                        totalSalesElement.textContent = `₱${totalSales.toFixed(2)}`;
                    }

                    // Calculate today's sales
                    const today = new Date().toISOString().split('T')[0];
                    const todaysSales = transactions
                        .filter(transaction => transaction.TransactionDate === today)
                        .reduce((sum, transaction) => sum + transaction.TotalSales, 0);

                    // Update today's sales in the HTML
                    if (todaysSalesElement) {
                        todaysSalesElement.textContent = `₱${todaysSales.toFixed(2)}`;
                    }

                    // Update chart data
                    chart.updateSeries([{
                        name: 'Total Sales',
                        data: data
                    }]);
                } catch (error) {
                    console.error('Error fetching latest transactions:', error);
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
            setInterval(fetchLatestTransactions, 60000);
            setInterval(fetchTopProduct, 60000);

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