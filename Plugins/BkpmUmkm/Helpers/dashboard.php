<?php
/**
 *
 * Created By : Whendy
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 03 June 2020 14.13 ---------
 */

if ( ! function_exists('dashboard_bkpm_umkm') )
{
    function dashboard_bkpm_umkm()
    {
        $request = request();
        $year = $request->get('periode', \Carbon\Carbon::now()->format('Y'));
        $config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $identifier = $config['identifier'];
        $user = auth()->user();
        $bkpmumkm_wilayah = bkpmumkm_wilayah($user->id_provinsi);
        $params = [
            'countUB'                   => 0,
            'count_ub_not_set'          => 0,
            'count_ub_bersedia'         => 0,
            'count_ub_tidak_bersedia'   => 0,
            'count_ub_tidak_respon'     => 0,
            'count_ub_konsultasi_bkpm'  => 0,
            'count_ub_menunggu_konfirmasi' => 0,

            'count_total_potensi_nilai_all' => 0,
            'count_total_realisasi_nilai_kontrak' => 0,

            'countUMKMPotensial'        => 0,
            'countUMKMPotensialBelumDisurvey' => 0,

            'countSurveyUB_belum_survey'  => 0,
            'countSurveyUB_progress'   => 0,
            'countSurveyUB_done'       => 0,
            'countSurveyUB_verified'   => 0,
            'countSurveyUB_revision'   => 0,

            'countSurveyUMKMProgress'   => 0,
            'countSurveyUMKMDone'       => 0,
            'countSurveyUMKMVerified'   => 0,
            'countSurveyUMKMBersedia'   => 0,
            'countSurveyUMKMMenolak'    => 0,
            'countSurveyUMKMTutup'      => 0,
            'countSurveyUMKMPindah'     => 0,

            'countUMKMHasNIB'           => 0,
            'countUMKMNotNIB'           => 0,

            'countKemitraanUB'          => 0,
            'countKemitraanUMKM'        => 0,
            'countKemitraanUB_PMA'      => 0,
            'countKemitraanUB_PMDN'     => 0,

            'countUBWilayah1'           => 0,
            'countUBWilayah2'           => 0,
            'countUBWilayah3'           => 0,
            'countUBWilayah4'           => 0,

            'countRespon'               => 0,
            'countTdkRespon'            => 0,
            'countTdkAktif'             => 0
        ];
        $params['user'] = $user;
        $params['identifier'] = $identifier;

        $ub = \Plugins\BkpmUmkm\Models\CompanyModel::where('companies.category', CATEGORY_COMPANY)
            ->whereHas('company_status', function($q) use($year){
                $q->whereYear('companies_status.created_at', $year);
            });

        $kemitraan_ub          = \Plugins\BkpmUmkm\Models\KemitraanModel::whereYear('created_at', $year)->distinct('company_id');
        $kemitraan_umkm        = \Plugins\BkpmUmkm\Models\KemitraanModel::whereYear('created_at', $year);        
        $umkm_bermitra         = DB::select("SELECT * from kemitraan WHERE year(created_at)=?", [$year]);
        $idUmkmBermitra = [];
        foreach($umkm_bermitra as $v){
            $idUmkmBermitra[]=$v->umkm_id;
        }        
        $count_umkm_bersedia = DB::select("SELECT surveys.* FROM `surveys` join companies on surveys.company_id=companies.id where year(surveys.created_at)=? and surveys.status in ('bersedia','tutup','menolak','pindah') and companies.category='umkm'", [$year]);
        $umkm_belum_bermitra = count($count_umkm_bersedia) - count($umkm_bermitra);
        
        $ub_not_set            = \Plugins\BkpmUmkm\Models\CompanyModel::where('companies.category', CATEGORY_COMPANY)
            ->whereHas('company_status', function($q) use($year){
                $q->whereYear('companies_status.created_at', $year)->where(function($q){
                    $q->whereNull('companies_status.status')->orWhere('companies_status.status', '');
                });
            });
        $ub_bersedia            = \Plugins\BkpmUmkm\Models\CompanyModel::where('companies.category', CATEGORY_COMPANY)
            ->whereHas('company_status', function($q) use($year){
                $q->whereYear('companies_status.created_at', $year)->whereStatus('bersedia');
            });
        $ub_tidak_bersedia      = \Plugins\BkpmUmkm\Models\CompanyModel::where('companies.category', CATEGORY_COMPANY)
            ->whereHas('company_status', function($q) use($year){
                $q->whereYear('companies_status.created_at', $year)->whereStatus('tidak_bersedia');
            });
        $ub_tidak_respon        = \Plugins\BkpmUmkm\Models\CompanyModel::where('companies.category', CATEGORY_COMPANY)
            ->whereHas('company_status', function($q) use($year){
                $q->whereYear('companies_status.created_at', $year)->whereStatus('tidak_respon');
            });
        $ub_konsultasi_bkpm     = \Plugins\BkpmUmkm\Models\CompanyModel::where('companies.category', CATEGORY_COMPANY)
            ->whereHas('company_status', function($q) use($year){
                $q->whereYear('companies_status.created_at', $year)->whereStatus('konsultasi_bkpm');
            });
        $ub_menunggu_konfirmasi = \Plugins\BkpmUmkm\Models\CompanyModel::where('companies.category', CATEGORY_COMPANY)
            ->whereHas('company_status', function($q) use($year){
                $q->whereYear('companies_status.created_at', $year)->whereStatus('menunggu_konfirmasi');
            });

        /* UB */
        $survey_ub_belum_survey   = \Plugins\BkpmUmkm\Models\SurveyModel::whereYear('surveys.created_at', $year)->doesntHave('survey_result');//->whereNotIn('surveys.status', ['done','progress','revision','verified']);
        $survey_ub_progress   = \Plugins\BkpmUmkm\Models\SurveyModel::whereYear('surveys.created_at', $year)->where('surveys.status', 'progress');
        $survey_ub_done   = \Plugins\BkpmUmkm\Models\SurveyModel::whereYear('surveys.created_at', $year)->where('surveys.status', 'done');
        $survey_ub_verified   = \Plugins\BkpmUmkm\Models\SurveyModel::whereYear('surveys.created_at', $year)->where('surveys.status', 'verified');
        $survey_ub_revision   = \Plugins\BkpmUmkm\Models\SurveyModel::whereYear('surveys.created_at', $year)->where('surveys.status', 'revision');

        /* UMKM */
        $survey_umkm_belum_disurvey   = \Plugins\BkpmUmkm\Models\SurveyModel::whereYear('surveys.created_at', $year)->whereNotIn('surveys.status', ['done','progress','revision','verified', 'bersedia', 'menolak', 'tutup', 'pindah']);
        $survey_umkm_progress   = \Plugins\BkpmUmkm\Models\SurveyModel::whereYear('surveys.created_at', $year)->where('surveys.status', 'progress');
        $survey_umkm_done       = \Plugins\BkpmUmkm\Models\SurveyModel::whereYear('surveys.created_at', $year)->where('surveys.status', 'done');
        $survey_umkm_verified   = \Plugins\BkpmUmkm\Models\SurveyModel::whereYear('surveys.created_at', $year)->where('surveys.status', 'verified'); //['bersedia', 'menolak', 'tutup', 'pindah', 'verified']);
        $survey_umkm_bersedia   = \Plugins\BkpmUmkm\Models\SurveyModel::whereYear('surveys.created_at', $year)->where('surveys.status', 'bersedia');
        $survey_umkm_menolak    = \Plugins\BkpmUmkm\Models\SurveyModel::whereYear('surveys.created_at', $year)->where('surveys.status', 'menolak');
        $survey_umkm_tutup      = \Plugins\BkpmUmkm\Models\SurveyModel::whereYear('surveys.created_at', $year)->where('surveys.status', 'tutup');
        $survey_umkm_pindah     = \Plugins\BkpmUmkm\Models\SurveyModel::whereYear('surveys.created_at', $year)->where('surveys.status', 'pindah');

        /* RESPON */
        $ub_responed       = \Plugins\BkpmUmkm\Models\CompanyModel::whereYear('companies.created_at', $year)->whereIn('companies.flag_respon', [1,2]);
        $ub_respon       = \Plugins\BkpmUmkm\Models\CompanyModel::whereYear('companies.created_at', $year)->where('companies.flag_respon', 1);
        $ub_tdk_respon   = \Plugins\BkpmUmkm\Models\CompanyModel::whereYear('companies.created_at', $year)->where('companies.flag_respon', 2);
        $ub_tdk_aktif    = \Plugins\BkpmUmkm\Models\CompanyModel::whereYear('companies.created_at', $year)->where('companies.flag_respon', 3);

        /* MEETING */
        $ub_blm_jadwal   = \Plugins\BkpmUmkm\Models\CompanyModel::whereYear('companies.created_at', $year)->where('companies.flag_respon', 1)->where('companies.flag_zoom', '<', 1);
        $ub_zoom   = \Plugins\BkpmUmkm\Models\CompanyModel::whereYear('companies.created_at', $year)->where('companies.flag_respon', 1)->where('companies.flag_zoom', 1);
        $ub_offline   = \Plugins\BkpmUmkm\Models\CompanyModel::whereYear('companies.created_at', $year)->where('companies.flag_respon', 1)->where('companies.flag_zoom', 2);

        $umkm_has_nib = \Plugins\BkpmUmkm\Models\CompanyModel::where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL)->where('companies.nib', '<>', '')->whereHas('survey', function ($q) use($year){
            $q->whereYear('surveys.created_at', $year);
        });
        $umkm_not_nib = \Plugins\BkpmUmkm\Models\CompanyModel::where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL)->where('companies.nib', '=', '')->whereHas('survey', function ($q) use($year){
            $q->whereYear('surveys.created_at', $year);
        });

        switch ($user->group_id){
            case GROUP_SURVEYOR:
                $params['countUMKMPotensialBelumDisurvey']  = $survey_umkm_belum_disurvey->whereHas('umkm', function ($q){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL);
                })->where('surveys.surveyor_id', $user->id)->count();
                $params['countSurveyUMKMProgress']  = $survey_umkm_progress->whereHas('umkm', function ($q){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL);
                })->where('surveys.surveyor_id', $user->id)->count();
                $params['countSurveyUMKMDone']      = $survey_umkm_done->whereHas('umkm', function ($q){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL);
                })->where('surveys.surveyor_id', $user->id)->count();
                $params['countSurveyUMKMVerified']  = $survey_umkm_verified->whereHas('umkm', function ($q){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL);
                })->where('surveys.surveyor_id', $user->id)->count();
                $params['countSurveyUMKMBersedia']  = $survey_umkm_bersedia->whereHas('umkm', function ($q){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL);
                })->where('surveys.surveyor_id', $user->id)->count();
                $params['countSurveyUMKMMenolak']  = $survey_umkm_menolak->whereHas('umkm', function ($q){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL);
                })->where('surveys.surveyor_id', $user->id)->count();
                $params['countSurveyUMKMTutup']  = $survey_umkm_tutup->whereHas('umkm', function ($q){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL);
                })->where('surveys.surveyor_id', $user->id)->count();
                $params['countSurveyUMKMPindah']  = $survey_umkm_pindah->whereHas('umkm', function ($q){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL);
                })->where('surveys.surveyor_id', $user->id)->count();
                break;
                
            case GROUP_QC_KORPROV:
                $ub->where('id_provinsi', $user->id_provinsi);

                $params['countUB'] = $ub->count();

                $params['countUMKMPotensial'] = \Plugins\BkpmUmkm\Models\CompanyModel::where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL)
                    ->where('companies.id_provinsi', $user->id_provinsi)
                    ->whereHas('survey', function ($q) use($year){
                        $q->whereYear('surveys.created_at', $year);
                    })->count();

                $params['countUMKMPotensialBelumDisurvey']  = $survey_umkm_belum_disurvey->whereHas('umkm', function ($q) use($user){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL)
                        ->where('companies.id_provinsi', $user->id_provinsi);
                })->count();
                $params['countSurveyUMKMProgress']  = $survey_umkm_progress->whereHas('umkm', function($q) use($user){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL)
                        ->where('companies.id_provinsi', $user->id_provinsi);
                })->count();
                $params['countSurveyUMKMDone']      = $survey_umkm_done->whereHas('umkm', function($q) use($user){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL)
                        ->where('companies.id_provinsi', $user->id_provinsi);
                })->count();
                $params['countSurveyUMKMVerified']  = $survey_umkm_verified->whereHas('umkm', function($q) use($user){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL)
                        ->where('companies.id_provinsi', $user->id_provinsi);
                })->count();
                $params['countSurveyUMKMBersedia']  = $survey_umkm_bersedia->whereHas('umkm', function($q) use($user){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL)
                        ->where('companies.id_provinsi', $user->id_provinsi);
                })->count();
                $params['countSurveyUMKMMenolak']  = $survey_umkm_menolak->whereHas('umkm', function($q) use($user){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL)
                        ->where('companies.id_provinsi', $user->id_provinsi);
                })->count();
                $params['countSurveyUMKMTutup']  = $survey_umkm_tutup->whereHas('umkm', function($q) use($user){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL)
                        ->where('companies.id_provinsi', $user->id_provinsi);
                })->count();
                $params['countSurveyUMKMPindah']  = $survey_umkm_pindah->whereHas('umkm', function($q) use($user){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL)
                        ->where('companies.id_provinsi', $user->id_provinsi);
                })->count();

                $params['countUMKMHasNIB'] = $umkm_has_nib->where('companies.id_provinsi', $user->id_provinsi)->count();
                $params['countUMKMNotNIB'] = $umkm_not_nib->where('companies.id_provinsi', $user->id_provinsi)->count();
                break;
            case GROUP_QC_KORWIL:
            case GROUP_ASS_KORWIL:
            case GROUP_TA:
                $ub->whereIn('id_provinsi', $bkpmumkm_wilayah['provinces']);
                $params['countUB'] = $ub->count();

                $params['count_ub_not_set'] = $ub_not_set->whereIn('id_provinsi', $bkpmumkm_wilayah['provinces'])->count();
                $params['count_ub_bersedia'] = $ub_bersedia->whereIn('id_provinsi', $bkpmumkm_wilayah['provinces'])->count();
                $params['count_ub_tidak_bersedia'] = $ub_tidak_bersedia->whereIn('id_provinsi', $bkpmumkm_wilayah['provinces'])->count();
                $params['count_ub_tidak_respon'] = $ub_tidak_respon->whereIn('id_provinsi', $bkpmumkm_wilayah['provinces'])->count();
                $params['count_ub_konsultasi_bkpm'] = $ub_konsultasi_bkpm->whereIn('id_provinsi', $bkpmumkm_wilayah['provinces'])->count();
                $params['count_ub_menunggu_konfirmasi'] = $ub_menunggu_konfirmasi->whereIn('id_provinsi', $bkpmumkm_wilayah['provinces'])->count();

                $params['countSurveyUB_belum_survey']   = $survey_ub_belum_survey->whereHas('company', function ($q) use($bkpmumkm_wilayah){
                    $q->where('companies.category', CATEGORY_COMPANY)->whereIn('companies.id_provinsi', $bkpmumkm_wilayah['provinces']);
                })->count();
                $params['countSurveyUB_progress']       = $survey_ub_progress->whereHas('company', function ($q) use($bkpmumkm_wilayah){
                    $q->where('companies.category', CATEGORY_COMPANY)->whereIn('companies.id_provinsi', $bkpmumkm_wilayah['provinces']);
                })->count();
                $params['countSurveyUB_done']           = $survey_ub_done->whereHas('company', function ($q) use($bkpmumkm_wilayah){
                    $q->where('companies.category', CATEGORY_COMPANY)->whereIn('companies.id_provinsi', $bkpmumkm_wilayah['provinces']);
                })->count();
                $params['countSurveyUB_verified']       = $survey_ub_verified->whereHas('company', function ($q) use($bkpmumkm_wilayah){
                    $q->where('companies.category', CATEGORY_COMPANY)->whereIn('companies.id_provinsi', $bkpmumkm_wilayah['provinces']);
                })->count();
                $params['countSurveyUB_revision']       = $survey_ub_revision->whereHas('company', function ($q) use($bkpmumkm_wilayah){
                    $q->where('companies.category', CATEGORY_COMPANY)->whereIn('companies.id_provinsi', $bkpmumkm_wilayah['provinces']);
                })->count();

                // selectRaw('SUM(jsonget_int(REPLACE(REPLACE(JSON_EXTRACT(survey_results.data, "$.kebutuhan_kemitraan.*.total_potensi_nilai"), \',\', \'\'), \'" "\',\'","\'), \'[+]\')) AS total_potensi_nilai_all')->
                $ub_total_potensi_nilai_all = \Plugins\BkpmUmkm\Models\SurveyResultModel::whereHas('survey', function($q) use($year, $bkpmumkm_wilayah){
                    $q->whereHas('company', function ($q) use($bkpmumkm_wilayah){
                        $q->where('companies.category', CATEGORY_COMPANY)->whereIn('companies.id_provinsi', $bkpmumkm_wilayah['provinces']);
                    })->where(function($q) use($year){
                        $q->whereYear('surveys.created_at', $year)->where('surveys.status', 'verified');
                    });
                })->get();

                foreach ($ub_total_potensi_nilai_all as $ub_total_nilai) {
                    if($ub_total_nilai->data&&isset($ub_total_nilai->data['kebutuhan_kemitraan'])){
                        foreach ($ub_total_nilai->data['kebutuhan_kemitraan'] as $datum) {
                            $params['count_total_potensi_nilai_all'] += (int)str_replace(',', '', $datum['total_potensi_nilai']);
                        }
                    }
                }

                /*$params['countUMKMPotensial'] = $umkm_potensial->whereHas('umkm', function ($q) use($bkpmumkm_wilayah){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL)
                        ->whereIn('companies.id_provinsi', $bkpmumkm_wilayah['provinces']);
                })->count();*/
                $params['countUMKMPotensial'] = \Plugins\BkpmUmkm\Models\CompanyModel::where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL)
                    ->whereIn('companies.id_provinsi', $bkpmumkm_wilayah['provinces'])
                    ->whereHas('survey', function ($q) use($year){
                        $q->whereYear('surveys.created_at', $year);
                    })->count();

                $params['countUMKMPotensialBelumDisurvey']  = $survey_umkm_belum_disurvey->whereHas('umkm', function ($q) use($bkpmumkm_wilayah){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL)
                        ->whereIn('companies.id_provinsi', $bkpmumkm_wilayah['provinces']);
                })->count();
                $params['countSurveyUMKMProgress']  = $survey_umkm_progress->whereHas('umkm', function($q) use($bkpmumkm_wilayah){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL)
                        ->whereIn('companies.id_provinsi', $bkpmumkm_wilayah['provinces']);
                })->count();
                $params['countSurveyUMKMDone']      = $survey_umkm_done->whereHas('umkm', function($q) use($bkpmumkm_wilayah){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL)
                        ->whereIn('companies.id_provinsi', $bkpmumkm_wilayah['provinces']);
                })->count();
                $params['countSurveyUMKMVerified']  = $survey_umkm_verified->whereHas('umkm', function($q) use($bkpmumkm_wilayah){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL)
                        ->whereIn('companies.id_provinsi', $bkpmumkm_wilayah['provinces']);
                })->count();
                $params['countSurveyUMKMBersedia']  = $survey_umkm_bersedia->whereHas('umkm', function($q) use($bkpmumkm_wilayah){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL)
                        ->whereIn('companies.id_provinsi', $bkpmumkm_wilayah['provinces']);
                })->count();
                $params['countSurveyUMKMMenolak']  = $survey_umkm_menolak->whereHas('umkm', function($q) use($bkpmumkm_wilayah){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL)
                        ->whereIn('companies.id_provinsi', $bkpmumkm_wilayah['provinces']);
                })->count();
                $params['countSurveyUMKMTutup']  = $survey_umkm_tutup->whereHas('umkm', function($q) use($bkpmumkm_wilayah){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL)
                        ->whereIn('companies.id_provinsi', $bkpmumkm_wilayah['provinces']);
                })->count();
                $params['countSurveyUMKMPindah']  = $survey_umkm_pindah->whereHas('umkm', function($q) use($bkpmumkm_wilayah){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL)
                        ->whereIn('companies.id_provinsi', $bkpmumkm_wilayah['provinces']);
                })->count();

                $params['countUMKMHasNIB'] = $umkm_has_nib->whereIn('companies.id_provinsi', $bkpmumkm_wilayah['provinces'])->count();
                $params['countUMKMNotNIB'] = $umkm_not_nib->whereIn('companies.id_provinsi', $bkpmumkm_wilayah['provinces'])->count();

                break;
            case GROUP_QC_KOROP:
            case GROUP_ADMIN:
            case GROUP_SUPER_ADMIN:
                $params['countUB'] = $ub->count();

                $params['count_ub_not_set'] = $ub_not_set->count();
                $params['count_ub_bersedia'] = $ub_bersedia->count();
                $params['count_ub_tidak_bersedia'] = $ub_tidak_bersedia->count();
                $params['count_ub_tidak_respon'] = $ub_tidak_respon->count();
                $params['count_ub_konsultasi_bkpm'] = $ub_konsultasi_bkpm->count();
                $params['count_ub_menunggu_konfirmasi'] = $ub_menunggu_konfirmasi->count();                

                $params['countSurveyUB_belum_survey']   = $survey_ub_belum_survey->whereHas(CATEGORY_COMPANY.'.company_status', function($q){
                    $q->whereIn('companies_status.status', ['bersedia']);
                })->count();
                $params['countSurveyUB_progress']       = $survey_ub_progress->whereHas(CATEGORY_COMPANY.'.company_status', function($q){
                    $q->whereIn('companies_status.status', ['bersedia']);
                })->count();
                $params['countSurveyUB_done']           = $survey_ub_done->whereHas(CATEGORY_COMPANY.'.company_status', function($q){
                    $q->whereIn('companies_status.status', ['bersedia']);
                })->count();
                $params['countSurveyUB_verified']       = $survey_ub_verified->whereHas(CATEGORY_COMPANY.'.company_status', function($q){
                    $q->whereIn('companies_status.status', ['bersedia']);
                })->count();
                $params['countSurveyUB_revision']       = $survey_ub_revision->whereHas(CATEGORY_COMPANY.'.company_status', function($q){
                    $q->whereIn('companies_status.status', ['bersedia']);
                })->count();
                
                $ub_total_potensi_nilai_all = \Plugins\BkpmUmkm\Models\SurveyResultModel::whereHas('survey', function($q) use($year, $bkpmumkm_wilayah){
                    $q->whereHas('company', function ($q) use($bkpmumkm_wilayah){
                        $q->where('companies.category', CATEGORY_COMPANY);
                    })->where(function($q) use($year){
                        $q->whereYear('surveys.created_at', $year)->where('surveys.status', 'verified');
                    });
                })->cursor();

                foreach ($ub_total_potensi_nilai_all as $ub_total_nilai) {
                    if($ub_total_nilai->data&&isset($ub_total_nilai->data['kebutuhan_kemitraan'])){
                        foreach ($ub_total_nilai->data['kebutuhan_kemitraan'] as $datum) {
                            $params['count_total_potensi_nilai_all'] += (int)str_replace(',', '', $datum['total_potensi_nilai']);
                        }
                    }
                }

                $params['countUMKMPotensial'] = \Plugins\BkpmUmkm\Models\CompanyModel::where('companies.category', CATEGORY_UMKM)
                    ->where('companies.status', UMKM_POTENSIAL)
                    ->whereHas('survey', function ($q) use($year){
                        $q->whereYear('surveys.created_at', $year);
                    })->count();

                $params['countUMKMPotensialBelumDisurvey']  = $survey_umkm_belum_disurvey->whereHas('umkm', function ($q){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL);
                })->count();
                $params['countSurveyUMKMProgress']  = $survey_umkm_progress->whereHas('umkm', function ($q){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL);
                })->count();
                $params['countSurveyUMKMDone']      = $survey_umkm_done->whereHas('umkm', function ($q){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL);
                })->count();
                $params['countSurveyUMKMVerified']  = $survey_umkm_verified->whereHas('umkm', function ($q){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL);
                })->count();
                $params['countSurveyUMKMBersedia']  = $survey_umkm_bersedia->whereHas('umkm', function ($q){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL);
                })->count();
                $params['countSurveyUMKMMenolak']  = $survey_umkm_menolak->whereHas('umkm', function ($q){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL);
                })->count();
                $params['countSurveyUMKMTutup']  = $survey_umkm_tutup->whereHas('umkm', function ($q){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL);
                })->count();
                $params['countSurveyUMKMPindah']  = $survey_umkm_pindah->whereHas('umkm', function ($q){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL);
                })->count();

                $params['countUMKMHasNIB'] = $umkm_has_nib->count();
                $params['countUMKMNotNIB'] = $umkm_not_nib->count();

                $provinces = [];
                $wilayah = simple_cms_setting('bkpmumkm_wilayah');
                for ($i=0; $i < 4; $i++) { 
                    $provinces = $wilayah[$i]['provinces'];
                    $a = \Plugins\BkpmUmkm\Models\CompanyModel::where('companies.category', CATEGORY_COMPANY)
                    ->whereHas('company_status', function($q) use($year){
                        $q->whereYear('companies_status.created_at', $year)->whereStatus('bersedia');
                    });;
                   $params['countUBWilayah'.($i+1)] = $a->whereIn('companies.id_provinsi', $provinces)->count();
                }
                
                break;
        }

        $params['countKemitraanUB'] = $kemitraan_ub->count();
        $params['countKemitraanUMKM'] = $kemitraan_umkm->count();
        $params['countKemitraanUB_PMA'] = $kemitraan_ub->whereHas('company', function ($q){
            $q->where('companies.pmdn_pma','PMA');
        })->count();
        $kemitraan_ub1          = \Plugins\BkpmUmkm\Models\KemitraanModel::whereYear('created_at', $year)->distinct('company_id');
        $params['countKemitraanUB_PMDN'] = $kemitraan_ub1->whereHas('company', function ($q){
            $q->where('companies.pmdn_pma','PMDN');
        })->count();
        $params['countUMKMBermitra'] = count($umkm_bermitra);
        $params['countUMKMBelumBermitra'] = $umkm_belum_bermitra;

        $params['countResponed'] = $ub_responed->count();
        $params['countRespon'] = $ub_respon->count();
        $params['countTdkRespon'] = $ub_tdk_respon->count();
        $params['countTdkAktif'] = $ub_tdk_aktif->count();

        $params['countBlmJadwal'] = $ub_blm_jadwal->count();
        $params['countZoom'] = $ub_zoom->count();
        $params['countOffline'] = $ub_offline->count();

        $kemitraan = \Plugins\BkpmUmkm\Models\KemitraanModel::selectRaw('SUM(kemitraan.nominal_investasi) AS total_nominal_investasi')->whereIn("kemitraan.status", ['bersedia'])
            ->with([CATEGORY_COMPANY => function($q) use($year){
                return $q->with(['survey' => function($q) use($year){
                    return $q->whereYear('surveys.created_at', $this->periode);
                }]);
            }, CATEGORY_UMKM => function($q) use($year){
                return $q->with(['survey' => function($q) use($year){
                    return $q->whereYear('surveys.created_at', $this->periode);
                }]);
            }])
            ->whereHas(CATEGORY_COMPANY, function($q) use($user){
                switch ($user->group_id){
                    case GROUP_QC_KORPROV:
                        $q->where('companies.id_provinsi', $user->id_provinsi);
                        break;
                    case GROUP_QC_KORWIL:
                    case GROUP_ASS_KORWIL:
                    case GROUP_TA:
                        $provinces = bkpmumkm_wilayah($user->id_provinsi);
                        $provinces = ($provinces && isset($provinces['provinces']) ? $provinces['provinces'] : []);
                        $q->whereIn('companies.id_provinsi', $provinces);
                        break;
                }
            })->whereYear('kemitraan.created_at', $year)->first();
        if ($kemitraan){
            $params['count_total_realisasi_nilai_kontrak'] = (int) $kemitraan->total_nominal_investasi;
        }

        $params['year'] = $year;

        \Core::asset()->write('dashboard-bkpmumkm-js', 'script', view("{$identifier}::dashboard.scripts")->with($params)->render());
        echo view("{$identifier}::dashboard.index")->with($params)->render();
    }
}

add_action('simple_cms_dashboard_backend_add_action', 'dashboard_bkpm_umkm', 23);
