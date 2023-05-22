<?= $this->extend('layout/template.php'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
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
            <div class="row">
                <div class="col-md-10">
                    <!-- Line chart -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="far fa-chart-bar"></i>
                                Grafik Perubahan TDS
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="tds-chart"></canvas>
                        </div>
                        <!-- /.card-body-->
                    </div>
                    <!-- /.card -->
                </div><!-- /.container-->
                <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            Nilai Terendah : <div class="min"></div> </br>
                            Nilai Rata-rata : <div class="avg"></div> </br>
                            Nilai Tertinggi : <div class="max"></div> </br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data pembacaan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="dataTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Waktu</th>
                                <th>Nilai TDS</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Waktu</th>
                                <th>Nilai TDS</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="text-secondary">
                <small><em>Update: <span class="update-time"></span></em></small>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('tds-chart'); ?>
<script>
    var latestDataId = 0;
    var chartData = [];
    var chartLabels = [];
    // Function to fetch data from the server and update the chart
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
                    updateChart(data);
                }
            }
        });
    }

    // Function to update the chart with new data
    function updateChart(data) {

        var labels = [];
        var values = [];

        for (var i = 0; i < data.length; i++) {
            var label = data[i].reading_time;
            if (!chartLabels.includes(label)) {
                values.unshift(data[i].value2);
                labels.unshift(label);
                chartLabels.unshift(label);
            }
        }

        // Update the chart data
        chartData.unshift(...values);
        if (chartData.length > 10) {
            chartLabels.splice(10)
            chartData.splice(10); // Keep only the latest 10 data points
        }
        chart.data.datasets[0].data = chartData;
        chart.data.labels = chartLabels;
        chart.update();

        var arrnum = chartData.map(Number);
        var min = Math.min(...chartData);
        var max = Math.max(...chartData);
        var sum = arrnum.reduce((a, b) => a + b, 0);
        var avg = sum / chartData.length;

        $('.min').text(min + " " + "PPM");
        $('.max').text(max + " " + "PPM");
        $('.avg').text(avg.toFixed(2) + " " + "PPM");
    }
    // Update the chart
    var ctx = document.getElementById('tds-chart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Kadar TDS',
                data: chartData,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    // Fetch data initially
    fetchData();

    // Fetch data every 5 seconds
    setInterval(fetchData, 5000);
</script>
<script>
    function getData() {
        $.ajax({
            url: '<?= base_url('chart/data'); ?>',
            method: 'GET',
            success: function(data) {
                $('#dataTable tbody').empty();

                $.each(data, function(index, item) {
                    var row = '<tr>' +
                        '<td>' + (index + 1) + '</td>' +
                        '<td>' + item.reading_time + '</td>' +
                        '<td>' + item.value2 + '</td>' +
                        '</tr>';
                    $('#dataTable tbody').append(row);
                });
            }
        });
    }

    // Memanggil fetchData() saat halaman dimuat pertama kali
    getData();

    // Mengulangi pemanggilan getData() setiap beberapa detik (misalnya setiap 5 detik)
    setInterval(getData, 5000);

    $(function() {
        $('#dataTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#dataTable_wrapper .col-md-6:eq(0)');
    });
</script>
<?= $this->endSection(); ?>
<?= $this->section('Js_datatables'); ?>
<!-- DataTables  & Plugins -->
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/plugins/jszip/jszip.min.js"></script>
<script src="/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/plugins/pdfmake/vfs_fonts.js"></script>
<script src="/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<?= $this->endSection(); ?>