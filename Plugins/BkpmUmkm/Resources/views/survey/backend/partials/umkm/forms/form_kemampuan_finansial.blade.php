<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">3. Kemampuan Finansial</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        @php
            $kemampuan_finansial    = ($survey->survey_result->data && (isset($survey->survey_result->data['kemampuan_finansial'])&&$survey->survey_result->data['kemampuan_finansial']) ? $survey->survey_result->data['kemampuan_finansial'] : '');
        @endphp
        <table class="table table-sm row">
            <tbody class="col-12">
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">3.1</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Ketersediaan dana untuk berproduksi</td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                                <input type="radio" name="data[kemampuan_finansial][dana_produksi]" value="< Rp 500 juta" {{ (isset($kemampuan_finansial['dana_produksi'])&&$kemampuan_finansial['dana_produksi']=='< Rp 500 juta' ? 'checked':'') }} class="form-check-input" id="kemampuan_finansial_dana_produksi_1">
                                <label class="form-check-label" for="kemampuan_finansial_dana_produksi_1">(a) < Rp 500 juta</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                                <input type="radio" name="data[kemampuan_finansial][dana_produksi]" value="Rp 500 juta – Rp 1 Miliar" {{ (isset($kemampuan_finansial['dana_produksi'])&&$kemampuan_finansial['dana_produksi']=='Rp 500 juta – Rp 1 Miliar' ? 'checked':'') }} class="form-check-input" id="kemampuan_finansial_dana_produksi_2">
                                <label class="form-check-label" for="kemampuan_finansial_dana_produksi_2">(b) Rp 500 juta – Rp 1 Miliar</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                                <input type="radio" name="data[kemampuan_finansial][dana_produksi]" value="Rp 1 Miliar – Rp 5 Miliar" {{ (isset($kemampuan_finansial['dana_produksi'])&&$kemampuan_finansial['dana_produksi']=='Rp 1 Miliar – Rp 5 Miliar' ? 'checked':'') }} class="form-check-input" id="kemampuan_finansial_dana_produksi_3">
                                <label class="form-check-label" for="kemampuan_finansial_dana_produksi_3">(c) Rp 1 Miliar – Rp 5 Miliar</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                                <input type="radio" name="data[kemampuan_finansial][dana_produksi]" value="Rp 5 Miliar – Rp 10 Miliar" {{ (isset($kemampuan_finansial['dana_produksi'])&&$kemampuan_finansial['dana_produksi']=='Rp 5 Miliar – Rp 10 Miliar' ? 'checked':'') }} class="form-check-input" id="kemampuan_finansial_dana_produksi_4">
                                <label class="form-check-label" for="kemampuan_finansial_dana_produksi_4">(d) Rp 5 Miliar – Rp 10 Miliar</label>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">3.2</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Sumber dana yang pernah digunakan untuk berproduksi</td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                                <input type="checkbox" name="data[kemampuan_finansial][sumber_dana_untuk_produksi][]" value="Modal awal yang disetor" {{ (isset($kemampuan_finansial['sumber_dana_untuk_produksi'])&&(is_array($kemampuan_finansial['sumber_dana_untuk_produksi'])&&in_array('Modal awal yang disetor', $kemampuan_finansial['sumber_dana_untuk_produksi'])) ? 'checked':'') }} class="form-check-input" id="kemampuan_finansial_sumber_dana_untuk_produksi_1">
                                <label class="form-check-label" for="kemampuan_finansial_sumber_dana_untuk_produksi_1">Modal awal yang disetor</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                                <input type="checkbox" name="data[kemampuan_finansial][sumber_dana_untuk_produksi][]" value="Pendapatan usaha/hasil Penjualan" {{ (isset($kemampuan_finansial['sumber_dana_untuk_produksi'])&&(is_array($kemampuan_finansial['sumber_dana_untuk_produksi'])&&in_array('Pendapatan usaha/hasil Penjualan', $kemampuan_finansial['sumber_dana_untuk_produksi'])) ? 'checked':'') }} class="form-check-input" id="kemampuan_finansial_sumber_dana_untuk_produksi_2">
                                <label class="form-check-label" for="kemampuan_finansial_sumber_dana_untuk_produksi_2">Pendapatan usaha/hasil Penjualan</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                                <input type="checkbox" name="data[kemampuan_finansial][sumber_dana_untuk_produksi][]" value="Pinjaman Bank" {{ (isset($kemampuan_finansial['sumber_dana_untuk_produksi'])&&(is_array($kemampuan_finansial['sumber_dana_untuk_produksi'])&&in_array('Pinjaman Bank', $kemampuan_finansial['sumber_dana_untuk_produksi'])) ? 'checked':'') }} class="form-check-input" id="kemampuan_finansial_sumber_dana_untuk_produksi_3">
                                <label class="form-check-label" for="kemampuan_finansial_sumber_dana_untuk_produksi_3">Pinjaman Bank</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                                <input type="checkbox" name="data[kemampuan_finansial][sumber_dana_untuk_produksi][]" value="Dana dari Investor yang bukan pendiri usaha" {{ (isset($kemampuan_finansial['sumber_dana_untuk_produksi'])&&(is_array($kemampuan_finansial['sumber_dana_untuk_produksi'])&&in_array('Dana dari Investor yang bukan pendiri usaha', $kemampuan_finansial['sumber_dana_untuk_produksi'])) ? 'checked':'') }} class="form-check-input" id="kemampuan_finansial_sumber_dana_untuk_produksi_4">
                                <label class="form-check-label" for="kemampuan_finansial_sumber_dana_untuk_produksi_4">Dana dari Investor yang bukan pendiri usaha</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                                <input type="checkbox" name="data[kemampuan_finansial][sumber_dana_untuk_produksi][]" value="Lainnya" {{ (isset($kemampuan_finansial['sumber_dana_untuk_produksi'])&&(is_array($kemampuan_finansial['sumber_dana_untuk_produksi'])&&in_array('Lainnya', $kemampuan_finansial['sumber_dana_untuk_produksi'])) ? 'checked':'') }} class="form-check-input checkbox_kemampuan_finansial_sumber_dana_untuk_produksi_lainnya" id="kemampuan_finansial_sumber_dana_untuk_produksi_5">
                                <label class="form-check-label" for="kemampuan_finansial_sumber_dana_untuk_produksi_5">Lainnya</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 kemampuan_finansial_sumber_dana_untuk_produksi_lainnya d-none">
                            <input type="text" name="data[kemampuan_finansial][sumber_dana_untuk_produksi_lainnya]" value="{{ (isset($kemampuan_finansial['sumber_dana_untuk_produksi_lainnya'])?$kemampuan_finansial['sumber_dana_untuk_produksi_lainnya']:'') }}" placeholder="Sebutkan" class="form-control form-control-sm">
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">3.3</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Kapasitas Pengelolaan Keuangan</td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                                <input type="checkbox" name="data[kemampuan_finansial][kapasitas_pengelolaan_keuangan][]" value="Rekening atas nama perusahaan" {{ (isset($kemampuan_finansial['kapasitas_pengelolaan_keuangan'])&&(is_array($kemampuan_finansial['kapasitas_pengelolaan_keuangan'])&&in_array('Rekening atas nama perusahaan', $kemampuan_finansial['kapasitas_pengelolaan_keuangan'])) ? 'checked':'') }} class="form-check-input" id="kemampuan_finansial_kapasitas_pengelolaan_keuangan_1">
                                <label class="form-check-label" for="kemampuan_finansial_kapasitas_pengelolaan_keuangan_1">Rekening atas nama perusahaan</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                                <input type="checkbox" name="data[kemampuan_finansial][kapasitas_pengelolaan_keuangan][]" value="Memiliki sistem akuntansi yang baik (memiliki pencatatan arus kas/ cash flow dan neraca keuangan)" {{ (isset($kemampuan_finansial['kapasitas_pengelolaan_keuangan'])&&(is_array($kemampuan_finansial['kapasitas_pengelolaan_keuangan'])&&in_array('Memiliki sistem akuntansi yang baik (memiliki pencatatan arus kas/ cash flow dan neraca keuangan)', $kemampuan_finansial['kapasitas_pengelolaan_keuangan'])) ? 'checked':'') }} class="form-check-input" id="kemampuan_finansial_kapasitas_pengelolaan_keuangan_2">
                                <label class="form-check-label" for="kemampuan_finansial_kapasitas_pengelolaan_keuangan_2">Memiliki sistem akuntansi yang baik (memiliki pencatatan arus kas/ cash flow dan neraca keuangan)</label>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
