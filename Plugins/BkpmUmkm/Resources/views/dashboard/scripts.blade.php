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

