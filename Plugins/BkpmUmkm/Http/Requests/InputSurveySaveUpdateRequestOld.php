<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 10/12/16
 * Time: 23:21
 */

namespace Plugins\BkpmUmkm\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;

class InputSurveySaveUpdateRequestOld extends FormRequest
{
    protected $role = [];
    protected $message = [];
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->file('data.dokumentasi_profil_usaha.penghargaan_upload')){
            foreach ($this->file('data.dokumentasi_profil_usaha.penghargaan_upload') as $k => $ha) {
                $this->role["data.dokumentasi_profil_usaha.penghargaan_upload.{$k}"] = [
                    'max:15000',
                    'mimes:jpg,jpeg,png,pdf'
                ];
            }
        }
        if ($this->file('data.dokumentasi_profil_usaha.sertifikasi.mutu_upload.file')){
            $this->role['data.dokumentasi_profil_usaha.sertifikasi.mutu_upload.file'] = [
                'max:15000',
                'mimes:jpg,jpeg,png,pdf'
            ];
        }
        if ($this->file('data.dokumentasi_profil_usaha.sertifikasi.halal_upload.file')){
            $this->role['data.dokumentasi_profil_usaha.sertifikasi.halal_upload.file'] = [
                'max:15000',
                'mimes:jpg,jpeg,png,pdf'
            ];
        }
        if ($this->file('data.dokumentasi_profil_usaha.sertifikasi.lainya_upload')){
            foreach ($this->file('data.dokumentasi_profil_usaha.sertifikasi.lainya_upload') as $k => $ha) {
                $this->role["data.dokumentasi_profil_usaha.sertifikasi.lainya_upload.{$k}"] = [
                    'max:15000',
                    'mimes:jpg,jpeg,png,pdf'
                ];
            }
        }
        /*========================================*/
        if ($this->file('data.dokumentasi_profil_usaha.legalitas.siup_upload.file')){
            $this->role['data.dokumentasi_profil_usaha.legalitas.siup_upload.file'] = [
                'max:15000',
                'mimes:jpg,jpeg,png,pdf'
            ];
        }
        if ($this->has('data.dokumentasi_profil_usaha.legalitas.tdp_upload.file')){
            $this->role['data.dokumentasi_profil_usaha.legalitas.tdp_upload.file'] = [
                'max:15000',
                'mimes:jpg,jpeg,png,pdf'
            ];
        }
        if ($this->file('data.dokumentasi_profil_usaha.legalitas.npwp_upload.file')){
            $this->role['data.dokumentasi_profil_usaha.legalitas.npwp_upload.file'] = [
                'max:15000',
                'mimes:jpg,jpeg,png,pdf'
            ];
        }
        if ($this->file('data.dokumentasi_profil_usaha.legalitas.nib_upload.file')){
            $this->role['data.dokumentasi_profil_usaha.legalitas.nib_upload.file'] = [
                'max:15000',
                'mimes:jpg,jpeg,png,pdf'
            ];
        }
        if ($this->file('data.dokumentasi_profil_usaha.legalitas.lainya_upload')){
            foreach ($this->file('data.dokumentasi_profil_usaha.legalitas.lainya_upload') as $k => $ha) {
                $this->role["data.dokumentasi_profil_usaha.legalitas.lainya_upload.{$k}"] = [
                    'max:15000',
                    'mimes:jpg,jpeg,png,pdf'
                ];
            }
        }
        /*====================================================*/
        if ($this->file('data.dokumentasi_produk_dokumen.brosur_upload.file')){
            $this->role['data.dokumentasi_produk_dokumen.brosur_upload.file'] = [
                'max:15000',
                'mimes:jpg,jpeg,png,pdf'
            ];
        }
        if ($this->file('data.dokumentasi_produk_dokumen.pamflet_upload.file')){
            $this->role['data.dokumentasi_produk_dokumen.pamflet_upload.file'] = [
                'max:15000',
                'mimes:jpg,jpeg,png,pdf'
            ];
        }
        if ($this->file('data.dokumentasi_produk_dokumen.lainya_upload')){
            foreach ($this->file('data.dokumentasi_produk_dokumen.lainya_upload') as $k => $ha) {
                $this->role["data.dokumentasi_produk_dokumen.lainya_upload.{$k}"] = [
                    'max:15000',
                    'mimes:jpg,jpeg,png,pdf'
                ];
            }
        }
        /*====================================================*/
        if ($this->file('data.dokumentasi_fisik_terkait_usaha.tempat_usaha_upload')){
            foreach ($this->file('data.dokumentasi_fisik_terkait_usaha.tempat_usaha_upload') as $k => $ha) {
                $this->role["data.dokumentasi_fisik_terkait_usaha.tempat_usaha_upload.{$k}"] = [
                    'max:15000',
                    'mimes:jpg,jpeg,png,pdf'
                ];
            }
        }
        if ($this->file('data.dokumentasi_fisik_terkait_usaha.kegiatan_usaha_upload')){
            foreach ($this->file('data.dokumentasi_fisik_terkait_usaha.kegiatan_usaha_upload') as $k => $ha) {
                $this->role["data.dokumentasi_fisik_terkait_usaha.kegiatan_usaha_upload.{$k}"] = [
                    'max:15000',
                    'mimes:jpg,jpeg,png,pdf'
                ];
            }
        }
        if ($this->file('data.dokumentasi_fisik_terkait_usaha.papan_nama_usaha_upload')){
            foreach ($this->file('data.dokumentasi_fisik_terkait_usaha.papan_nama_usaha_upload') as $k => $ha) {
                $this->role["data.dokumentasi_fisik_terkait_usaha.papan_nama_usaha_upload.{$k}"] = [
                    'max:15000',
                    'mimes:jpg,jpeg,png,pdf'
                ];
            }
        }
        if ($this->file('data.dokumentasi_fisik_terkait_usaha.lainya_upload')){
            foreach ($this->file('data.dokumentasi_fisik_terkait_usaha.lainya_upload') as $k => $ha) {
                $this->role["data.dokumentasi_fisik_terkait_usaha.lainya_upload.{$k}"] = [
                    'max:15000',
                    'mimes:jpg,jpeg,png,pdf'
                ];
            }
        }
        if ($this->file('documents_upload')){
            foreach ($this->file('documents_upload') as $k => $ha) {
                $this->role["documents_upload.{$k}"] = [
                    'max:15000',
                    'mimes:jpg,jpeg,png,pdf'
                ];
            }
        }
        return $this->role;
    }

    public function messages()
    {
        $message = [
            'max'   => 'File :filename terlalu besar.',
            'mimes' => 'Extensi :filename tidak didukung.'
        ];
        if ($this->file('data.dokumentasi_profil_usaha.penghargaan_upload')){
            foreach ($this->file('data.dokumentasi_profil_usaha.penghargaan_upload') as $k => $ha) {
                $filename = $ha->getClientOriginalName();
                $this->message["data.dokumentasi_profil_usaha.penghargaan_upload.{$k}"] = [
                    'max'   => Lang::get($message['max'], ['filename' => $filename]),
                    'mimes' => Lang::get($message['mimes'], ['filename' => $filename])
                ];
            }
        }
        if ($this->file('data.dokumentasi_profil_usaha.sertifikasi.mutu_upload.file')){
            $filename = $this->file('data.dokumentasi_profil_usaha.sertifikasi.mutu_upload.file');
            $this->message['data.dokumentasi_profil_usaha.sertifikasi.mutu_upload.file'] = [
                'max'   => Lang::get($message['max'], ['filename' => $filename->getClientOriginalName()]),
                'mimes' => Lang::get($message['mimes'], ['filename' => $filename->getClientOriginalName()])
            ];
        }
        if ($this->file('data.dokumentasi_profil_usaha.sertifikasi.halal_upload.file')){
            $filename = $this->file('data.dokumentasi_profil_usaha.sertifikasi.halal_upload.file')->getClientOriginalName();
            $this->message['data.dokumentasi_profil_usaha.sertifikasi.halal_upload.file'] = [
                'max'   => Lang::get($message['max'], ['filename' => $filename]),
                'mimes' => Lang::get($message['mimes'], ['filename' => $filename])
            ];
        }
        if ($this->file('data.dokumentasi_profil_usaha.sertifikasi.lainya_upload')){
            foreach ($this->file('data.dokumentasi_profil_usaha.sertifikasi.lainya_upload') as $k => $ha) {
                $filename = $ha->getClientOriginalName();
                $this->message["data.dokumentasi_profil_usaha.sertifikasi.lainya_upload.{$k}"] = [
                    'max'   => Lang::get($message['max'], ['filename' => $filename]),
                    'mimes' => Lang::get($message['mimes'], ['filename' => $filename])
                ];
            }
        }
        /*========================================*/
        if ($this->file('data.dokumentasi_profil_usaha.legalitas.siup_upload.file')){
            $filename = $this->file('data.dokumentasi_profil_usaha.legalitas.siup_upload.file')->getClientOriginalName();
            $this->message['data.dokumentasi_profil_usaha.legalitas.siup_upload.file'] = [
                'max'   => Lang::get($message['max'], ['filename' => $filename]),
                'mimes' => Lang::get($message['mimes'], ['filename' => $filename])
            ];
        }
        if ($this->file('data.dokumentasi_profil_usaha.legalitas.tdp_upload.file')){
            $filename = $this->file('data.dokumentasi_profil_usaha.legalitas.tdp_upload.file')->getClientOriginalName();
            $this->message['data.dokumentasi_profil_usaha.legalitas.tdp_upload.file'] = [
                'max'   => Lang::get($message['max'], ['filename' => $filename]),
                'mimes' => Lang::get($message['mimes'], ['filename' => $filename])
            ];
        }
        if ($this->file('data.dokumentasi_profil_usaha.legalitas.npwp_upload.file')){
            $filename = $this->file('data.dokumentasi_profil_usaha.legalitas.npwp_upload.file')->getClientOriginalName();
            $this->message['data.dokumentasi_profil_usaha.legalitas.npwp_upload.file'] = [
                'max'   => Lang::get($message['max'], ['filename' => $filename]),
                'mimes' => Lang::get($message['mimes'], ['filename' => $filename])
            ];
        }
        if ($this->file('data.dokumentasi_profil_usaha.legalitas.nib_upload.file')){
            $filename = $this->file('data.dokumentasi_profil_usaha.legalitas.nib_upload.file')->getClientOriginalName();
            $this->message['data.dokumentasi_profil_usaha.legalitas.nib_upload.file'] = [
                'max'   => Lang::get($message['max'], ['filename' => $filename]),
                'mimes' => Lang::get($message['mimes'], ['filename' => $filename])
            ];
        }
        if ($this->file('data.dokumentasi_profil_usaha.legalitas.lainya_upload')){
            foreach ($this->file('data.dokumentasi_profil_usaha.legalitas.lainya_upload') as $k => $ha) {
                $filename = $ha->getClientOriginalName();
                $this->message["data.dokumentasi_profil_usaha.legalitas.lainya.{$k}"] = [
                    'max'   => Lang::get($message['max'], ['filename' => $filename]),
                    'mimes' => Lang::get($message['mimes'], ['filename' => $filename])
                ];
            }
        }
        /*====================================================*/
        if ($this->file('data.dokumentasi_produk_dokumen.brosur_upload.file')){
            $filename = $this->file('data.dokumentasi_produk_dokumen.brosur_upload.file')->getClientOriginalName();
            $this->message['data.dokumentasi_produk_dokumen.brosur_upload.file'] = [
                'max'   => Lang::get($message['max'], ['filename' => $filename]),
                'mimes' => Lang::get($message['mimes'], ['filename' => $filename])
            ];
        }
        if ($this->file('data.dokumentasi_produk_dokumen.pamflet_upload.file')){
            $filename = $this->file('data.dokumentasi_produk_dokumen.pamflet_upload.file')->getClientOriginalName();
            $this->message['data.dokumentasi_produk_dokumen.pamflet_upload.file'] = [
                'max'   => Lang::get($message['max'], ['filename' => $filename]),
                'mimes' => Lang::get($message['mimes'], ['filename' => $filename])
            ];
        }
        if ($this->file('data.dokumentasi_produk_dokumen.lainya_upload')){
            foreach ($this->file('data.dokumentasi_produk_dokumen.lainya_upload') as $k => $ha) {
                $filename = $ha->getClientOriginalName();
                $this->message["data.dokumentasi_produk_dokumen.lainya_upload.{$k}"] = [
                    'max'   => Lang::get($message['max'], ['filename' => $filename]),
                    'mimes' => Lang::get($message['mimes'], ['filename' => $filename])
                ];
            }
        }
        /*====================================================*/
        if ($this->file('data.dokumentasi_fisik_terkait_usaha.tempat_usaha_upload')){
            foreach ($this->file('data.dokumentasi_fisik_terkait_usaha.tempat_usaha_upload') as $k => $ha) {
                $filename = $ha->getClientOriginalName();
                $this->message["data.dokumentasi_fisik_terkait_usaha.tempat_usaha_upload.{$k}"] = [
                    'max'   => Lang::get($message['max'], ['filename' => $filename]),
                    'mimes' => Lang::get($message['mimes'], ['filename' => $filename])
                ];
            }
        }
        if ($this->file('data.dokumentasi_fisik_terkait_usaha.kegiatan_usaha_upload')){
            foreach ($this->file('data.dokumentasi_fisik_terkait_usaha.kegiatan_usaha_upload') as $k => $ha) {
                $filename = $ha->getClientOriginalName();
                $this->message["data.dokumentasi_fisik_terkait_usaha.kegiatan_usaha_upload.{$k}"] = [
                    'max'   => Lang::get($message['max'], ['filename' => $filename]),
                    'mimes' => Lang::get($message['mimes'], ['filename' => $filename])
                ];
            }
        }
        if ($this->file('data.dokumentasi_fisik_terkait_usaha.papan_nama_usaha_upload')){
            foreach ($this->file('data.dokumentasi_fisik_terkait_usaha.papan_nama_usaha_upload') as $k => $ha) {
                $filename = $ha->getClientOriginalName();
                $this->message["data.dokumentasi_fisik_terkait_usaha.papan_nama_usaha_upload.{$k}"] = [
                    'max'   => Lang::get($message['max'], ['filename' => $filename]),
                    'mimes' => Lang::get($message['mimes'], ['filename' => $filename])
                ];
            }
        }
        if ($this->file('data.dokumentasi_fisik_terkait_usaha.lainya_upload')){
            foreach ($this->file('data.dokumentasi_fisik_terkait_usaha.lainya_upload') as $k => $ha) {
                $filename = $ha->getClientOriginalName();
                $this->message["data.dokumentasi_fisik_terkait_usaha.lainya_upload.{$k}"] = [
                    'max'   => Lang::get($message['max'], ['filename' => $filename]),
                    'mimes' => Lang::get($message['mimes'], ['filename' => $filename])
                ];
            }
        }
        if ($this->file('documents_upload')){
            foreach ($this->file('documents_upload') as $k => $ha) {
                $filename = $ha->getClientOriginalName();
                $this->message["documents_upload.{$k}"] = [
                    'max'   => Lang::get($message['max'], ['filename' => $filename]),
                    'mimes' => Lang::get($message['mimes'], ['filename' => $filename])
                ];
            }
        }

        return $this->message;
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        // checks user current password
        // before making changes
        $validator->after(function ($validator) {
            if ( !$this->get('upload') && !$this->get('delete') ) {
                $status = filter($this->input('status'));
                $category_company = filter($this->route()->parameter('company'));
                $not_valid = false;
                if (in_array($status, ['done', 'verified'])){
                    $not_valid = (
                        empty(filter($this->input('data.responden.nama_responden'))) OR
                        empty(filter($this->input('data.responden.nomor_ponsel'))) OR
                        empty(filter($this->input('data.responden.email'))) OR
                        empty(filter($this->input('data.responden.nama_perusahaan'))) OR
                        empty(filter($this->input('data.responden.alamat_perusahaan'))) OR
                        empty(filter($this->input('data.responden.negara'))) OR
                        empty(filter($this->input('data.responden.provinsi'))) OR
                        empty(filter($this->input('data.responden.email_perusahaan'))) OR
                        empty(filter($this->input('data.responden.telepon_perusahaan'))) OR
                        empty(filter($this->input('data.profil_usaha.nama_usaha'))) OR
                        empty(filter($this->input('data.profil_usaha.alamat'))) OR
                        empty(filter($this->input('data.profil_usaha.negara'))) OR
                        empty(filter($this->input('data.profil_usaha.provinsi'))) OR
                        empty(filter($this->input('data.profil_usaha.koordinat_gps_longitude'))) OR
                        empty(filter($this->input('data.profil_usaha.koordinat_gps_latitude'))) OR
                        empty(filter($this->input('data.profil_usaha.jumlah_kantor_cabang'))) OR
                        empty(filter($this->input('data.profil_usaha.telepon'))) OR
                        empty(filter($this->input('data.profil_usaha.ponsel'))) OR
                        empty(filter($this->input('data.profil_usaha.email'))) OR
                        empty(filter($this->input('data.profil_usaha.nama_cp'))) OR
                        empty(filter($this->input('data.profil_usaha.email_cp'))) OR
                        empty(filter($this->input('data.profil_usaha.ponsel_cp'))) OR
                        empty(filter($this->input('data.profil_usaha.modal_awal')))
                        // empty(filter($this->input('data.profil_usaha.rencana_investasi'))) OR
                        // empty(filter($this->input('data.profil_usaha.realisasi_investasi')))
                    );
                }
                if ($not_valid) {
                    $validator->errors()->add('status', trans('validation.survey_all_required_input'));
                }
            }
        });
        return;
    }
}
