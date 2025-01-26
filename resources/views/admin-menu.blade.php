<?php
    use Illuminate\Support\Facades\Auth;
?>

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
            const date = [
                '10/12/2004', '12/12/2022', '11/12/2022', '16/12/2022', '18/12/2022', '20/12/2022', 
                '22/12/2022', '24/12/2022', '26/12/2022', '28/12/2022', '30/12/2022', '01/01/2023', 
                '03/01/2023', '05/01/2023', '07/01/2023', '09/01/2023', '11/01/2023', '13/01/2023', 
                '15/01/2023', '17/01/2023', '19/01/2023', '21/01/2023', '23/01/2023', '25/01/2023', 
                '27/01/2023', '29/01/2023', '31/01/2023', '02/02/2023', '04/02/2023', '06/02/2023', 
                '08/02/2023', '10/02/2023', '12/02/2023', '14/02/2023', '16/02/2023', '18/02/2023', 
                '20/02/2023', '22/02/2023', '24/02/2023', '26/02/2023', '28/02/2023', '02/03/2023', 
                '04/03/2023', '06/03/2023', '08/03/2023', '10/03/2023', '12/03/2023', '14/03/2023', 
                '16/03/2023', '18/03/2023', '20/03/2023', '22/03/2023', '24/03/2023', '26/03/2023', 
                '28/03/2023', '30/03/2023', '01/04/2023', '03/04/2023', '05/04/2023', '07/04/2023', 
                '09/04/2023', '11/04/2023', '13/04/2023', '15/04/2023'
            ];

            var options = {
                series: [{
                    name: 'XYZ MOTORS',
                    data: date.map((d, i) => [new Date(d).getTime(), i + 1]) // Convert dates to timestamps and use index as value
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
                    text: 'Stock Price Movement',
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
                            return (val / 1000000).toFixed(0);
                        }
                    },
                    title: {
                        text: 'Price'
                    }
                },
                xaxis: {
                    type: 'datetime'
                },
                tooltip: {
                    shared: false,
                    y: {
                        formatter: function (val) {
                            return (val / 1000000).toFixed(0);
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
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
                                    <p>$12,345.67</p>
                                </div>
                                <div class="sales-item">
                                    <h6>Today's Sales</h6>
                                    <p>$1,234.56</p>
                                </div>
                                <div class="sales-item">
                                    <h6>This Week's Sales</h6>
                                    <p>$4,567.89</p>
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