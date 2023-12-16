<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
<div id="area-print">
    <div class="card" style="border: 1px solid black">
        <div class="card-body">

            <table style="background: gray" width="100%">
                <tr>
                    <td><img src="{{ URL::asset('img/forklift.png') }}" alt="" height="100"
                            class="logo logo-dark">
                    </td>
                    <td>
                        <div style="font-size: 20px;"><b>KPI DASHBOARD {{ Session::get('runnamaregion') }}</b></div>
                    </td>
                    <td>Update: {{ date('Y/m/d') }}</td>
                </tr>
            </table>
            <br>
            <div
                style="border-top-left-radius: 20px; border: 1px solid grey; padding:10px; border-bottom-right-radius:20px">
                <div
                    style="margin-top:-25px; margin-left:10px; width:200px; height:30px; background: grey; border-radius:10px; padding:5px; color:white; text-align:center">
                    MHE Availability</div>
                <table>
                    <thead>
                        <tr>
                            <TH width="25%" style="text-align: left">UNIT TYPE</TH>
                            <TH width="20%" style="text-align: center">UNITS</TH>
                            <TH width="20%" style="text-align: center">TOTAL HOUR AVAILABILITY (MINUTE)</TH>
                            <TH width="20%" style="text-align: center">TARGET HOUR AVAILABILITY (MINUTE)</TH>
                            <TH width="15%" style="text-align: center">ACHIEVEMENT (%)</TH>


                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($kpi as $item)
                            <tr>
                                <td>{{ $item->namaforklifttype }}</td>
                                <td style="text-align: center;">{{ $item->jmlunit }}</td>
                                <td style="text-align: center;">{{ number_format($item->sumplanunitkerja) }}</td>
                                <td style="text-align: center;">{{ number_format($item->sumtotaljamkerja) }}</td>
                                <td style="text-align: center; color:blue">{{ number_format($item->avgpaforklift, 2) }}
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="table-responsive">

                <div class="card">
                
                    <div class="card-header">
                        <h4 class="card-title mb-0">MHE PERFORMANCE CHART</h4>
                    </div>
                    <div class="card-body">
                        <div id="column_chart" data-colors='["#2ab57d", "#5156be", "#fd625e"]'' class="apex-charts"
                            dir="ltr">

                        </div>
                    </div>
                </div>
                <!--end card-->
            </div>
            <div style="text-align: right"><img src="{{ URL::asset('img/mhe-kpi.png') }}" alt=""
                    class="logo logo-dark"></div>
        </div>
    </div>
</div>
<style>
    .apexcharts-tooltip span {
    color: #ffffff;
}
</style>
<div style="text-align: center;"><button type="button" class="btn btn-primary" id="cetak"
        onclick="printDiv('area-print')">Print KPI</button></div>
<script>

    /*
Template Name: Minia - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Apex Chart init js
*/

    // get colors array from the string
    function getChartColorsArray(chartId) {

        var colors = $(chartId).attr('data-colors');
        var colors = JSON.parse(colors);
        return colors.map(function(value) {
            var newValue = value.replace(' ', '');
            if (newValue.indexOf('--') != -1) {
                var color = getComputedStyle(document.documentElement).getPropertyValue(newValue);
                if (color) return color;
            } else {
                return newValue;
            }
        })
    }


    // column chart
    var columnColors = getChartColorsArray("#column_chart");

    var options = {
        chart: {
            height: 350,
            type: 'bar',
            toolbar: {
                show: false,
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '50%',
            },

        },
        dataLabels: {
            enabled: true,
            style: {
                fontSize: '8px',
                colors: ['black']
            },
           
        },
        stroke: {
            show: true,
            width: 1,
            colors: ['#e9e9f2']
        },
        series: [{
            name: 'Achievement',
            data: {{ $achievement }}
        }, {
            name: 'Max. Availability',
            data: {{ $max }}
        }, {
            name: 'Base Availability',
            data: {{ $base }}
        }],
        colors: columnColors,
        xaxis: {
            categories: <?php echo $kategori ?>,
            labels: {
            style: {
                fontSize: '7px',
                colors: ['#0b0b0d']
            }
       }

        },
        yaxis: {
            title: {
                text: '% (percent)',
                style: {
                    fontWeight: '500',
                },
            }
        },
        grid: {
            borderColor: '#f1f1f1',
        },
        fill: {
            opacity: 1

        },

        tooltip: {
            y: {
                formatter: function(val) {
                    return "$ " + val + " %"
                }
            }
        }
    }

    var chart = new ApexCharts(
        document.querySelector("#column_chart"),
        options
    );

    chart.render();
</script>
