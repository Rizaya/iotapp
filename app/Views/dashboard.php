<?= $this->extend('layout/template.php'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $title; ?></h1>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container">
            <div class="text-secondary">
                <small><em>Update: <span class="update-time"></span></em></small>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><img src="dist/img/ph-meter.png"></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Kadar pH</span>
                            <span class="info-box-number" id="ph-value">
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger elevation-1">TDS</span>
                        <div class="info-box-content">
                            <span class="info-box-text">Kadar TDS</span>
                            <span class="info-box-number" id="tds-value"></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-thermometer-half"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Suhu</span>
                            <span class="info-box-number" id="temp-value"></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-biohazard"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Kondisi</span>
                            <span class="info-box-number" id="con-value"></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <!-- Line chart -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="far fa-chart-bar"></i>
                                Grafik Perubahan pH
                            </h3>
                            <div class="card-tools">
                                <a class="btn btn-primary btn-sm" href="/ph">Detail <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="pH-chart"></canvas>
                        </div>
                        <!-- /.card-body-->
                    </div>
                    <!-- /.card -->
                </div><!-- /.container-->
                <div class="col-md-6">
                    <!-- Line chart -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="far fa-chart-bar"></i>
                                Grafik Perubahan TDS
                            </h3>
                            <div class="card-tools">
                                <a class="btn btn-primary btn-sm" href="/tds">Detail <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="TDS-chart"></canvas>
                        </div>
                        <!-- /.card-body-->
                    </div>
                    <!-- /.card -->
                </div><!-- /.container-->
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <!-- Line chart -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="far fa-chart-bar"></i>
                                Grafik Perubahan Suhu
                            </h3>
                            <div class="card-tools">
                                <a class="btn btn-primary btn-sm" href="/suhu">Detail <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="temp-chart"></canvas>
                        </div>
                        <!-- /.card-body-->
                    </div>
                    <!-- /.card -->
                </div><!-- /.container-->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('sensor_chart_js'); ?>
<script>
    var latestDataId = 0;
    var chartData1 = [];
    var chartData2 = [];
    var chartData3 = [];
    var chartLabels = [];

    // Function to fetch data from the server and update the charts
    function fetchData() {
        $.ajax({
            url: '<?php echo base_url('chart/fetchData'); ?>',
            dataType: 'json',
            data: {
                latestDataId: latestDataId
            },
            success: function(data) {
                if (data.length > 0) {
                    latestDataId = data[data.length - 1].id; // Update the latest data ID
                    updateCharts(data);
                }

                var lastArray = data.length - 1;
                $('#ph-value').text(data[lastArray].value1);
                $('#tds-value').html(data[lastArray].value2 + " " + "<small>PPM</small>");
                $('#temp-value').html(data[lastArray].value3 + " " + "<small>&deg;C</small>");
                $('.update-time').text(data[lastArray].reading_time);

                if (data[lastArray].value1 >= 6.5 && data[lastArray].value1 <= 8.5 && data[lastArray].value2 <= 250) {
                    $('#con-value').text('Baik');
                } else if ((data[lastArray].value1 >= 6 && data[lastArray].value1 < 6.5) || (data[lastArray].value1 > 8.5 && data[lastArray].value1 <= 9) || (data[lastArray].value2 > 250 && data[lastArray].value2 < 350)) {
                    $('#con-value').text('Kurang Baik');
                } else {
                    $('#con-value').text('Buruk');
                }

            }
        });
    }

    // Function to update the charts with new data
    function updateCharts(data) {
        var labels = [];
        var values1 = [];
        var values2 = [];
        var values3 = [];

        for (var i = 0; i < data.length; i++) {
            var label = data[i].reading_time;
            if (!chartLabels.includes(label)) {
                values1.unshift(data[i].value1);
                values2.unshift(data[i].value2);
                values3.unshift(data[i].value3);
                labels.unshift(label);
                chartLabels.unshift(label);
            }
        }

        var options = {
            animation: {
                duration: 0,
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
        // Update Chart 1
        chartData1.unshift(...values1);
        if (chartData1.length > 10) {
            chartData1.splice(10);
            chartLabels.splice(10);
        }
        var ctx1 = document.getElementById('pH-chart');
        var chart1 = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Nilai pH',
                    data: chartData1,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: options
        });

        // Update Chart 2
        chartData2.unshift(...values2);
        if (chartData2.length > 10) {
            chartData2.splice(10);
        }
        var ctx2 = document.getElementById('TDS-chart');
        var chart2 = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Nilai TDS',
                    data: chartData2,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: options
        });

        // Update Chart 3
        chartData3.unshift(...values3);
        if (chartData3.length > 10) {
            chartData3.splice(10);
        }
        var ctx3 = document.getElementById('temp-chart');
        var chart3 = new Chart(ctx3, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Nilai Suhu',
                    data: chartData3,
                    backgroundColor: 'rgba(255, 193, 7, 0.2)',
                    borderColor: 'rgba(255, 193, 7, 1)',
                    borderWidth: 1
                }]
            },
            options: options
        });
    }

    // Fetch data initially
    fetchData();

    // Fetch data every 5 seconds
    setInterval(fetchData, 5000);
</script>
<?= $this->endSection(); ?>