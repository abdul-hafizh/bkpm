<div id="accordion">
    @php
        $totalUmkm = 0;
    @endphp
    @foreach($provinces as $province)
        @php
            \DB::statement("SET SQL_MODE=''");
            $umkm_kabupatens = \Plugins\BkpmUmkm\Models\CompanyModel::select('companies.id_kabupaten')->where([
                'companies.category'    => CATEGORY_UMKM,
                'companies.status'      => UMKM_POTENSIAL,
                'companies.id_provinsi' => $province->kode_provinsi
            ])->whereHas('survey', function($q) use($periode){
                $q->whereYear('surveys.created_at', $periode);
            })->where('companies.id_kabupaten', '<>', '')->groupBy('companies.id_kabupaten')->get()->map(function($q){ return $q->id_kabupaten; })->toArray();
            \DB::statement("SET SQL_MODE=only_full_group_by");
            $umkm_kabupatens = \SimpleCMS\Wilayah\Models\KabupatenModel::whereIn('kode_kabupaten', $umkm_kabupatens)->orderBy('nama_kabupaten', 'asc')->cursor();
        @endphp

        <div class="card">
            <div class="card-header">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseUmkmProvince{{ $province->kode_provinsi }}" aria-expanded="true">
                    <h5 class="mb-0">{{ $province->nama_provinsi }} - {{ $periode }}</h5>
                </a>
            </div>
            <div id="collapseUmkmProvince{{ $province->kode_provinsi }}" class="panel-collapse in collapse show">
                <div class="card-body p-0">
                    @php $totalKabupaten = 0; @endphp
                    @foreach ($umkm_kabupatens as $k_uk => $umkm_kabupaten)
                        @php
                            $umkm_potensial = \Plugins\BkpmUmkm\Models\CompanyModel::where([
                                'companies.category'    => CATEGORY_UMKM,
                                'companies.status'      => UMKM_POTENSIAL,
                                'companies.id_provinsi' => $province->kode_provinsi,
                                'companies.id_kabupaten' => $umkm_kabupaten->kode_kabupaten
                            ])->whereHas('survey', function($q) use($periode){
                                $q->whereYear('surveys.created_at', $periode);
                            })->cursor();
                            $no = 1;
                            $total = $umkm_potensial->count();
                            $totalUmkm += $total;
                            $totalKabupaten += $total;
                        @endphp
                        <table class="table table-sm table-bordered">
                            <thead>
                            <tr>
                                <th colspan="5" class="bg-lightblue"><h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> {{ $umkm_kabupaten->nama_kabupaten }} - Total: {{ number_format($total,0,",",".") }}</h5></th>
                            </tr>
                            <tr>
                                <th style="width: 1%;">No</th>
                                <th style="width: 40%;">Nama UMKM</th>
                                <th style="width: 35%;">Alamat</th>
                                <th style="width: 10%;">Provinsi</th>
                                <th style="width: 19%;">Kabupaten</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if ($total)
                                @foreach($umkm_potensial as $up)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{!! shortcodes($up->name) !!}</td>
                                        <td>{{ $up->address }}</td>
                                        <td>{{ $province->nama_provinsi }}</td>
                                        <td>{{ $umkm_kabupaten->nama_kabupaten }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <i>Data empty</i>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    @endforeach

                    @php
                        $umkm_potensial = \Plugins\BkpmUmkm\Models\CompanyModel::where([
                            'companies.category'    => CATEGORY_UMKM,
                            'companies.status'      => UMKM_POTENSIAL,
                            'companies.id_provinsi' => $province->kode_provinsi,
                            'companies.id_kabupaten' => ''
                        ])->whereHas('survey', function($q) use($periode){
                            $q->whereYear('surveys.created_at', $periode);
                        })->cursor();
                        $no = 1;
                        $total = $umkm_potensial->count();
                        $totalUmkm += $total;
                        $totalKabupaten += $total;
                    @endphp
                    @if($total)
                        <table class="table table-sm table-bordered">
                            <thead>
                            <tr>
                                <th colspan="5" class="bg-lightblue"><h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Tidak ada kabupaten - Total: {{ number_format($total,0,",",".") }}</h5></th>
                            </tr>
                            <tr>
                                <th style="width: 1%;">No</th>
                                <th style="width: 40%;">Nama UMKM</th>
                                <th style="width: 35%;">Alamat</th>
                                <th style="width: 10%;">Provinsi</th>
                                <th style="width: 19%;">Kabupaten</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if ($total)
                                @foreach($umkm_potensial as $up)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{!! shortcodes($up->name) !!}</td>
                                        <td>{{ $up->address }}</td>
                                        <td>{{ $province->nama_provinsi }}</td>
                                        <td>{{ $umkm_kabupaten->nama_kabupaten }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <i>Data empty</i>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    @endif

                </div>
                <div class="card-footer bg-white">
                    <div class="row">
                        <div class="col-6 text-center">
                            <h6>Sub Total</h6>
                        </div>
                        <div class="col-6 text-right">
                            <strong>{{ number_format($totalKabupaten,0,",",".") }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-6 text-center">
                    Jumlah Total UMKM - {{ $periode }}
                </div>
                <div class="col-6 text-right">
                    <strong>{{ $totalUmkm }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>
