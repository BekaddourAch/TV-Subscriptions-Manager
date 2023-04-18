<div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Statistiques</h1>
    </div>

    <div class="row mb-5">
        <div class="col-sm-12">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <form  wire:submit.prevent="submit">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-sm-4">
                                Date Début:<br/>
                                <input type="text" class="form-control" id="begin" wire:model.lazy="begin" autocomplete="off">
                                @error('begin') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-sm-4">
                                Date Fin:<br/>
                                <input type="text" class="form-control" id="end" wire:model.lazy="end" autocomplete="off">
                                @error('end') <span class="error">{{ $message }}</span> @enderror
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalCustomers}}</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{formatPrice($totalProfits)}}</div>
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
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$totalSubscriptions}}</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalActiveSubscriptions}}</div>
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
                <div class="card-body" data-sales="{{base64_encode(json_encode($subscriptionsTotalSalesPerMonth))}}">
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
                        @forelse($topSubscriptionsPerRegions as $region)
                            <span class="mr-2" data-color="{{ base64_encode(json_encode($colors[$loop->iteration-1]))}}" data-profit="{{$region["total_spent"]}}" >
                                <i class="fas fa-circle " style="color:{{$colors[$loop->iteration-1]["backgroundColor"]}}" ></i> <span class="label-data">{{$region["state"]}}</span>
                            </span>
                            @empty
                                <span class="mr-2" data-color="{{ base64_encode(json_encode($colors[0])) }}" data-profit="{{$totalSales}}">
                                <i class="fas fa-circle " style="color:{{$colors[0]["backgroundColor"]}}" ></i> <span class="label-data">Total Ventes</span>
                            </span>
                        @endforelse
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
                    @forelse($subscriptionsTotalServices as $key=>$service)
                    <h4 class="small font-weight-bold">{{$key}} <span
                            class="float-right"> {{$service. '  ('.number_format($service * 100 / $totalSubscriptions, 2 ,".", "").'%)'}}</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ number_format($service * 100 / $totalSubscriptions, 2 ,".", "")}}%"
                            aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @empty
                        <h4 class="small font-weight-bold">Total Ventes <span
                                class="float-right">100% </span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 100%"
                                 aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    @endforelse
                </div>
            </div>


        </div>

    </div>

    <div class="shadow card" >
        <div class="py-3 card-header">
            <ol class="m-0 breadcrumb float-sm-left font-weight-bold text-primary">
                <li class="breadcrumb-item"><a href="{{ route('admin.subscriptions') }}">Les Abonnements</a></li>
            </ol>
            <div class="mt-2 d-flex justify-content-end">

            </div>
        </div>
        <div class="flex-wrap d-flex justify-content-between">
            <div class="pt-3 my-2 ml-3 ml-md-3 my-md-0 mw-80 navbar-search">
                <div class="input-group">
                    <input wire:model="searchTerm" type="text" class="border-0 form-control bg-light small"
                           placeholder="Rechercher..." aria-label="Search" aria-describedby="basic-addon2"
                           spellcheck="false" data-ms-editor="true">
                    <div class="input-group-append">
                        <button class="btn btn-primary btn-sm" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <div class="p-3 card-body">
            <div class="table-responsive" >
                <table class="table" >
                    <thead class="text-white bg-dark">
                    <tr class="text-center">

                        <th class="align-middle" scope="col">#</th>
                        <th class="text-left align-middle "> Service </th>
                        <th class="text-left align-middle "> Client </th>
                        <th class="align-middle d-none d-md-table-cell"> Prix d'Achat </th>
                        <th class="align-middle d-none d-md-table-cell"> Quantité </th>
                        <th class="align-middle d-none d-md-table-cell"> Prix de Vente </th>
                        <th class="align-middle d-none d-md-table-cell"> Total </th>
                        <th class="align-middle d-none d-md-table-cell"> Date Début </th>
                        <th class="align-middle d-none d-md-table-cell"> Date Fin </th>
                        <th class="align-middle"> A Expirer dans (jours) </th>

                    </tr>
                    </thead>
                    <tbody >
                    @forelse($subscriptionsPerDate as $index => $subscription)
                        <tr class="text-center">

                            <td class="align-middle" scope="row">#{{ $subscription["id_subscription"] }}</td>
                            <td class="align-middle text-left">{{ $subscription["service_name"] }}</td>
                            <td class="align-middle text-left">
                                {{ $subscription["firstname"] . ' ' . $subscription["lastname"] }}
                            </td>
                            <td class="align-middle d-none d-md-table-cell">{{ formatPrice($subscription["cost_price"]) }}</td>
                            <td class="align-middle d-none d-md-table-cell">{{ $subscription["quantity"] }}</td>
                            <td class="align-middle d-none d-md-table-cell">{{ formatPrice($subscription["selling_price"]) }}</td>
                            <td class="align-middle d-none d-md-table-cell">{{ formatPrice($subscription["total"]) }}</td>
                            <td class="align-middle d-none d-md-table-cell">{{ formatDate($subscription["begin_date"]) }}</td>
                            <td class="align-middle d-none d-md-table-cell">{{ formatDate($subscription["end_date"]) }}</td>
                            <td class="align-middle">
                                <div class="progress">
                                    <div class="progress-bar @if($subscription["nb_days"]>20) bg-info @elseif($subscription["nb_days"]>10) bg-warning @else bg-danger @endif " role="progressbar" style="width: {{ formatTwoDecimal(100-($subscription["nb_days"]*100/30)) }}%;" aria-valuenow="{{ formatTwoDecimal(100-($subscription["nb_days"]*100/30))  }}" aria-valuemin="0" aria-valuemax="100">{{ $subscription["nb_days"]  }}</div>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Aucun abonnement trouvé</td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                    <tr class="bg-light">
                        <td colspan="14">
{{--                            {!! $subscriptionsPerDate->appends(request()->all())->links() !!}--}}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @section('script')
        <script src="{{ asset('backend/vendor/chart.js/Chart.min.js') }}"></script>
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
                    @this.set('begin',start.format('DD/MM/YYYY') );

                });
                $('#end').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    minYear: 2000,
                    locale: {
                        format: 'DD/MM/YYYY'
                    }
                }, function(start, end, label) {
                    @this.set('end', start.format('DD/MM/YYYY'));
                });
            });
        </script>
    @endsection
</div>
