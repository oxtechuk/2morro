/**
* Theme: Opatix - Tailwind CSS 4 Admin Layout & UI Kit Template
* Author: MyraStudio
* Module/App: dashboard js
*/
import Raphael from 'raphael';
window.Raphael = Raphael;

import ApexCharts from 'apexcharts';

import 'morris.js/morris.min.js';


"use strict";


// first chart
var options = {
    series: [{
        name: "Total Order",
        data: [4, 10, 25, 12, 25, 18, 40, 22, 7]
    }],
    chart: {
        height: 65,
        type: 'area',
        sparkline: {
            enabled: true
        },
        zoom: {
            enabled: false
        }
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        width: 2,
        curve: 'smooth'
    },
    fill: {
        type: 'gradient',
        gradient: {
            shade: 'dark',
            gradientToColors: ['#6366f1'],
            shadeIntensity: 1,
            type: 'vertical',
            opacityFrom: 0.75,
            opacityTo: 0.1,
        }
    },
    colors: ["#6366f1"],
    tooltip: {
        fixed: {
            enabled: false
        },
        x: {
            show: false
        },
        y: {
            title: {
                formatter: function () {
                    return "";
                }
            }
        },
        marker: {
            show: false
        }
    },
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep']
    }
};

var chart = new ApexCharts(document.querySelector("#total-order"), options);
chart.render();



//  second chart
var options = {
    series: [{
        name: "Total Sale",
        data: [35, 65, 47, 35, 44, 32, 27, 54, 44, 61]
    }],
    chart: {
        //width:150,
        height: 65,
        type: 'area',
        sparkline: {
            enabled: !0
        },
        zoom: {
            enabled: false
        }
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        width: 1.5,
        curve: "smooth"
    },
    fill: {
        type: 'gradient',
        gradient: {
            shade: 'dark',
            gradientToColors: ['#627898'],
            shadeIntensity: 1,
            type: 'vertical',
            opacityFrom: 0.75,
            opacityTo: 0.1,
        }
    },
    colors: ["#627898"],
    plotOptions: {
        bar: {
            horizontal: false,
            borderRadius: 3,
            columnWidth: '48%',
        }
    },
    tooltip: {
        fixed: {
            enabled: false
        },
        x: {
            show: false
        },
        y: {
            title: {
                formatter: function (e) {
                    return ""
                }
            }
        },
        marker: {
            show: false
        }
    },

    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
    }
};

var chart = new ApexCharts(document.querySelector("#total-sale"), options);
chart.render();


// 

var options = {
    series: [{
        name: "Total Visits",
        data: [4, 10, 25, 12, 25, 18, 40, 22, 7]
    }],
    chart: {
        height: 65,
        type: 'area',
        sparkline: {
            enabled: true
        },
        zoom: {
            enabled: false
        }
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        width: 2,
        curve: 'smooth'
    },
    fill: {
        type: 'gradient',
        gradient: {
            shade: 'dark',
            gradientToColors: ['#f1bf43'],
            shadeIntensity: 1,
            type: 'vertical',
            opacityFrom: 0.75,
            opacityTo: 0.1,
        }
    },
    colors: ["#f1bf43"],
    tooltip: {
        fixed: {
            enabled: false
        },
        x: {
            show: false
        },
        y: {
            title: {
                formatter: function () {
                    return "";
                }
            }
        },
        marker: {
            show: false
        }
    },
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep']
    }
};

var chart = new ApexCharts(document.querySelector("#total-visits"), options);
chart.render();


var options = {
    series: [{
        name: "Total Visits",
        data: [4, 10, 25, 12, 25, 18, 40, 22, 7]
    }],
    chart: {
        height: 65,
        type: 'area',
        sparkline: {
            enabled: true
        },
        zoom: {
            enabled: false
        }
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        width: 2,
        curve: 'smooth'
    },
    fill: {
        type: 'gradient',
        gradient: {
            shade: 'dark',
            gradientToColors: ['#df3554'],
            shadeIntensity: 1,
            type: 'vertical',
            opacityFrom: 0.75,
            opacityTo: 0.1,
        }
    },
    colors: ["#df3554"],
    tooltip: {
        fixed: {
            enabled: false
        },
        x: {
            show: false
        },
        y: {
            title: {
                formatter: function () {
                    return "";
                }
            }
        },
        marker: {
            show: false
        }
    },
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep']
    }
};

var chart = new ApexCharts(document.querySelector("#chart4"), options);
chart.render();


$(function () {
    'use strict';

    if ($('#morris-line-example').length) {
        Morris.Line({
            element: 'morris-line-example',
            gridLineColor: '#eef0f2',
            lineColors: ['#f15050', '#6d61ea', "#e9ecef"],
            data: [
                {
                    y: '2006',
                    a: 80,
                    b: 100,
                    c: 45
                },
                {
                    y: '2007',
                    a: 110,
                    b: 130,
                    c: 52
                },
                {
                    y: '2008',
                    a: 90,
                    b: 110,
                    c: 68
                },
                {
                    y: '2009',
                    a: 120,
                    b: 140,
                    c: 58
                },
                {
                    y: '2010',
                    a: 110,
                    b: 125,
                    c: 32
                },
                {
                    y: '2011',
                    a: 170,
                    b: 190,
                    c: 45
                },
                {
                    y: '2012',
                    a: 120,
                    b: 140,
                    c: 58
                },
                {
                    y: '2013',
                    a: 80,
                    b: 100,
                    c: 68
                },
                {
                    y: '2014',
                    a: 110,
                    b: 130,
                    c: 78
                },
                {
                    y: '2015',
                    a: 90,
                    b: 110,
                    c: 62
                },
                {
                    y: '2016',
                    a: 120,
                    b: 140,
                    c: 55
                },
                {
                    y: '2017',
                    a: 110,
                    b: 125,
                    c: 45
                },
                {
                    y: '2018',
                    a: 170,
                    b: 190,
                    c: 32
                },
                {
                    y: '2019',
                    a: 120,
                    b: 140,
                    c: 45
                },
                {
                    y: '2020',
                    a: 120,
                    b: 140,
                    c: 58
                }
            ],
            xkey: 'y',
            ykeys: ['a', 'b', 'c'],
            hideHover: 'auto',
            resize: true,
            labels: ['Product A', 'Product B', 'Product C']
        });
    }

    if ($("#morris-donut-example").length) {
        Morris.Donut({
            element: 'morris-donut-example',
            resize: true,
            backgroundColor: 'transparent',
            colors: ['#574bd6', '#6d61ea', '#877de8', '#9b94da', '#c5bff5'],
            data: [
                {
                    label: "Team A",
                    value: 12
                },
                {
                    label: "Team B",
                    value: 30
                },
                {
                    label: "Team C",
                    value: 20
                },
                {
                    label: "Team D",
                    value: 12
                },
                {
                    label: "Team E",
                    value: 28
                },
            ]
        });
    }
});
