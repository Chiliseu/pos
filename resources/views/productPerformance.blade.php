<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loyalty Transaction Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="stylesheet" href="/css/productPerformance.css">


    <script src="{{ asset('js/TransactionAPIHandler.js') }}"></script> <!-- Ensure this is the correct path -->
</head>
<body>
    <!-- Back Buttons-->
    <div class="backBtn">
        <a href="javascript:history.back()" id="back">&larr; <span class="back">Back</span></a>
    </div>

    <div class="main-container">
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
                        <p class="product-list" id="top-product">No Products Sold</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-row2">
            <div class="products">
                <div id="products"></div>
            </div>
            <div class="Title">
                <h1>PRODUCT STATUS</h1>
            </div>
        </div>
    </div>


    <!-- ==============================================================================  -->
                                    <!-- SCRIPTURES -->
    <!-- ============================================================================== -->
    <!-- script for sales -->
    <script>
        // Fetch latest transactions and top product every 60 seconds
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




    <!-- Dashboard for sales of products -->
    <script> 
        document.addEventListener('DOMContentLoaded', function() {
            const productsElement = document.querySelector("#products");
            const productListElement = document.getElementById('product-list');

            const options = {
                series: [],
                chart: {
                    width: 380,
                    type: 'donut',
                },
                plotOptions: {
                    pie: {
                        startAngle: -90,
                        endAngle: 270
                    }
                },
                dataLabels: {
                    enabled: true
                },
                fill: {
                    type: 'gradient',
                },
                legend: {
                    formatter: function(val, opts) {
                        return val + " - " + opts.w.globals.series[opts.seriesIndex]
                    }
                },
                title: {
                    text: 'Product Sales Distribution'
                },
                labels: [],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            const productsChart = new ApexCharts(productsElement, options);
            productsChart.render();

            async function fetchProductSalesData() {
                try {
                    const response = await fetch('/product-sales-data');
                    const chartData = await response.json();

                    // Filter out products with 0 sales for the donut chart
                    const filteredData = chartData.filter(data => data.quantity > 0);

                    const series = filteredData.map(data => data.quantity);
                    const labels = filteredData.map(data => data.name);

                    productsChart.updateOptions({
                        series: series,
                        labels: labels
                    });

                    // Update the product list
                    const productListHtml = chartData.map(data => `
                        <div class="product-item">
                            <span>${data.name}</span>: <span>${data.quantity}</span>
                        </div>
                    `).join('');
                    productListElement.innerHTML = productListHtml;
                } catch (error) {
                    console.error('Error fetching product sales data:', error);
                }
            }

            // Fetch product sales data every 60 seconds
            setInterval(fetchProductSalesData, 60000);

            // Initial fetch
            fetchProductSalesData();
        });
     </script>

</body>
</html>