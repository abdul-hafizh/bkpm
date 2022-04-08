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
use Plugins\BkpmUmkm\Models\SurveyUmkmMassiveModel;

class SurveyUmkmObservasiMassiveSaveUpdateRequest extends FormRequest
{
    protected $role = [];
    protected $message = [];
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = encrypt_decrypt($this->input('id'), 2);

        $this->role['id_umkm_massive']  = "required|exists:umkm_massive,id|unique:survey_umkm_massive,id_umkm_massive,{$id}";

        if ( !$this->get('upload') && !$this->get('delete') ) {
            $this->role['date_survey']      = 'required';
            $this->role['nama_surveyor']    = 'required';
            $this->role['id_negara']        = 'required';
            $this->role['id_provinsi']      = 'required';
        }
        if ($this->file('foto_berita_acara_upload')){
            foreach ($this->file('foto_berita_acara_upload') as $k => $ha) {
                $this->role["foto_berita_acara_upload.{$k}"] = [
                    'max:15000',
                    'mimes:jpg,jpeg,png,pdf'
                ];
            }
        }
        if ($this->file('foto_legalitas_usaha_upload')){
            foreach ($this->file('foto_legalitas_usaha_upload') as $k => $ha) {
                $this->role["foto_legalitas_usaha_upload.{$k}"] = [
                    'max:15000',
                    'mimes:jpg,jpeg,png,pdf'
                ];
            }
        }
        if ($this->file('foto_tempat_usaha_upload')){
            foreach ($this->file('foto_tempat_usaha_upload') as $k => $ha) {
                $this->role["foto_tempat_usaha_upload.{$k}"] = [
                    'max:15000',
                    'mimes:jpg,jpeg,png,pdf'
                ];
            }
        }
        if ($this->file('foto_produk_upload')){
            foreach ($this->file('foto_produk_upload') as $k => $ha) {
                $this->role["foto_produk_upload.{$k}"] = [
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

        $this->message['id_umkm_massive.required']  = "Umkm harus diisi.";
        $this->message['id_umkm_massive.exists']    = "Umkm tidak ada didalam daftar.";
        $this->message['id_umkm_massive.unique']    = "Umkm sudah disurvey.";
        $this->message['date_survey.required']      = 'Tanggal survey harus diisi.';
        $this->message['nama_surveyor.required']    = 'Nama surveyor harus diisi.';
        $this->message['id_negara.required']        = 'Negara harus diisi.';
        $this->message['id_provinsi.required']      = 'Provinsi harus diisi.';

        if ($this->file('foto_berita_acara_upload')){
            foreach ($this->file('foto_berita_acara_upload') as $k => $ha) {
                $filename = $ha->getClientOriginalName();
                $this->message["foto_berita_acara_upload.{$k}"] = [
                    'max'   => Lang::get($message['max'], ['filename' => $filename]),
                    'mimes' => Lang::get($message['mimes'], ['filename' => $filename])
                ];
            }
        }
        if ($this->file('foto_legalitas_usaha_upload')){
            foreach ($this->file('foto_legalitas_usaha_upload') as $k => $ha) {
                $filename = $ha->getClientOriginalName();
                $this->message["foto_legalitas_usaha_upload.{$k}"] = [
                    'max'   => Lang::get($message['max'], ['filename' => $filename]),
                    'mimes' => Lang::get($message['mimes'], ['filename' => $filename])
                ];
            }
        }
        if ($this->file('foto_tempat_usaha_upload')){
            foreach ($this->file('foto_tempat_usaha_upload') as $k => $ha) {
                $filename = $ha->getClientOriginalName();
                $this->message["foto_tempat_usaha_upload.{$k}"] = [
                    'max'   => Lang::get($message['max'], ['filename' => $filename]),
                    'mimes' => Lang::get($message['mimes'], ['filename' => $filename])
                ];
            }
        }
        if ($this->file('foto_produk_upload')){
            foreach ($this->file('foto_produk_upload') as $k => $ha) {
                $filename = $ha->getClientOriginalName();
                $this->message["foto_produk_upload.{$k}"] = [
                    'max'   => Lang::get($message['max'], ['filename' => $filename]),
                    'mimes' => Lang::get($message['mimes'], ['filename' => $filename])
                ];
            }
        }

        return $this->message;
    }

}
