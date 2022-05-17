<script>
    const subtitle_periode_chart = '@lang('label.subtitle_periode_chart'): {{ $year }}',
        ub_title = '@lang('label.grafik_ub')',
        ub_data = [
            {name: "@lang('label.company_status_bersedia')", y: {{ (int)$count_ub_bersedia }} },
            {name: "@lang('label.company_status_tidak_bersedia')", y: {{ (int)$count_ub_tidak_bersedia }} },
            {name: "@lang('label.company_status_tidak_respon')", y: {{ (int)$count_ub_tidak_respon }} },
        ],
        survey_ub_title = '@lang('label.grafik_survey_ub')',
        survey_ub_data = [
            {name: "@lang('label.survey_status_belum_survey')", y: {{ (int)$countSurveyUB_belum_survey }} },
            {name: "@lang('label.survey_status_progress')", y: {{ (int)$countSurveyUB_progress }} },
            {name: "@lang('label.survey_status_done')", y: {{ (int)$countSurveyUB_done }} },
            {name: "@lang('label.survey_status_verified')", y: {{ (int)$countSurveyUB_verified }} },
            {name: "@lang('label.survey_status_revision')", y: {{ (int)$countSurveyUB_revision }} }
        ],
        company_umkm_title = "{{ trans('label.index_company') }} & {{ trans('label.index_umkm') }}",
        company_umkm_data = [
            {name: "{{ trans('label.index_company') }}", y: {{ (int)$countUB }} },
            {name: "{{ trans('label.index_umkm_potensial') }}", y: {{ (int)$countUMKMPotensial }} }
        ],
        survey_umkm_title = "{{ trans('label.survey_umkm') }}",
        survey_umkm_data = [
            @if(!in_array(auth()->user()->group_id, [GROUP_SURVEYOR]))
	            {name: "{{ trans('label.umkm_potensial_belum_disurvey') }}", y: {{ (int)$countUMKMPotensialBelumDisurvey }} },
            @endif
            {name: "{{ trans('label.survey_status_progress') }}", y: {{ (int)$countSurveyUMKMProgress }} },
            {name: "{{ trans('label.survey_status_done') }}", y: {{ (int)$countSurveyUMKMDone }} },
            {name: "{{ trans('label.survey_status_verified') }}", y: {{ (int)$countSurveyUMKMVerified }} }
        ],
        umkm_bersedia_menolak_tutup_pindah_title = "{{ trans('label.umkm_bersedia_menolak_tutup_pindah') }}",
        umkm_bersedia_menolak_tutup_pindah_data = [
            {name: "{{ trans('label.survey_umkm_status_bersedia') }}", y: {{ (int)$countUMKMBermitra }} },
            {name: "{{ trans('label.survey_umkm_status_menolak') }}", y: {{ (int)$countUMKMBelumBermitra }} }
        ],
        umkm_has_or_not_nib_title = "@lang('label.umkm_has_or_not_nib')",
        umkm_has_or_not_nib_data = [
            {name: "{{ trans('label.umkm_has_nib') }}", y: {{ (int)$countUMKMHasNIB }} },
            {name: "{{ trans('label.umkm_not_nib') }}", y: {{ (int)$countUMKMNotNIB }} }
        ],
        kemitraan_ub_umkm_title = "@lang('label.kemitraan_ub_umkm')",
        kemitraan_ub_umkm_data = [
            {name: "{{ trans('label.kemitraan_ub_pmdn') }}", y: {{ (int)$countKemitraanUB_PMDN }} },
            {name: "{{ trans('label.kemitraan_ub_pma') }}", y: {{ (int)$countKemitraanUB_PMA }} },
            {name: "{{ trans('label.kemitraan_umkm') }}", y: {{ (int)$countKemitraanUMKM }} }
        ],
        ub_by_wilayah_title = "PMA/PMDN Yang Potensi Kontrak",
        ub_by_wilayah_data = [
            {name: "{{ trans('label.wilayah_1') }}", y: {{ (int)$countUBWilayah1 }} },
            {name: "{{ trans('label.wilayah_2') }}", y: {{ (int)$countUBWilayah2 }} },
            {name: "{{ trans('label.wilayah_3') }}", y: {{ (int)$countUBWilayah3 }} },
            {name: "{{ trans('label.wilayah_4') }}", y: {{ (int)$countUBWilayah4 }} }
        ],
        ub_by_wilayah1_title = "PMA/PMDN Yang Potensi Kontrak",
        ub_by_wilayah1_data = [
            {name: "Aceh", y: {{ (int)$countUB11 }} },
            {name: "Sumatera Utara", y: {{ (int)$countUB12 }} },
            {name: "Sumatera Barat", y: {{ (int)$countUB13 }} },
            {name: "Riau", y: {{ (int)$countUB14 }} },
            {name: "Jambi", y: {{ (int)$countUB15 }} },
            {name: "Sumatera Selatan", y: {{ (int)$countUB16 }} },
            {name: "Bengkulu", y: {{ (int)$countUB17 }} },
            {name: "Lampung", y: {{ (int)$countUB18 }} },
            {name: "Kepulauan Bangka Belitung", y: {{ (int)$countUB19 }} },
            {name: "Kepulauan Riau", y: {{ (int)$countUB21 }} }
        ],

        ub_by_wilayah2_title = "PMA/PMDN Yang Potensi Kontrak",
        ub_by_wilayah2_data = [
            {name: "DKI Jakarta", y: {{ (int)$countUB31 }} },
            {name: "Yogyakarta", y: {{ (int)$countUB34 }} },
            {name: "Kalimantan Barat", y: {{ (int)$countUB61 }} },
            {name: "Kalimantan Tengah", y: {{ (int)$countUB62 }} },
            {name: "Kalimantan Selatan", y: {{ (int)$countUB63 }} },
            {name: "Kalimantan Timur", y: {{ (int)$countUB64 }} },
            {name: "Kalimantan Utara", y: {{ (int)$countUB65 }} }
        ],
        ub_by_wilayah3_title = "PMA/PMDN Yang Potensi Kontrak",
        ub_by_wilayah3_data = [
            {name: "Jawa Barat", y: {{ (int)$countUB32 }} },
            {name: "Jawa Tengah", y: {{ (int)$countUB33 }} },
            {name: "Banten", y: {{ (int)$countUB36 }} },
            {name: "Sulawesi Utara", y: {{ (int)$countUB71 }} },
            {name: "Sulawesi Tengah", y: {{ (int)$countUB72 }} },
            {name: "Sulawesi Selatan", y: {{ (int)$countUB73 }} },
            {name: "Sulawesi Tenggara", y: {{ (int)$countUB74 }} },
            {name: "Gorontalo", y: {{ (int)$countUB75 }} },
            {name: "Sulawesi Barat", y: {{ (int)$countUB76 }} }
        ],
        ub_by_wilayah4_title = "PMA/PMDN Yang Potensi Kontrak",
        ub_by_wilayah4_data = [
            {name: "Jawa Timur", y: {{ (int)$countUB35 }} },
            {name: "Bali", y: {{ (int)$countUB51 }} },
            {name: "Nusa Tenggara Barat", y: {{ (int)$countUB52 }} },
            {name: "Nusa Tenggara Timur", y: {{ (int)$countUB53 }} },
            {name: "Maluku", y: {{ (int)$countUB81 }} },
            {name: "Maluku Utara", y: {{ (int)$countUB82 }} },
            {name: "Papua", y: {{ (int)$countUB91 }} },
            {name: "Papua Barat", y: {{ (int)$countUB92 }} }
        ],
        ub_by_responed_title = "Perusahaan Yang Sudah Dihubungi",
        ub_by_responed_data = [
            {name: "Total Perusahaan", y: {{ (int)$countUB }} },
            {name: "Sudah Dihubungi", y: {{ (int)$countResponed }} },
        ],
        ub_by_respon_title = "Perusahaan Berdasarkan Respon",
        ub_by_respon_data = [            
            {name: "Respon", y: {{ (int)$countRespon }} },
            {name: "Tidak Respon", y: {{ (int)$countTdkRespon }} },
            {name: "Tidak Aktif", y: {{ (int)$countTdkAktif }} }
        ],
        ub_by_meeting_title = "Perusahaan Berdasarkan Kelanjutan Komunikasi",
        ub_by_meeting_data = [            
            {name: "Belum Terjadwal", y: {{ (int)$countBlmJadwal }} },
            {name: "Online Meeting", y: {{ (int)$countZoom }} },
            {name: "Offline Meeting", y: {{ (int)$countOffline }} }
        ];
    $(document).find('.modal').on('hidden.bs.modal',function (e) {
        e.preventDefault();
        $('.modal-title').html('');
        $('.modal-load-body').html('');
    });
