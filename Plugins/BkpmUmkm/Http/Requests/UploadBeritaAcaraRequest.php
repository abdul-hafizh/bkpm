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

class UploadBeritaAcaraRequest extends FormRequest
{
    protected $role = [];
    protected $message = [];
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if (!$this->has('file_old') OR empty($this->input('file_old')) OR $this->file('file')) {
            $this->role['file'] = [
                'required',
                'max:15000',
                'mimes:jpg,jpeg,png,pdf',
                'mimetypes:image/jpeg,image/png,application/pdf'
            ];
        }
        if (!$this->has('photo_old') OR empty($this->input('photo_old')) OR $this->file('photo')) {
            $this->role['photo'] = [
                'required',
                'max:15000',
                'mimes:jpg,jpeg,png',
                'mimetypes:image/jpeg,image/png'
            ];
            if ($this->route('company') == CATEGORY_COMPANY){
                $this->role['photo'][2] .= ',pdf';
                $this->role['photo'][3] .= ',application/pdf';
            }
        }
        if (!$this->has('photo_old2') OR empty($this->input('photo_old2')) OR $this->file('photo2')) {
            $this->role['photo2'] = [
                'max:15000',
                'mimes:jpg,jpeg,png',
                'mimetypes:image/jpeg,image/png'
            ];
        }
        if (!$this->has('photo_old3') OR empty($this->input('photo_old3')) OR $this->file('photo3')) {
            $this->role['photo3'] = [
                'max:15000',
                'mimes:jpg,jpeg,png',
                'mimetypes:image/jpeg,image/png'
            ];
        }
        if (!$this->has('photo_old4') OR empty($this->input('photo_old4')) OR $this->file('photo4')) {
            $this->role['photo4'] = [
                'max:15000',
                'mimes:jpg,jpeg,png',
                'mimetypes:image/jpeg,image/png'
            ];
        }
        if (!$this->has('photo_old5') OR empty($this->input('photo_old5')) OR $this->file('photo5')) {
            $this->role['photo5'] = [
                'max:15000',
                'mimes:jpg,jpeg,png',
                'mimetypes:image/jpeg,image/png'
            ];
        }
        if (!$this->has('photo_old6') OR empty($this->input('photo_old6')) OR $this->file('photo6')) {
            $this->role['photo6'] = [
                'max:15000',
                'mimes:jpg,jpeg,png',
                'mimetypes:image/jpeg,image/png'
            ];
        }
        if (!$this->has('photo_old7') OR empty($this->input('photo_old7')) OR $this->file('photo7')) {
            $this->role['photo7'] = [
                'max:15000',
                'mimes:jpg,jpeg,png',
                'mimetypes:image/jpeg,image/png'
            ];
        }
        if (!$this->has('photo_old8') OR empty($this->input('photo_old8')) OR $this->file('photo8')) {
            $this->role['photo8'] = [
                'max:15000',
                'mimes:jpg,jpeg,png',
                'mimetypes:image/jpeg,image/png'
            ];
        }
        if (!$this->has('photo_old9') OR empty($this->input('photo_old9')) OR $this->file('photo9')) {
            $this->role['photo9'] = [
                'max:15000',
                'mimes:jpg,jpeg,png',
                'mimetypes:image/jpeg,image/png'
            ];
        }
        if (!$this->has('photo_old10') OR empty($this->input('photo_old10')) OR $this->file('photo10')) {
            $this->role['photo10'] = [
                'max:15000',
                'mimes:jpg,jpeg,png',
                'mimetypes:image/jpeg,image/png'
            ];
        }
        return $this->role;
    }

    public function messages()
    {
        if ($this->route('company') == CATEGORY_COMPANY){
            $label_file = trans('label.surat_ketersediaan_bermitra_1');
            $label_photo = trans('label.surat_ketersediaan_bermitra_2');
        }else{
            $label_file = trans('label.photo_scan_berita_acara');
            $label_photo = trans('label.photo_bersama_responden_berita_acara');
        }
        $message = [
            'required'   => 'File :label harus diisi.',
            'max'   => 'File :label terlalu besar.',
            'mimes' => 'Extensi :label tidak didukung.',
            'mimetypes' => 'Mime Type :label tidak support.'
        ];
        $this->message["file"] = [
            'required' => Lang::get($message['required'], ['label' => $label_file]),
            'max'   => Lang::get($message['max'], ['label' => $label_file]),
            'mimes' => Lang::get($message['mimes'], ['label' => $label_file]),
            'mimetypes' => Lang::get($message['mimetypes'], ['label' => $label_file])
        ];
        $this->message["photo"] = [
            'required' => Lang::get($message['required'], ['label' => $label_photo]),
            'max'   => Lang::get($message['max'], ['label' => $label_photo]),
            'mimes' => Lang::get($message['mimes'], ['label' => $label_photo]),
            'mimetypes' => Lang::get($message['mimetypes'], ['label' => $label_file])
        ];
        $this->message["photo2"] = [
            'max'   => Lang::get($message['max'], ['label' => $label_photo]),
            'mimes' => Lang::get($message['mimes'], ['label' => $label_photo]),
            'mimetypes' => Lang::get($message['mimetypes'], ['label' => $label_file])
        ];
        $this->message["photo3"] = [
            'max'   => Lang::get($message['max'], ['label' => $label_photo]),
            'mimes' => Lang::get($message['mimes'], ['label' => $label_photo]),
            'mimetypes' => Lang::get($message['mimetypes'], ['label' => $label_file])
        ];
        $this->message["photo4"] = [
            'max'   => Lang::get($message['max'], ['label' => $label_photo]),
            'mimes' => Lang::get($message['mimes'], ['label' => $label_photo]),
            'mimetypes' => Lang::get($message['mimetypes'], ['label' => $label_file])
        ];
        $this->message["photo5"] = [
            'max'   => Lang::get($message['max'], ['label' => $label_photo]),
            'mimes' => Lang::get($message['mimes'], ['label' => $label_photo]),
            'mimetypes' => Lang::get($message['mimetypes'], ['label' => $label_file])
        ];
        $this->message["photo6"] = [
            'max'   => Lang::get($message['max'], ['label' => $label_photo]),
            'mimes' => Lang::get($message['mimes'], ['label' => $label_photo]),
            'mimetypes' => Lang::get($message['mimetypes'], ['label' => $label_file])
        ];
        $this->message["photo7"] = [
            'max'   => Lang::get($message['max'], ['label' => $label_photo]),
            'mimes' => Lang::get($message['mimes'], ['label' => $label_photo]),
            'mimetypes' => Lang::get($message['mimetypes'], ['label' => $label_file])
        ];
        $this->message["photo8"] = [
            'max'   => Lang::get($message['max'], ['label' => $label_photo]),
            'mimes' => Lang::get($message['mimes'], ['label' => $label_photo]),
            'mimetypes' => Lang::get($message['mimetypes'], ['label' => $label_file])
        ];
        $this->message["photo9"] = [
            'max'   => Lang::get($message['max'], ['label' => $label_photo]),
            'mimes' => Lang::get($message['mimes'], ['label' => $label_photo]),
            'mimetypes' => Lang::get($message['mimetypes'], ['label' => $label_file])
        ];
        $this->message["photo10"] = [
            'max'   => Lang::get($message['max'], ['label' => $label_photo]),
            'mimes' => Lang::get($message['mimes'], ['label' => $label_photo]),
            'mimetypes' => Lang::get($message['mimetypes'], ['label' => $label_file])
        ];
        return $this->message;
    }
}
