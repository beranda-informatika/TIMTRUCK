/*
Template Name: Minia - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Apex Chart init js
*/

// get colors array from the string
function getChartColorsArray(chartId) {
    alert(chartId);
    var colors = $(chartId).attr('data-colors');
    var colors = JSON.parse(colors);
    return colors.map(function(value){
        var newValue = value.replace(' ', '');
        if(newValue.indexOf('--') != -1) {
            var color = getComputedStyle(document.documentElement).getPropertyValue(newValue);
            if(color) return color;
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
            columnWidth: '45%',
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    series: [{
        name: 'Net Profit',
        data: [46, 57, 59, 54, 62, 58, 64, 60, 66]
    }, {
        name: 'Revenue',
        data: [74, 83, 102, 97, 86, 106, 93, 114, 94]
    }, {
        name: 'Free Cash Flow',
        data: [37, 42, 38, 26, 47, 50, 54, 55, 43]
    }],
    colors: columnColors,
    xaxis: {
        categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
    },
    yaxis: {
        title: {
            text: '$ (thousands)',
            style: {
                fontWeight:  '500',
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
            formatter: function (val) {
                return "$ " + val + " thousands"
            }
        }
    }
}

var chart = new ApexCharts(
    document.querySelector("#column_chart"),
    options
);

chart.render();
