<?php

namespace Plugins\BkpmUmkm\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Plugins\BkpmUmkm\DataTables\User\TenagaAhliDataTable;
use Plugins\BkpmUmkm\DataTables\User\TenagaAhliSurveyVerifiedDataTable;
use Plugins\BkpmUmkm\DataTables\User\TenagaSurveyorDataTable;
use Plugins\BkpmUmkm\DataTables\User\UserDataTable;
use Plugins\BkpmUmkm\Models\BusinessSectorModel;
use Plugins\BkpmUmkm\Models\CompanyModel;
use Plugins\BkpmUmkm\Models\KbliModel;
use Plugins\BkpmUmkm\Models\UmkmMassiveModel;
use SimpleCMS\ACL\Models\User;
use SimpleCMS\Core\Http\Controllers\Controller;
use SimpleCMS\Wilayah\Models\ProvinsiModel;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BkpmUmkmController extends Controller
{
    protected $user;
    protected $config;
    protected $identifier;

    public function __construct()
    {
        $this->user = auth()->user();
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
    }

    public function json_company(Request $request, $category, $status='potensial')
    {
        $search = filter($request->input('search'));
        $status = ($status == 'potensial' ? UMKM_POTENSIAL : UMKM_OBSERVASI);
        $company = CompanyModel::select(
            'companies.id',
            'companies.name',
            'companies.email',
            'companies.nib',
            'companies.id_provinsi',
            'companies.category',
            'provinsi.kode_provinsi',
            'provinsi.nama_provinsi'
        )->where(['companies.category' => $category])->leftJoin('provinsi', function($q){
            return $q->on('companies.id_provinsi', 'provinsi.kode_provinsi');
        });
        switch ($category){
            case CATEGORY_COMPANY:
                $current_year = Carbon::now()->format('Y');
                $company = $company->whereHas('company_status', function ($q) use($current_year) {
                    $q->where('companies_status.status', 'bersedia')->whereYear('companies_status.created_at', $current_year);
                });
                break;
            case CATEGORY_UMKM:
                $company = $company->where('companies.status', $status);
                break;
        }

        switch ($this->user->group_id){
            case GROUP_QC_KORPROV:
                $company->where('companies.id_provinsi', $this->user->id_provinsi);
                break;
            case GROUP_QC_KORWIL:
            case GROUP_ASS_KORWIL:
            case GROUP_TA:
                $provinces = bkpmumkm_wilayah($this->user->id_provinsi);
                $provinces = ($provinces && isset($provinces['provinces']) ? $provinces['provinces'] : []);
                $company->whereIn('companies.id_provinsi', $provinces);
                break;
        }
        $company->where(function($q) use($search) {
            $q->where('companies.name', 'LIKE', '%'. $search .'%')
                ->orWhere('companies.email', 'LIKE', '%'. $search .'%')
                ->orWhere('companies.nib', 'LIKE', '%'. $search .'%')
                ->orWhere('provinsi.nama_provinsi', 'LIKE', '%'. $search .'%');
        });

        return responseSuccess(responseMessage('Success', ['data' => $company->limit(20)->cursor()]));
    }

    public function json_type_jenis_company(Request $request)
    {
        $search = filter($request->input('search'));
        $company = CompanyModel::select(
            'companies.type AS value',
            'companies.type AS label'
        )->groupBy('companies.type');
        $company->where('companies.type', 'LIKE', '%'. $search .'%');

        return responseSuccess(responseMessage('Success', ['data' => $company->limit(20)->cursor()]));
    }

    public function json_sector_umkm_observasi_massive(Request $request)
    {
        $search = filter($request->input('search'));
        $company = UmkmMassiveModel::select(
            'umkm_massive.sector AS value',
            'umkm_massive.sector AS label'
        )->groupBy('umkm_massive.sector');
        $company->where('umkm_massive.sector', 'LIKE', '%'. $search .'%');

        return responseSuccess(responseMessage('Success', ['data' => $company->limit(20)->cursor()]));
    }

    public function json_sector(Request $request)
    {
        $search = filter($request->input('search'));
        $company = BusinessSectorModel::select(
            'business_sectors.id',
            'business_sectors.name'
        );
        $company->where('business_sectors.name', 'LIKE', '%'. $search .'%');

        return responseSuccess(responseMessage('Success', ['data' => $company->limit(20)->cursor()]));
    }
    public function json_kbli(Request $request)
    {
        $search = filter($request->input('search'));
        $company = KbliModel::select(
            'kbli.code',
            'kbli.name'
        );
        $company->where('kbli.code', 'LIKE', '%'. $search .'%')
            ->orWhere('kbli.name', 'LIKE', '%'. $search .'%');

        return responseSuccess(responseMessage('Success', ['data' => $company->limit(20)->cursor()]));
    }

    public function rekap_laporan_umkm_potensial(Request $request)
    {
        $dw = $request->get('dw');
        $dw = ($dw ? encrypt_decrypt($dw, 2) : '' );
        $current_year = Carbon::now()->format('Y');
        $periode = $request->get('periode', $current_year);
        $user = auth()->user();
        $params['dw_selected'] = (!empty($dw) ? $dw : 0);
        $params['periode']      = $periode;
        $provinsi_in = [];
        switch ($user->group_id){
            case GROUP_SURVEYOR:
                throw new NotFoundHttpException('Not found');
                break;
            case GROUP_QC_KORPROV:
                $current_wilayah = bkpmumkm_wilayah($user->id_provinsi);
                $params['bkpmumkm_wilayah'][$current_wilayah['index']] = [
                    "name"      => $current_wilayah["name"],
                    "provinces" => [$user->id_provinsi]
                ];
                $provinsi_in = [$user->id_provinsi];
                $params['dw_selected'] = $current_wilayah['index'];
                break;
            case GROUP_QC_KORWIL:
            case GROUP_ASS_KORWIL:
            case GROUP_TA:
                $current_wilayah = bkpmumkm_wilayah($user->id_provinsi);
                $params['bkpmumkm_wilayah'][$current_wilayah['index']] = [
                    "name"      => $current_wilayah["name"],
                    "provinces" => $current_wilayah["provinces"]
                ];
                $provinsi_in = $current_wilayah["provinces"];
                $params['dw_selected'] = $current_wilayah['index'];
                break;
            default:
                $params['bkpmumkm_wilayah'] = simple_cms_setting('bkpmumkm_wilayah');
                $provinsi_in = $params['bkpmumkm_wilayah'][$params['dw_selected']]["provinces"];
                break;
        }
        $params['provinces'] = ProvinsiModel::whereIn('kode_provinsi', $provinsi_in)->orderBy('nama_provinsi', 'ASC')->cursor();
        return view("{$this->identifier}::rekap_laporan.umkm.potensial")->with($params);
    }

    public function rekap_laporan_tenaga_surveyor(TenagaSurveyorDataTable $tenagaSurveyorDataTable)
    {
        $dw = $tenagaSurveyorDataTable->request()->get('dw');
        $dw = ($dw ? encrypt_decrypt($dw, 2) : '' );
        $current_year = Carbon::now()->format('Y');
        $periode = $tenagaSurveyorDataTable->request()->get('periode', $current_year);
        $user = auth()->user();
        $params['show_select_dw'] = false;
        $params['dw_selected'] = (!empty($dw) ? $dw : 0);
        $params['periode']      = $periode;
        $provinsi_in = [];
        switch ($user->group_id){
            case GROUP_SURVEYOR:
                throw new NotFoundHttpException('Not found');
                break;
            case GROUP_QC_KORPROV:
                $current_wilayah = bkpmumkm_wilayah($user->id_provinsi);
                $params['bkpmumkm_wilayah'][$current_wilayah['index']] = [
                    "name"      => $current_wilayah["name"],
                    "provinces" => [$user->id_provinsi]
                ];
                $provinsi_in = [$user->id_provinsi];
                $params['dw_selected'] = $current_wilayah['index'];
                break;
            case GROUP_QC_KORWIL:
            case GROUP_ASS_KORWIL:
            case GROUP_TA:
                $current_wilayah = bkpmumkm_wilayah($user->id_provinsi);
                $params['bkpmumkm_wilayah'][$current_wilayah['index']] = [
                    "name"      => $current_wilayah["name"],
                    "provinces" => $current_wilayah["provinces"]
                ];
                $provinsi_in = $current_wilayah["provinces"];
                $params['dw_selected'] = $current_wilayah['index'];
                break;
            default:
                $params['bkpmumkm_wilayah'] = simple_cms_setting('bkpmumkm_wilayah');
                $provinsi_in = $params['bkpmumkm_wilayah'][$params['dw_selected']]["provinces"];
                $params['show_select_dw'] = true;
                break;
        }
        $params['provinces'] = ProvinsiModel::whereIn('kode_provinsi', $provinsi_in)->orderBy('nama_provinsi', 'ASC')->cursor();
        $params['user_korwil']  = User::whereIn('users.id_provinsi', $provinsi_in)->where('users.group_id', GROUP_QC_KORWIL)->with(['provinsi'])->cursor();
        $params['user_ass_korwil']  = User::whereIn('users.id_provinsi', $provinsi_in)->where('users.group_id', GROUP_ASS_KORWIL)->with(['provinsi'])->cursor();
        $params['user_tenaga_ahli']  = User::whereIn('users.id_provinsi', $provinsi_in)->where('users.group_id', GROUP_TA)->with(['provinsi'])->cursor();

        return $tenagaSurveyorDataTable->render("{$this->identifier}::rekap_laporan.tenaga_surveyor", $params);
    }

    public function rekap_laporan_tenaga_ahli(TenagaAhliDataTable $tenagaAhliDataTable)
    {
        $dw = $tenagaAhliDataTable->request()->get('dw');
        $dw = ($dw ? encrypt_decrypt($dw, 2) : '' );
        $current_year = Carbon::now()->format('Y');
        $periode = $tenagaAhliDataTable->request()->get('periode', $current_year);
        $user = auth()->user();
        $params['show_select_dw'] = false;
        $params['dw_selected'] = (!empty($dw) ? $dw : 0);
        $params['periode']      = $periode;
        $provinsi_in = [];
        switch ($user->group_id){
            case GROUP_SURVEYOR:
                throw new NotFoundHttpException('Not found');
                break;
            case GROUP_QC_KORPROV:
                $current_wilayah = bkpmumkm_wilayah($user->id_provinsi);
                $params['bkpmumkm_wilayah'][$current_wilayah['index']] = [
                    "name"      => $current_wilayah["name"],
                    "provinces" => [$user->id_provinsi]
                ];
                $provinsi_in = [$user->id_provinsi];
                $params['dw_selected'] = $current_wilayah['index'];
                break;
            case GROUP_QC_KORWIL:
            case GROUP_ASS_KORWIL:
            case GROUP_TA:
                $current_wilayah = bkpmumkm_wilayah($user->id_provinsi);
                $params['bkpmumkm_wilayah'][$current_wilayah['index']] = [
                    "name"      => $current_wilayah["name"],
                    "provinces" => $current_wilayah["provinces"]
                ];
                $provinsi_in = $current_wilayah["provinces"];
                $params['dw_selected'] = $current_wilayah['index'];
                break;
            default:
                $params['bkpmumkm_wilayah'] = simple_cms_setting('bkpmumkm_wilayah');
                $provinsi_in = $params['bkpmumkm_wilayah'][$params['dw_selected']]["provinces"];
                $params['show_select_dw'] = true;
                break;
        }
        $params['provinces'] = ProvinsiModel::whereIn('kode_provinsi', $provinsi_in)->orderBy('nama_provinsi', 'ASC')->cursor();
        $params['user_korwil']  = User::whereIn('users.id_provinsi', $provinsi_in)->where('users.group_id', GROUP_QC_KORWIL)->with(['provinsi'])->cursor();
        $params['user_ass_korwil']  = User::whereIn('users.id_provinsi', $provinsi_in)->where('users.group_id', GROUP_ASS_KORWIL)->with(['provinsi'])->cursor();
        $params['user_tenaga_ahli']  = User::whereIn('users.id_provinsi', $provinsi_in)->where('users.group_id', GROUP_TA)->with(['provinsi'])->cursor();

        return $tenagaAhliDataTable->render("{$this->identifier}::rekap_laporan.tenaga_ahli", $params);
    }

    public function rekap_laporan_tenaga_ahli_daftar_verified(TenagaAhliSurveyVerifiedDataTable $tenagaAhliSurveyVerifiedDataTable)
    {
        return $tenagaAhliSurveyVerifiedDataTable->render("{$this->identifier}::modal.datatable");
    }

    public function json_umkm_massive(Request $request)
    {
        $search = filter($request->input('search'));
        $company = UmkmMassiveModel::select(
            'umkm_massive.id',
            'umkm_massive.name',
            'umkm_massive.nib',
            'umkm_massive.id_provinsi',
            'provinsi.kode_provinsi',
            'provinsi.nama_provinsi'
        )->leftJoin('provinsi', function($q){
            return $q->on('umkm_massive.id_provinsi', 'provinsi.kode_provinsi');
        });

        switch ($this->user->group_id){
            case GROUP_QC_KORPROV:
                $company->where('umkm_massive.id_provinsi', $this->user->id_provinsi);
                break;
            case GROUP_QC_KORWIL:
            case GROUP_ASS_KORWIL:
            case GROUP_TA:
                $provinces = bkpmumkm_wilayah($this->user->id_provinsi);
                $provinces = ($provinces && isset($provinces['provinces']) ? $provinces['provinces'] : []);
                $company->whereIn('umkm_massive.id_provinsi', $provinces);
                break;
        }
        $company->where('umkm_massive.name', 'LIKE', '%'. $search .'%')
            ->orWhere('umkm_massive.nib', 'LIKE', '%'. $search .'%')
            ->orWhere('provinsi.nama_provinsi', 'LIKE', '%'. $search .'%');

        return responseSuccess(responseMessage('Success', ['data' => $company->limit(20)->cursor()]));
    }

    public function grafik_frontend(Request $request)
    {
        $year = filter($request->input('periode'));
        $ub = \Plugins\BkpmUmkm\Models\CompanyModel::where('companies.category', CATEGORY_COMPANY)
            ->whereHas('company_status', function($q) use($year){
                $q->whereYear('companies_status.created_at', $year);
            })->count();
        $umkm_potensial = \Plugins\BkpmUmkm\Models\CompanyModel::where('companies.category', CATEGORY_UMKM)
            ->where('companies.status', UMKM_POTENSIAL)
            ->whereHas('survey', function ($q) use($year){
                $q->whereYear('surveys.created_at', $year);
            })->count();

        $survey_umkm_bersedia   = \Plugins\BkpmUmkm\Models\SurveyModel::whereYear('surveys.created_at', $year)->where('surveys.status', 'bersedia')->whereHas('umkm', function ($q){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL);
                })->count();
        $survey_umkm_menolak    = \Plugins\BkpmUmkm\Models\SurveyModel::whereYear('surveys.created_at', $year)->where('surveys.status', 'menolak')->whereHas('umkm', function ($q){
                    $q->where('companies.category', CATEGORY_UMKM)->where('companies.status', UMKM_POTENSIAL);
                })->count();
        $results = [
            'chart_ub_umkm' => [
                [
                    'name'  => __('label.index_company'),
                    'y'     => (int) $ub
                ],
                [
                    'name'  => __('label.umkm_potensial'),
                    'y'     => (int) $umkm_potensial
                ]
            ],
            'chart_survey_umkm_bersedia_menolak' => [
                [
                    'name'  => __('label.survey_status_bersedia'),
                    'y'     => (int) $survey_umkm_bersedia
                ],
                [
                    'name'  => __('label.survey_status_menolak'),
                    'y'     => (int) $survey_umkm_menolak
                ]
            ]
        ];
        return responseSuccess(responseMessage('Success', $results));
    }

}
