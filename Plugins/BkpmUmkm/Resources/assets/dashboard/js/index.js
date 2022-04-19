/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */

$(document).ready(function () {
    $(document).on('change', 'select#filter_periode_data', function () {
        let self = $(this);
        window.location.href = self.val();
    });
    $(document).scroll(function () {
        let dataTableOnDashboard = $('table.dataTable', document);
        if (dataTableOnDashboard.length) {
            dataTableOnDashboard.remove();
        }
    });
    /* USAHA BESAR & UMKM */
    if ($('#company_umkm_pie').length) {
        Highcharts.chart('company_umkm_pie', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
            },
            title: {
                text: company_umkm_title
            },
            subtitle: {
                text: subtitle_periode_chart
            },
            credits: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Total: <b>{point.y}</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Total',
                colorByPoint: true,
                data: company_umkm_data
            }]
        });
    }
    if ($('#grafik_ub_bar').length) {
        Highcharts.chart('grafik_ub_bar', {
            chart: {
                type: 'column'
            },
            title: {
                text: ub_title
            },
            subtitle: {
                text: subtitle_periode_chart
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Total'
                }

            },
            credits: {
                enabled: false
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },
            tooltip: {
                /*headerFormat: '<span style="font-size:11px">{series.name}</span><br>',*/
                /*headerFormat: '<span style="font-size:11px">{point.name}</span><br>',*/
                pointFormat: 'Total: <b>{point.y}</b>'
            },

            series: [
                {
                    name: "Total",
                    colorByPoint: true,
                    data: ub_data
                }
            ]
        });
    }
    if ($('#grafik_ub_pie').length) {
        Highcharts.chart('grafik_ub_pie', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
            },
            title: {
                text: ub_title
            },
            subtitle: {
                text: subtitle_periode_chart
            },
            credits: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Total: <b>{point.y}</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Total',
                colorByPoint: true,
                data: ub_data
            }]
        });
    }
    if ($('#grafik_survey_ub_bar').length) {
        Highcharts.chart('grafik_survey_ub_bar', {
            chart: {
                type: 'column'
            },
            title: {
                text: survey_ub_title
            },
            subtitle: {
                text: subtitle_periode_chart
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Total'
                }

            },
            credits: {
                enabled: false
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },
            tooltip: {
                /*headerFormat: '<span style="font-size:11px">{series.name}</span><br>',*/
                /*headerFormat: '<span style="font-size:11px">{point.name}</span><br>',*/
                pointFormat: 'Total: <b>{point.y}</b>'
            },

            series: [
                {
                    name: "Total",
                    colorByPoint: true,
                    data: survey_ub_data
                }
            ]
        });
    }
    if ($('#company_umkm_bar').length) {
        Highcharts.chart('company_umkm_bar', {
            chart: {
                type: 'column'
            },
            title: {
                text: company_umkm_title
            },
            subtitle: {
                text: subtitle_periode_chart
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Total'
                }

            },
            credits: {
                enabled: false
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },
            tooltip: {
                pointFormat: 'Total: <b>{point.y}</b>'
            },

            series: [
                {
                    name: "Total",
                    colorByPoint: true,
                    data: company_umkm_data
                }
            ]
        });
    }

    /* UMKM HAS OR NOT NIB */
    if ($('#umkm_has_or_not_nib_bar').length) {
        Highcharts.chart('umkm_has_or_not_nib_bar', {
            chart: {
                type: 'column'
            },
            title: {
                text: umkm_has_or_not_nib_title
            },
            subtitle: {
                text: subtitle_periode_chart
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Total'
                }

            },
            credits: {
                enabled: false
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },
            tooltip: {
                /*headerFormat: '<span style="font-size:11px">{series.name}</span><br>',*/
                /*headerFormat: '<span style="font-size:11px">{point.name}</span><br>',*/
                pointFormat: 'Total: <b>{point.y}</b>'
            },

            series: [
                {
                    name: "Total",
                    colorByPoint: true,
                    data: umkm_has_or_not_nib_data
                }
            ]
        });
    }
    if ($('#umkm_has_or_not_nib_pie').length) {
        Highcharts.chart('umkm_has_or_not_nib_pie', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
            },
            title: {
                text: umkm_has_or_not_nib_title
            },
            subtitle: {
                text: subtitle_periode_chart
            },
            credits: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Total: <b>{point.y}</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Total',
                colorByPoint: true,
                data: umkm_has_or_not_nib_data
            }]
        });
    }

    /* SURVEY UMKM */
    if ($('#survey_umkm_pie').length) {
        Highcharts.chart('survey_umkm_pie', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
            },
            title: {
                text: survey_umkm_title
            },
            subtitle: {
                text: subtitle_periode_chart
            },
            credits: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Total: <b>{point.y}</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Total',
                colorByPoint: true,
                data: survey_umkm_data
            }]
        });
    }
    if ($('#survey_umkm_bar').length) {
        Highcharts.chart('survey_umkm_bar', {
            chart: {
                type: 'column'
            },
            title: {
                text: survey_umkm_title
            },
            subtitle: {
                text: subtitle_periode_chart
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Total'
                }
            },
            credits: {
                enabled: false
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },
            tooltip: {
                /*headerFormat: '<span style="font-size:11px">{series.name}</span><br>',*/
                /*headerFormat: '<span style="font-size:11px">{point.name}</span><br>',*/
                pointFormat: 'Total: <b>{point.y}</b>'
            },
            series: [
                {
                    name: "Total",
                    colorByPoint: true,
                    data: survey_umkm_data
                }
            ]
        });
    }

    if ($('#umkm_bersedia_menolak_tutup_pindah_bar').length) {
        Highcharts.chart('umkm_bersedia_menolak_tutup_pindah_bar', {
            chart: {
                type: 'column'
            },
            title: {
                text: umkm_bersedia_menolak_tutup_pindah_title
            },
            subtitle: {
                text: subtitle_periode_chart
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Total'
                }
            },
            credits: {
                enabled: false
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },
            tooltip: {
                /*headerFormat: '<span style="font-size:11px">{series.name}</span><br>',*/
                /*headerFormat: '<span style="font-size:11px">{point.name}</span><br>',*/
                pointFormat: 'Total: <b>{point.y}</b>'
            },
            series: [
                {
                    name: "Total",
                    colorByPoint: true,
                    data: umkm_bersedia_menolak_tutup_pindah_data
                }
            ]
        });
    }
    if ($('#umkm_bersedia_menolak_tutup_pindah_pie').length) {
        Highcharts.chart('umkm_bersedia_menolak_tutup_pindah_pie', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
            },
            title: {
                text: umkm_bersedia_menolak_tutup_pindah_title
            },
            subtitle: {
                text: subtitle_periode_chart
            },
            credits: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Total: <b>{point.y}</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Total',
                colorByPoint: true,
                data: umkm_bersedia_menolak_tutup_pindah_data
            }]
        });
    }

    /* KEMITRAAN PMDN / PMA & UMKM */
    if ($('#kemitraan_ub_umkm_bar').length) {
        Highcharts.chart('kemitraan_ub_umkm_bar', {
            chart: {
                type: 'column'
            },
            title: {
                text: kemitraan_ub_umkm_title
            },
            subtitle: {
                text: subtitle_periode_chart
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Total'
                }

            },
            credits: {
                enabled: false
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },
            tooltip: {
                pointFormat: 'Total: <b>{point.y}</b>'
            },

            series: [
                {
                    name: "Total",
                    colorByPoint: true,
                    data: kemitraan_ub_umkm_data
                }
            ]
        });
    }
    if ($('#kemitraan_ub_umkm_pie').length) {
        Highcharts.chart('kemitraan_ub_umkm_pie', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
            },
            title: {
                text: kemitraan_ub_umkm_title
            },
            subtitle: {
                text: subtitle_periode_chart
            },
            credits: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Total: <b>{point.y}</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Total',
                colorByPoint: true,
                data: kemitraan_ub_umkm_data
            }]
        });
    }

    /* PMDN / PMA Berdasarkan Wilayah */
    if ($('#ub_by_wilayah_bar').length) {
        Highcharts.chart('ub_by_wilayah_bar', {
            chart: {
                type: 'column'
            },
            title: {
                text: ub_by_wilayah_title
            },
            subtitle: {
                text: subtitle_periode_chart
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Total'
                }

            },
            credits: {
                enabled: false
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },
            tooltip: {
                pointFormat: 'Total: <b>{point.y}</b>'
            },

            series: [
                {
                    name: "Total",
                    colorByPoint: true,
                    data: ub_by_wilayah_data
                }
            ]
        });
    }
    if ($('#ub_by_wilayah_pie').length) {
        Highcharts.chart('ub_by_wilayah_pie', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
            },
            title: {
                text: ub_by_wilayah_title
            },
            subtitle: {
                text: subtitle_periode_chart
            },
            credits: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Total: <b>{point.y}</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Total',
                colorByPoint: true,
                data: ub_by_wilayah_data
            }]
        });
    }

    /* PMDN / PMA Berdasarkan Respon */
    if ($('#ub_by_respon_bar').length) {
        Highcharts.chart('ub_by_respon_bar', {
            chart: {
                type: 'column'
            },
            title: {
                text: ub_by_respon_title
            },
            subtitle: {
                text: subtitle_periode_chart
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Total'
                }

            },
            credits: {
                enabled: false
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },
            tooltip: {
                pointFormat: 'Total: <b>{point.y}</b>'
            },

            series: [
                {
                    name: "Total",
                    colorByPoint: true,
                    data: ub_by_respon_data
                }
            ]
        });
    }
    if ($('#ub_by_respon_pie').length) {
        Highcharts.chart('ub_by_respon_pie', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
            },
            title: {
                text: ub_by_respon_title
            },
            subtitle: {
                text: subtitle_periode_chart
            },
            credits: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Total: <b>{point.y}</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Total',
                colorByPoint: true,
                data: ub_by_respon_data
            }]
        });
    }

    /* PMDN / PMA Berdasarkan Meeting */
    if ($('#ub_by_meeting_bar').length) {
        Highcharts.chart('ub_by_meeting_bar', {
            chart: {
                type: 'column'
            },
            title: {
                text: ub_by_meeting_title
            },
            subtitle: {
                text: subtitle_periode_chart
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Total'
                }

            },
            credits: {
                enabled: false
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },
            tooltip: {
                pointFormat: 'Total: <b>{point.y}</b>'
            },

            series: [
                {
                    name: "Total",
                    colorByPoint: true,
                    data: ub_by_meeting_data
                }
            ]
        });
    }
    if ($('#ub_by_meeting_pie').length) {
        Highcharts.chart('ub_by_meeting_pie', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
            },
            title: {
                text: ub_by_meeting_title
            },
            subtitle: {
                text: subtitle_periode_chart
            },
            credits: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Total: <b>{point.y}</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Total',
                colorByPoint: true,
                data: ub_by_meeting_data
            }]
        });
    }
});