</script>

<script>
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
        $(document).on('change', 'select#filter_wilayah_data', function () {
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

        /* PMDN / PMA Berdasarkan Per Wilayah */
        if ($('#ub_by_wilayah1_bar').length) {
            Highcharts.chart('ub_by_wilayah1_bar', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ub_by_wilayah1_title
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
                        data: ub_by_wilayah1_data
                    }
                ]
            });
        }
        if ($('#ub_by_wilayah1_pie').length) {
            Highcharts.chart('ub_by_wilayah1_pie', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie',
                },
                title: {
                    text: ub_by_wilayah1_title
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
                    data: ub_by_wilayah1_data
                }]
            });
        }

        if ($('#ub_by_wilayah2_bar').length) {
            Highcharts.chart('ub_by_wilayah2_bar', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ub_by_wilayah2_title
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
                        data: ub_by_wilayah2_data
                    }
                ]
            });
        }
        if ($('#ub_by_wilayah2_pie').length) {
            Highcharts.chart('ub_by_wilayah2_pie', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie',
                },
                title: {
                    text: ub_by_wilayah2_title
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
                    data: ub_by_wilayah2_data
                }]
            });
        }
        
        if ($('#ub_by_wilayah3_bar').length) {
            Highcharts.chart('ub_by_wilayah3_bar', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ub_by_wilayah3_title
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
                        data: ub_by_wilayah3_data
                    }
                ]
            });
        }
        if ($('#ub_by_wilayah3_pie').length) {
            Highcharts.chart('ub_by_wilayah3_pie', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie',
                },
                title: {
                    text: ub_by_wilayah3_title
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
                    data: ub_by_wilayah3_data
                }]
            });
        }

        if ($('#ub_by_wilayah4_bar').length) {
            Highcharts.chart('ub_by_wilayah4_bar', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ub_by_wilayah4_title
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
                        data: ub_by_wilayah4_data
                    }
                ]
            });
        }
        if ($('#ub_by_wilayah4_pie').length) {
            Highcharts.chart('ub_by_wilayah4_pie', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie',
                },
                title: {
                    text: ub_by_wilayah4_title
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
                    data: ub_by_wilayah4_data
                }]
            });
        }

        /* PMDN / PMA Berdasarkan Respon */
        if ($('#ub_by_responed_bar').length) {
            Highcharts.chart('ub_by_responed_bar', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ub_by_responed_title
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
                        data: ub_by_responed_data
                    }
                ]
            });
        }
        if ($('#ub_by_responed_pie').length) {
            Highcharts.chart('ub_by_responed_pie', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie',
                },
                title: {
                    text: ub_by_responed_title
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
                    data: ub_by_responed_data
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
</script>
