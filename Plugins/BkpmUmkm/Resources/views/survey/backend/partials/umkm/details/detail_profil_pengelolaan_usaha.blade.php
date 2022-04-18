<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">4. Profil Pengelolaan Usaha</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        @php
            $profil_pengelolaan_usaha    = ($survey->survey_result->data && (isset($survey->survey_result->data['profil_pengelolaan_usaha'])&&$survey->survey_result->data['profil_pengelolaan_usaha']) ? $survey->survey_result->data['profil_pengelolaan_usaha'] : '');
        @endphp
        <table class="table table-sm row">
            <tbody class="col-12">
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">4.1</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Pengelolaan Usaha</td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                                <input type="radio" name="data[profil_pengelolaan_usaha][kepemilikan]" value="Sendiri" {{ (isset($profil_pengelolaan_usaha['kepemilikan'])&&$profil_pengelolaan_usaha['kepemilikan']=='Sendiri' ? 'checked':'') }} class="form-check-input" id="kepemilikan_usaha_sendiri">
                                <label class="form-check-label" for="kepemilikan_usaha_sendiri">(a) Sendiri;</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                                <input type="radio" name="data[profil_pengelolaan_usaha][kepemilikan]" value="Keluarga" {{ (isset($profil_pengelolaan_usaha['kepemilikan'])&&$profil_pengelolaan_usaha['kepemilikan']=='Keluarga' ? 'checked':'') }} class="form-check-input" id="kepemilikan_usaha_keluarga">
                                <label class="form-check-label" for="kepemilikan_usaha_keluarga">(b) Keluarga;</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                                <input type="radio" name="data[profil_pengelolaan_usaha][kepemilikan]" value="Dengan investor lain yang bukan keluarga" {{ (isset($profil_pengelolaan_usaha['kepemilikan'])&&in_array($profil_pengelolaan_usaha['kepemilikan'], ['Orang Lain', 'Dengan investor lain yang bukan keluarga']) ? 'checked':'') }} class="form-check-input" id="kepemilikan_usaha_orang_lain">
                                <label class="form-check-label" for="kepemilikan_usaha_orang_lain">(c) Dengan investor lain yang bukan keluarga;</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                                <input type="radio" name="data[profil_pengelolaan_usaha][kepemilikan]" value="Lainnya" {{ (isset($profil_pengelolaan_usaha['kepemilikan'])&&$profil_pengelolaan_usaha['kepemilikan']=='Lainnya' ? 'checked':'') }} class="form-check-input" id="kepemilikan_usaha_lainya">
                                <label class="form-check-label" for="kepemilikan_usaha_lainya">(d) Lainnya;</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            {{ (isset($profil_pengelolaan_usaha['kepemilikan_lainnya'])?$profil_pengelolaan_usaha['kepemilikan_lainnya']:(isset($profil_pengelolaan_usaha['kepemilikan_lainya'])?$profil_pengelolaan_usaha['kepemilikan_lainya']:'')) }}
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">4.2</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Tahun Berdiri Usaha dan Usia</td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th style="width: 28%;"></th>
                            <th style="width: 72%;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>(a) Tahun Pendirian:</td>
                            <td>
                                <input type="text" name="data[profil_pengelolaan_usaha][tahun_berdiri]" value="{{ (isset($profil_pengelolaan_usaha['tahun_berdiri'])?$profil_pengelolaan_usaha['tahun_berdiri']:'') }}" placeholder="Tahun Berdiri" class="form-control form-control-sm">
                            </td>
                        </tr>
                        <tr>
                            <td>(b) Usia:</td>
                            <td>
                                <input type="text" name="data[profil_pengelolaan_usaha][usia]" value="{{ (isset($profil_pengelolaan_usaha['usia'])?$profil_pengelolaan_usaha['usia']:'') }}" placeholder="Usia" class="form-control form-control-sm">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">4.3</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Hasil Penjualan (Omzet) per-Tahun</td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                                <input type="radio" name="data[profil_pengelolaan_usaha][omzet]" value="≤ Rp 2 miliar" {{ (isset($profil_pengelolaan_usaha['omzet'])&&$profil_pengelolaan_usaha['omzet']=='≤ Rp 2 miliar' ? 'checked':'') }} class="form-check-input" id="profil_pengelolaan_usaha_omzet_1">
                                <label class="form-check-label" for="profil_pengelolaan_usaha_omzet_1">(a) ≤ Rp 2 miliar;</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                                <input type="radio" name="data[profil_pengelolaan_usaha][omzet]" value="Rp 2 miliar – Rp 15 miliar" {{ (isset($profil_pengelolaan_usaha['omzet'])&&$profil_pengelolaan_usaha['omzet']=='Rp 2 miliar – Rp 15 miliar' ? 'checked':'') }} class="form-check-input" id="profil_pengelolaan_usaha_omzet_2">
                                <label class="form-check-label" for="profil_pengelolaan_usaha_omzet_2">(b) Rp 2 miliar – Rp 15 miliar;</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                                <input type="radio" name="data[profil_pengelolaan_usaha][omzet]" value="Rp 15 miliar – Rp 50 miliar" {{ (isset($profil_pengelolaan_usaha['omzet'])&&$profil_pengelolaan_usaha['omzet']=='Rp 15 miliar – Rp 50 miliar' ? 'checked':'') }} class="form-check-input" id="profil_pengelolaan_usaha_omzet_3">
                                <label class="form-check-label" for="profil_pengelolaan_usaha_omzet_3">(c) Rp 15 miliar – Rp 50 miliar;</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                                <input type="radio" name="data[profil_pengelolaan_usaha][omzet]" value="Sebutkan" {{ (isset($profil_pengelolaan_usaha['omzet'])&&$profil_pengelolaan_usaha['omzet']=='Sebutkan' ? 'checked':'') }} class="form-check-input" id="profil_pengelolaan_usaha_omzet_5">
                                <label class="form-check-label" for="profil_pengelolaan_usaha_omzet_5">(d) Sebutkan;</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            {{ (isset($profil_pengelolaan_usaha['omzet_sebutkan'])?$profil_pengelolaan_usaha['omzet_sebutkan']:'') }}
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
