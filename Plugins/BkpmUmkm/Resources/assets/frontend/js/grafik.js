/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * Website : https://whendy.net
 * LinkedIn : https://www.linkedin.com/in/ahmad-windi-wijayanto/
 * --------- 9/29/21, 10:29 AM ---------
 */

$(document).ready(function () {
    let chartUbUmkm = Highcharts.chart('chartUbUmkm', {
        chart: {
            plotShadow: false,
            type: 'pie',
        },
        title: {
            text: ''
        },
        credits: {
            enabled: false
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y}'
                },
                showInLegend: true,
            },
        },
        series: [{

            name: 'Jumlah',
            colorByPoint: true,
            data: [],
        }]
    }),
        chartSurveyUmkmBersediaMenolak = Highcharts.chart('chartSurveyUmkmBersediaMenolak', {
            chart: {
                plotShadow: false,
                type: 'pie',
            },
            title: {
                text: ''
            },
            credits: {
                enabled: false
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y}</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.y}'
                    },
                    showInLegend: true,
                },
            },
            series: [{
                name: 'Jumlah',
                colorByPoint: true,
                data: [],
            }]
        });

    loadDataGrafikFrontend();
    $(document).on('change', 'select#periodeGrafik[name="periode_grafik"]', function () {
        loadDataGrafikFrontend();
    });
    function loadDataGrafikFrontend() {
        let periode = $('select#periodeGrafik', document).val(),
            params = {
            'periode' : periode
        };
        $.ajax({
            url:urlLoadDataGrafikFrontend, type:'POST', typeData:'json',  cache:false, data: params,
            success: function(data){
                let chart_ub_umkm = data.body.chart_ub_umkm,
                    chart_survey_umkm_bersedia_menolak = data.body.chart_survey_umkm_bersedia_menolak;
                chart_ub_umkm = (typeof chart_ub_umkm === "string" ? JSON.parse(chart_ub_umkm) : chart_ub_umkm);
                chart_survey_umkm_bersedia_menolak = (typeof chart_survey_umkm_bersedia_menolak === "string" ? JSON.parse(chart_survey_umkm_bersedia_menolak) : chart_survey_umkm_bersedia_menolak);
                chartUbUmkm.series[0].setData(chart_ub_umkm);
                chartSurveyUmkmBersediaMenolak.series[0].setData(chart_survey_umkm_bersedia_menolak);
            }
        });
    }
});
