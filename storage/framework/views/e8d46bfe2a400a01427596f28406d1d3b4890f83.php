<div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <div class="row mb-5">
        <div class="col-sm-12">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <form  wire:submit.prevent="submit">
                        <?php echo e(csrf_field()); ?>

                        <div class="row">
                            <div class="col-sm-4">
                                Date Début:<br/>
                                <input type="text" class="form-control" id="begin" wire:model.lazy="begin" autocomplete="off">
                                <?php $__errorArgs = ['begin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-sm-4">
                                Date Fin:<br/>
                                <input type="text" class="form-control" id="end" wire:model.lazy="end" autocomplete="off">
                                <?php $__errorArgs = ['end'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-sm-4">
                                <br/>
                                <button class="btn btn-success" id="btnSearch" value="1" type="submit">Rechercher</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
    <!-- Content Row -->
    <div class="row">

        <!-- Abonnements Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Nb Clients</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalCustomers); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Profits</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e(formatPrice($totalProfits)); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Nb Abonnements
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo e($totalSubscriptions); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Nb Abonnements Actifs</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalActiveSubscriptions); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Ventes Par Mois</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body" data-sales="<?php echo e(base64_encode(json_encode($subscriptionsTotalSalesPerMonth))); ?>">
                    <div class="chart-area"  wire:ignore>
                        <canvas id="salesPerMonthChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Ventes Par Wilayas</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body ">
                    <div class="chart-pie pt-4 pb-2" wire:ignore>
                        <canvas id="subscriptionsPerRegions"  ></canvas>
                    </div>
                    <div class="mt-4 text-center small"  id="subscriptionsPerRegionsData">
                        <?php
                        $colors = [
                            [ "backgroundColor"=> '#ff6384', "hoverBackgroundColor"=> '#ff6384cc' ],
                            [ "backgroundColor"=> '#36a2eb', "hoverBackgroundColor"=> '#36a2ebcc' ],
                            [ "backgroundColor"=> '#ffce56', "hoverBackgroundColor"=> '#ffce56cc' ],
                            [ "backgroundColor"=> '#cc65fe', "hoverBackgroundColor"=> '#cc65fecc' ],
                            [ "backgroundColor"=> '#ff9f40', "hoverBackgroundColor"=> '#ff9f40cc' ],
                            [ "backgroundColor"=> '#837cfc', "hoverBackgroundColor"=> '#837cfccc' ],
                            [ "backgroundColor"=> '#4bc0c0', "hoverBackgroundColor"=> '#4bc0c0cc' ],
                            [ "backgroundColor"=> '#7cb5ec', "hoverBackgroundColor"=> '#7cb5eccc' ],
                            [ "backgroundColor"=> '#91e8e1', "hoverBackgroundColor"=> '#91e8e1cc' ],
                            [ "backgroundColor"=> '#2b908f', "hoverBackgroundColor"=> '#2b908fcc' ]
                        ];
                        ?>
                        <?php $__empty_1 = true; $__currentLoopData = $topSubscriptionsPerRegions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <span class="mr-2" data-color="<?php echo e(base64_encode(json_encode($colors[$loop->iteration-1]))); ?>" data-profit="<?php echo e($region["total_spent"]); ?>" >
                                <i class="fas fa-circle " style="color:<?php echo e($colors[$loop->iteration-1]["backgroundColor"]); ?>" ></i> <span class="label-data"><?php echo e($region["state"]); ?></span>
                            </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <span class="mr-2" data-color="<?php echo e(base64_encode(json_encode($colors[0]))); ?>" data-profit="<?php echo e($totalSales); ?>">
                                <i class="fas fa-circle " style="color:<?php echo e($colors[0]["backgroundColor"]); ?>" ></i> <span class="label-data">Total Ventes</span>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col-12 mb-4">

            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Abonnements Par Services</h6>
                </div>
                <div class="card-body" style="max-height: 400px; overflow: auto;">
                    <?php $__empty_1 = true; $__currentLoopData = $subscriptionsTotalServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <h4 class="small font-weight-bold"><?php echo e($key); ?> <span
                            class="float-right"> <?php echo e($service. '  ('.number_format($service * 100 / $totalSubscriptions, 2 ,".", "").'%)'); ?></span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo e(number_format($service * 100 / $totalSubscriptions, 2 ,".", "")); ?>%"
                            aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <h4 class="small font-weight-bold">Total Ventes <span
                                class="float-right">100% </span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 100%"
                                 aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>


        </div>

    </div>
    <?php $__env->startSection('script'); ?>
        <script src="<?php echo e(asset('backend/vendor/chart.js/Chart.min.js')); ?>"></script>
        <script>
            window.addEventListener('draw-dashboard-charts', event => {
                drawtopSubscriptionsPerRegions();
                drawtopServices();
            });

            Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#858796';

            function drawtopSubscriptionsPerRegions(){
                var chartContainer = $("#subscriptionsPerRegions").parent();
                $(chartContainer).html("");
                $(chartContainer).html('<canvas id="subscriptionsPerRegions"></canvas>');
                var dataLabels = [];
                var dataValues = [];
                var dataBackColors = [];
                var dataHoverBackColors = [];
                $("#subscriptionsPerRegionsData > span").each(function(){
                    dataLabels.push($(this).find(".label-data").text());
                    dataValues.push($(this).attr("data-profit"));
                    var dataColors = JSON.parse(atob($(this).data("color")));
                    dataBackColors.push(dataColors.backgroundColor);
                    dataHoverBackColors.push(dataColors.hoverBackgroundColor);
                });
                var ctx = document.getElementById("subscriptionsPerRegions");

                var myPieChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: dataLabels,
                        datasets: [{
                            data: dataValues,
                            backgroundColor:  dataBackColors,
                            hoverBackgroundColor: dataHoverBackColors,
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                        tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            caretPadding: 10,
                            callbacks: {
                            label: function(tooltipItem, data) {
                                var value = data.datasets[0].data[tooltipItem.index];
                                return data.labels[tooltipItem.index] + ': ' + value + ' DA';
                            }
                        }
                    },
                    legend: {
                        display: false
                    },
                    cutoutPercentage: 80,
                },
            });
            }

            function drawtopServices(){
                var dataLabels = [];
                var dataValues = [];
                var dataSales = JSON.parse(atob($("#salesPerMonthChart").parent().parent().attr("data-sales")));
                Object.keys(dataSales).forEach(function(key, index) {
                     dataValues.push(dataSales[key]);
                });
                dataLabels = Object.keys(dataSales);
                var chartContainer = $("#salesPerMonthChart").parent();
                $(chartContainer).html("");
                $(chartContainer).html('<canvas id="salesPerMonthChart"></canvas>');
                var ctx = document.getElementById("salesPerMonthChart");
                var myLineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dataLabels,
                        datasets: [{
                            label: "Earnings",
                            lineTension: 0.3,
                            backgroundColor: "rgba(78, 115, 223, 0.05)",
                            borderColor: "rgba(78, 115, 223, 1)",
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointBorderColor: "rgba(78, 115, 223, 1)",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                            pointHitRadius: 10,
                            pointBorderWidth: 2,
                            data: dataValues,
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                left: 10,
                                right: 25,
                                top: 25,
                                bottom: 0
                            }
                        },
                        scales: {
                            xAxes: [{
                                time: {
                                    unit: 'date'
                                },
                                gridLines: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    maxTicksLimit: 7
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    maxTicksLimit: 5,
                                    padding: 10,
                                    // Include a dollar sign in the ticks
                                    callback: function(value, index, values) {
                                        return value+" DA";
                                    }
                                },
                                gridLines: {
                                    color: "rgb(234, 236, 244)",
                                    zeroLineColor: "rgb(234, 236, 244)",
                                    drawBorder: false,
                                    borderDash: [2],
                                    zeroLineBorderDash: [2]
                                }
                            }],
                        },
                        legend: {
                            display: false
                        },
                        tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            titleMarginBottom: 10,
                            titleFontColor: '#6e707e',
                            titleFontSize: 14,
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            intersect: false,
                            mode: 'index',
                            caretPadding: 10,
                            callbacks: {
                                label: function(tooltipItem, chart) {
                                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                    return datasetLabel + ': ' + tooltipItem.yLabel+' DA';
                                }
                            }
                        }
                    }
                });
            }



            $(document).ready(function(){
                drawtopSubscriptionsPerRegions();
                drawtopServices();
                $('#begin').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    minYear: 2000,
                    locale: {
                        format: 'DD/MM/YYYY'
                    }
                }, function(start, end, label) {
                    window.livewire.find('<?php echo e($_instance->id); ?>').set('begin',start.format('DD/MM/YYYY') );

                });
                $('#end').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    minYear: 2000,
                    locale: {
                        format: 'DD/MM/YYYY'
                    }
                }, function(start, end, label) {
                    window.livewire.find('<?php echo e($_instance->id); ?>').set('end', start.format('DD/MM/YYYY'));
                });
            });
        </script>
    <?php $__env->stopSection(); ?>
</div>
<?php /**PATH C:\xampp\htdocs\tv-subscriptions-management\resources\views/livewire/backend/admin/dashboard/dashboard.blade.php ENDPATH**/ ?>