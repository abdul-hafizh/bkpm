@php
    $profil_usaha    = ($umkm->survey_result->data && (isset($umkm->survey_result->data['profil_usaha'])&&$umkm->survey_result->data['profil_usaha']) ? $umkm->survey_result->data['profil_usaha'] : '');
@endphp

<!DOCTYPE html>
<html>
  <head>
    <title>PROFILE UMKM {{ (isset($profil_usaha['nama_usaha']) ? $profil_usaha['nama_usaha'] : '-') }}</title>
  </head>
  <body>
    <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-md-10 col-sm-12 col-xs-12">
            <div class="card">
              <div class="card-body">
                <h3 class="text-center">FORMULIR SURVEI KELOMPOK USAHA MENENGAH KECIL MIKRO (UMKM)</h3>
                <h3 class="text-center">MENDORONG INVESTASI BESAR BERMITRA DENGAN UMKM TAHUN 2022</h3>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title font-weight-bold">1. Profil Usaha</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <table class="table table-sm row">
                  <tbody class="col-12">
                    <tr class="row">
                      <td class="col-md-1 col-sm-3 col-xs-3">1.1</td>
                      <td class="col-md-3 col-sm-8 col-xs-8">Nama Usaha </td>
                      <td class="col-md-8 col-sm-12 col-xs-12"> {{ (isset($profil_usaha['nama_usaha']) ? $profil_usaha['nama_usaha'] : '-') }} </td>
                    </tr>
                    <tr class="row">
                      <td class="col-md-1 col-sm-3 col-xs-3">1.2</td>
                      <td class="col-md-3 col-sm-8 col-xs-8">Bentuk Badan Hukum</td>
                      <td class="col-md-8 col-sm-12 col-xs-12">
                        <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                              <input type="radio" name="data[profil_usaha][bentuk_badan_hukum]" value="Perseroan Terbatas (PT.)" checked class="form-check-input" id="profil_usaha_bentuk_badan_hukum_1">
                              <label class="form-check-label" for="profil_usaha_bentuk_badan_hukum_1">Perseroan Terbatas (PT.)</label>
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                              <input type="radio" name="data[profil_usaha][bentuk_badan_hukum]" value="CV" class="form-check-input" id="profil_usaha_bentuk_badan_hukum_2">
                              <label class="form-check-label" for="profil_usaha_bentuk_badan_hukum_2">CV</label>
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                              <input type="radio" name="data[profil_usaha][bentuk_badan_hukum]" value="UD." class="form-check-input" id="profil_usaha_bentuk_badan_hukum_3">
                              <label class="form-check-label" for="profil_usaha_bentuk_badan_hukum_3">UD.</label>
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                              <input type="radio" name="data[profil_usaha][bentuk_badan_hukum]" value="Firma" class="form-check-input" id="profil_usaha_bentuk_badan_hukum_4">
                              <label class="form-check-label" for="profil_usaha_bentuk_badan_hukum_4">Firma</label>
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                              <input type="radio" name="data[profil_usaha][bentuk_badan_hukum]" value="Lainnya" class="form-check-input" id="profil_usaha_bentuk_badan_hukum_5">
                              <label class="form-check-label" for="profil_usaha_bentuk_badan_hukum_5">Lainnya</label>
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12"></div>
                        </div>
                      </td>
                    </tr>
                    <tr class="row">
                      <td class="col-md-1 col-sm-3 col-xs-3">1.3</td>
                      <td class="col-md-3 col-sm-8 col-xs-8">Bidang Usaha</td>
                      <td class="col-md-8 col-sm-12 col-xs-12"> Konstruksi jaringan telekomunikasi </td>
                    </tr>
                    <tr class="row">
                      <td class="col-md-1 col-sm-3 col-xs-3">1.4</td>
                      <td class="col-md-3 col-sm-8 col-xs-8">NIB (Nomor Induk Berusaha)</td>
                      <td class="col-md-8 col-sm-12 col-xs-12">
                        <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group"> 0209010221813 </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr class="row">
                      <td class="col-md-1 col-sm-3 col-xs-3">1.5</td>
                      <td class="col-md-3 col-sm-8 col-xs-8">KBLI Usaha</td>
                      <td class="col-md-8 col-sm-12 col-xs-12">
                        <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <ul>
                              <li>[42219] KONSTRUKSI JARINGAN ELEKTRIKAL DAN TELEKOMUNIKASI LAINNYA</li>
                            </ul>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr class="row">
                      <td class="col-md-1 col-sm-3 col-xs-3">1.6</td>
                      <td class="col-md-3 col-sm-8 col-xs-8">Alamat Usaha </td>
                      <td class="col-md-8 col-sm-12 col-xs-12">
                        <table class="table table-sm">
                          <thead>
                            <tr>
                              <th style="width: 20%;"></th>
                              <th style="width: 78%;"></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Alamat </td>
                              <td> Perum. Griya Bukit Antang Sejahtera Blok B No. 18 Makassar </td>
                            </tr>
                            <tr>
                              <td>Negara </td>
                              <td> Indonesia </td>
                            </tr>
                            <tr>
                              <td>Provinsi </td>
                              <td> SULAWESI SELATAN </td>
                            </tr>
                            <tr>
                              <td>Kabupaten</td>
                              <td> KOTA MAKASSAR </td>
                            </tr>
                            <tr>
                              <td>Kecamatan</td>
                              <td> MANGGALA </td>
                            </tr>
                            <tr>
                              <td>Desa</td>
                              <td> BITOWO </td>
                            </tr>
                            <tr>
                              <td>Kode Pos</td>
                              <td> 90233 </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr class="row">
                      <td class="col-md-1 col-sm-3 col-xs-3">1.7</td>
                      <td class="col-md-3 col-sm-8 col-xs-8">Koordinat GPS Lokasi </td>
                      <td class="col-md-8 col-sm-12 col-xs-12">
                        <div id="boxOpenMap">
                          <div id="openMapView" class="sizeOpenMap openMapView" data-longitude="119.475483" data-latitude="-5.158208"></div>
                        </div>
                        <div class="row">
                          <div class="col-md-6 col-sm-12 col-xs-12"> Longitude: <br />
                            <input id="mapLng" type="hidden"> 119.475483
                          </div>
                          <div class="col-md-6 col-sm-12 col-xs-12"> Latitude: <br /> -5.158208 </div>
                        </div>
                      </td>
                    </tr>
                    <tr class="row">
                      <td class="col-md-1 col-sm-3 col-xs-3">1.8</td>
                      <td class="col-md-3 col-sm-8 col-xs-8">Nomor Telepon/Fax/Ponsel Perusahaan </td>
                      <td class="col-md-8 col-sm-12 col-xs-12">
                        <table class="table table-sm">
                          <thead>
                            <tr>
                              <th style="width: 20%;"></th>
                              <th style="width: 78%;"></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Telepon </td>
                              <td> 085396797979 </td>
                            </tr>
                            <tr>
                              <td>Fax</td>
                              <td> - </td>
                            </tr>
                            <tr>
                              <td>Ponsel </td>
                              <td> 085396797979 </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr class="row">
                      <td class="col-md-1 col-sm-3 col-xs-3">1.9</td>
                      <td class="col-md-3 col-sm-8 col-xs-8">Email Perusahaan </td>
                      <td class="col-md-8 col-sm-12 col-xs-12"> buanaciputralestari@gmail.com </td>
                    </tr>
                    <tr class="row">
                      <td class="col-md-1 col-sm-3 col-xs-3">1.10</td>
                      <td class="col-md-3 col-sm-8 col-xs-8">Akun Media Sosial/Website Perusahaan</td>
                      <td class="col-md-8 col-sm-12 col-xs-12">
                        <table class="table table-sm">
                          <thead>
                            <tr>
                              <th style="width: 20%;"></th>
                              <th style="width: 78%;"></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Website</td>
                              <td> - </td>
                            </tr>
                            <tr>
                              <td>Facebook</td>
                              <td> - </td>
                            </tr>
                            <tr>
                              <td>Instagram</td>
                              <td> - </td>
                            </tr>
                            <tr>
                              <td>Twitter</td>
                              <td> - </td>
                            </tr>
                            <tr>
                              <td>LinkedIn</td>
                              <td> - </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr class="row">
                      <td class="col-md-1 col-sm-3 col-xs-3">1.11</td>
                      <td class="col-md-3 col-sm-8 col-xs-8">Nama Contact Person </td>
                      <td class="col-md-8 col-sm-12 col-xs-12">
                        <div class="row">
                          <div class="col-md-6 col-sm-12 col-xs-12"> Nama : Saputra Jalil </div>
                          <div class="col-md-6 col-sm-12 col-xs-12"> Jabatan : Direktur </div>
                        </div>
                      </td>
                    </tr>
                    <tr class="row">
                      <td class="col-md-1 col-sm-3 col-xs-3">1.12</td>
                      <td class="col-md-3 col-sm-8 col-xs-8">Email/Nomor Telepon/Fax/Ponsel Contact Person </td>
                      <td class="col-md-8 col-sm-12 col-xs-12">
                        <table class="table table-sm">
                          <thead>
                            <tr>
                              <th style="width: 20%;"></th>
                              <th style="width: 78%;"></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Email</td>
                              <td> buanaciputralestari@gmail.com </td>
                            </tr>
                            <tr>
                              <td>Telepon</td>
                              <td> - </td>
                            </tr>
                            <tr>
                              <td>Fax</td>
                              <td> - </td>
                            </tr>
                            <tr>
                              <td>Ponsel</td>
                              <td> 085396797979 </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr class="row">
                      <td class="col-md-1 col-sm-3 col-xs-3">1.13</td>
                      <td class="col-md-3 col-sm-8 col-xs-8">Modal Usaha </td>
                      <td class="col-md-8 col-sm-12 col-xs-12"> 1,800,000,000 </td>
                    </tr>
                    <tr class="row">
                      <td class="col-md-1 col-sm-3 col-xs-3">1.14</td>
                      <td class="col-md-3 col-sm-8 col-xs-8">Jumlah Tenaga Kerja</td>
                      <td class="col-md-8 col-sm-12 col-xs-12">
                        <div class="row">
                          <div class="col-md-6 col-sm-12 col-xs-12"> Laki-laki : 6 </div>
                          <div class="col-md-6 col-sm-12 col-xs-12"> Perempuan : 2 </div>
                        </div>
                      </td>
                    </tr>
                    <tr class="row">
                      <td class="col-md-1 col-sm-3 col-xs-3">1.15</td>
                      <td class="col-md-3 col-sm-8 col-xs-8">Keanggotaan Asosiasi</td>
                      <td class="col-md-8 col-sm-12 col-xs-12"> - </td>
                    </tr>
                    <tr class="row">
                      <td class="col-md-1 col-sm-3 col-xs-3">1.16</td>
                      <td class="col-md-3 col-sm-8 col-xs-8"> **Penghargaan <i>(Award)</i>
                      </td>
                      <td class="col-md-8 col-sm-12 col-xs-12">
                        <div class="row text-center text-lg-left"></div>
                      </td>
                    </tr>
                    <tr class="row">
                      <td class="col-md-1 col-sm-3 col-xs-3">1.17</td>
                      <td class="col-md-3 col-sm-8 col-xs-8">**Sertifikasi (mutu, halal, dst.)</td>
                      <td class="col-md-8 col-sm-12 col-xs-12">
                        <div class="row">
                          <div class="col-md-2 col-sm-12 col-xs-12"> (a) Mutu </div>
                          <div class="col-md-10 col-sm-12 col-xs-12"></div>
                        </div>
                        <div class="row">
                          <div class="col-md-2 col-sm-12 col-xs-12"> (b) Halal </div>
                          <div class="col-md-10 col-sm-12 col-xs-12"></div>
                        </div>
                        <div class="row">
                          <div class="col-md-2 col-sm-12 col-xs-12"> (c) Lainnya </div>
                          <div class="col-md-10 col-sm-12 col-xs-12">
                            <div class="row text-center text-lg-left">
                              <div class="col-lg-3 col-md-4 col-6">
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr class="row">
                      <td class="col-md-1 col-sm-3 col-xs-3">1.18</td>
                      <td class="col-md-3 col-sm-8 col-xs-8">**Legalitas (NPWP, TDP, SIUP, NIB, dll.)</td>
                      <td class="col-md-8 col-sm-12 col-xs-12">
                        <div class="row">
                          <div class="col-md-2 col-sm-12 col-xs-12"> (a) SIUP </div>
                          <div class="col-md-10 col-sm-12 col-xs-12"></div>
                        </div>
                        <div class="row">
                          <div class="col-md-2 col-sm-12 col-xs-12"> (b) TDP </div>
                          <div class="col-md-10 col-sm-12 col-xs-12"></div>
                        </div>
                        <div class="row">
                          <div class="col-md-2 col-sm-12 col-xs-12"> (c) NPWP </div>
                          <div class="col-md-10 col-sm-12 col-xs-12"></div>
                        </div>
                        <div class="row">
                          <div class="col-md-2 col-sm-12 col-xs-12"> (d) NIB </div>
                          <div class="col-md-10 col-sm-12 col-xs-12">
                            <div class="row text-center text-lg-left">
                              <div class="col-lg-3 col-md-4 col-6">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-2 col-sm-12 col-xs-12"> (e) Lainnya </div>
                          <div class="col-md-10 col-sm-12 col-xs-12">
                            <div class="row text-center text-lg-left"></div>
                          </div>
                        </div>
                        <p class="text-justify">Catatan: **) Mohon sampaikan kepada surveyor kami dokumen-dokumen tersebut untuk didokumentasikan melalui media digital.</p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title font-weight-bold">2. Kemampuan Finansial</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <table class="table table-sm row">
                  <tbody class="col-12">
                    <tr class="row">
                      <td class="col-md-1 col-sm-3 col-xs-3">2.1</td>
                      <td class="col-md-3 col-sm-8 col-xs-8">Ketersediaan dana untuk berproduksi</td>
                      <td class="col-md-8 col-sm-12 col-xs-12">
                        <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                              <input type="radio" name="data[kemampuan_finansial][dana_produksi]" value="< Rp 500 juta" class="form-check-input" id="kemampuan_finansial_dana_produksi_1">
                              <label class="form-check-label" for="kemampuan_finansial_dana_produksi_1">(a) < Rp 500 juta </label>
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                              <input type="radio" name="data[kemampuan_finansial][dana_produksi]" value="Rp 500 juta – Rp 1 Miliar" class="form-check-input" id="kemampuan_finansial_dana_produksi_2">
                              <label class="form-check-label" for="kemampuan_finansial_dana_produksi_2">(b) Rp 500 juta – Rp 1 Miliar</label>
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                              <input type="radio" name="data[kemampuan_finansial][dana_produksi]" value="Rp 1 Miliar – Rp 5 Miliar" checked class="form-check-input" id="kemampuan_finansial_dana_produksi_3">
                              <label class="form-check-label" for="kemampuan_finansial_dana_produksi_3">(c) Rp 1 Miliar – Rp 5 Miliar</label>
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                              <input type="radio" name="data[kemampuan_finansial][dana_produksi]" value="Rp 5 Miliar – Rp 10 Miliar" class="form-check-input" id="kemampuan_finansial_dana_produksi_4">
                              <label class="form-check-label" for="kemampuan_finansial_dana_produksi_4">(d) Rp 5 Miliar – Rp 10 Miliar</label>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr class="row">
                      <td class="col-md-1 col-sm-3 col-xs-3">2.2</td>
                      <td class="col-md-3 col-sm-8 col-xs-8">Sumber dana yang pernah digunakan untuk berproduksi</td>
                      <td class="col-md-8 col-sm-12 col-xs-12">
                        <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                              <input type="checkbox" name="data[kemampuan_finansial][sumber_dana_untuk_produksi]" value="Modal awal yang disetor" checked class="form-check-input" id="kemampuan_finansial_sumber_dana_untuk_produksi_1">
                              <label class="form-check-label" for="kemampuan_finansial_sumber_dana_untuk_produksi_1">Modal awal yang disetor</label>
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                              <input type="checkbox" name="data[kemampuan_finansial][sumber_dana_untuk_produksi]" value="Pendapatan usaha/hasil Penjualan" class="form-check-input" id="kemampuan_finansial_sumber_dana_untuk_produksi_2">
                              <label class="form-check-label" for="kemampuan_finansial_sumber_dana_untuk_produksi_2">Pendapatan usaha/hasil Penjualan</label>
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                              <input type="checkbox" name="data[kemampuan_finansial][sumber_dana_untuk_produksi]" value="Pinjaman Bank" class="form-check-input" id="kemampuan_finansial_sumber_dana_untuk_produksi_3">
                              <label class="form-check-label" for="kemampuan_finansial_sumber_dana_untuk_produksi_3">Pinjaman Bank</label>
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                              <input type="checkbox" name="data[kemampuan_finansial][sumber_dana_untuk_produksi]" value="Dana dari Investor yang bukan pendiri usaha" checked class="form-check-input" id="kemampuan_finansial_sumber_dana_untuk_produksi_4">
                              <label class="form-check-label" for="kemampuan_finansial_sumber_dana_untuk_produksi_4">Dana dari Investor yang bukan pendiri usaha</label>
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                              <input type="checkbox" name="data[kemampuan_finansial][sumber_dana_untuk_produksi]" value="Lainnya" cl class="form-check-input" id="kemampuan_finansial_sumber_dana_untuk_produksi_5">
                              <label class="form-check-label" for="kemampuan_finansial_sumber_dana_untuk_produksi_5">Lainnya</label>
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12 kemampuan_finansial_sumber_dana_untuk_produksi_lainnya d-none"></div>
                        </div>
                      </td>
                    </tr>
                    <tr class="row">
                      <td class="col-md-1 col-sm-3 col-xs-3">2.3</td>
                      <td class="col-md-3 col-sm-8 col-xs-8">Kapasitas Pengelolaan Keuangan</td>
                      <td class="col-md-8 col-sm-12 col-xs-12">
                        <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                              <input type="checkbox" name="data[kemampuan_finansial][kapasitas_pengelolaan_keuangan]" value="Rekening atas nama perusahaan" checked class="form-check-input" id="kemampuan_finansial_kapasitas_pengelolaan_keuangan_1">
                              <label class="form-check-label" for="kemampuan_finansial_kapasitas_pengelolaan_keuangan_1">Rekening atas nama perusahaan</label>
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                              <input type="checkbox" name="data[kemampuan_finansial][kapasitas_pengelolaan_keuangan]" value="Memiliki sistem akuntansi yang baik (memiliki pencatatan arus kas/ cash flow dan neraca keuangan)" checked class="form-check-input" id="kemampuan_finansial_kapasitas_pengelolaan_keuangan_2">
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
            <div class="card">
              <div class="card-header">
                <h3 class="card-title font-weight-bold">3. Profil Produk Barang/Jasa yang Dihasilkan</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <table class="table table-sm">
                  <thead class="d-none d-md-block">
                    <tr class="row">
                      <th class="col-md-3 col-sm-12 col-xs-12">Produk Barang/Jasa</th>
                      <th class="col-md-4 col-sm-12 col-xs-12">Deskripsi & Spesifikasi Produk Barang/Jasa</th>
                      <th class="col-md-2 col-sm-12 col-xs-12">Kapasitas Produksi per bulan</th>
                      <th class="col-md-3 col-sm-12 col-xs-12">**Foto/Dokumen</th>
                    </tr>
                  </thead>
                  <tbody class="">
                    <tr class="row">
                      <td class="col-md-3 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Produk Barang/Jasa</label>
                        <br class="d-md-none d-lg-none d-xl-none" />Penarikan FOC
                      </td>
                      <td class="col-md-4 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Deskripsi & Spesifikasi Produk Barang/Jasa</label>
                        <br class="d-md-none d-lg-none d-xl-none" /> Pembangunan jaringan
                      </td>
                      <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Kapasitas Produksi per bulan</label>
                        <br class="d-md-none d-lg-none d-xl-none" /> 10.000 meter
                      </td>
                      <td class="col-md-3 col-sm-12 col-xs-12">
                        <div class="row">
                          <div class="col-12 d-md-none d-lg-none d-xl-none">
                            <label>**Foto/Dokumen</label>
                          </div>
                          <div class="col-12 mt-2">
                            <div class="row text-center text-lg-left">
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr class="row">
                      <td class="col-md-3 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Produk Barang/Jasa</label>
                        <br class="d-md-none d-lg-none d-xl-none" />Instalasi wifi
                      </td>
                      <td class="col-md-4 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Deskripsi & Spesifikasi Produk Barang/Jasa</label>
                        <br class="d-md-none d-lg-none d-xl-none" /> Pemasangan wifi di rumah
                      </td>
                      <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Kapasitas Produksi per bulan</label>
                        <br class="d-md-none d-lg-none d-xl-none" /> 3.000 titik
                      </td>
                      <td class="col-md-3 col-sm-12 col-xs-12">
                        <div class="row">
                          <div class="col-12 d-md-none d-lg-none d-xl-none">
                            <label>**Foto/Dokumen</label>
                          </div>
                          <div class="col-12 mt-2">
                            <div class="row text-center text-lg-left">                              
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <p class="text-justify">Catatan: **)Mohon sampaikan kepada surveyor foto produk ataupun dokumen-mengenai produk barang/jasa yang dilayani untuk didokumentasikan.</p>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title font-weight-bold">4. Profil Pengelolaan Usaha</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <table class="table table-sm row">
                  <tbody class="col-12">
                    <tr class="row">
                      <td class="col-md-1 col-sm-3 col-xs-3">4.1</td>
                      <td class="col-md-3 col-sm-8 col-xs-8">Pengelolaan Usaha</td>
                      <td class="col-md-8 col-sm-12 col-xs-12">
                        <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                              <input type="radio" name="data[profil_pengelolaan_usaha][kepemilikan]" value="Sendiri" class="form-check-input" id="kepemilikan_usaha_sendiri">
                              <label class="form-check-label" for="kepemilikan_usaha_sendiri">(a) Sendiri;</label>
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                              <input type="radio" name="data[profil_pengelolaan_usaha][kepemilikan]" value="Keluarga" checked class="form-check-input" id="kepemilikan_usaha_keluarga">
                              <label class="form-check-label" for="kepemilikan_usaha_keluarga">(b) Keluarga;</label>
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                              <input type="radio" name="data[profil_pengelolaan_usaha][kepemilikan]" value="Dengan investor lain yang bukan keluarga" class="form-check-input" id="kepemilikan_usaha_orang_lain">
                              <label class="form-check-label" for="kepemilikan_usaha_orang_lain">(c) Dengan investor lain yang bukan keluarga;</label>
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                              <input type="radio" name="data[profil_pengelolaan_usaha][kepemilikan]" value="Lainnya" class="form-check-input" id="kepemilikan_usaha_lainya">
                              <label class="form-check-label" for="kepemilikan_usaha_lainya">(d) Lainnya;</label>
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12 "></div>
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
                                <input type="text" name="data[profil_pengelolaan_usaha][tahun_berdiri]" value="2020" placeholder="Tahun Berdiri" class="form-control form-control-sm">
                              </td>
                            </tr>
                            <tr>
                              <td>(b) Usia:</td>
                              <td>
                                <input type="text" name="data[profil_pengelolaan_usaha][usia]" value="3" placeholder="Usia" class="form-control form-control-sm">
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
                              <input type="radio" name="data[profil_pengelolaan_usaha][omzet]" value="≤ Rp 2 miliar" checked class="form-check-input" id="profil_pengelolaan_usaha_omzet_1">
                              <label class="form-check-label" for="profil_pengelolaan_usaha_omzet_1">(a) ≤ Rp 2 miliar;</label>
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                              <input type="radio" name="data[profil_pengelolaan_usaha][omzet]" value="Rp 2 miliar – Rp 15 miliar" class="form-check-input" id="profil_pengelolaan_usaha_omzet_2">
                              <label class="form-check-label" for="profil_pengelolaan_usaha_omzet_2">(b) Rp 2 miliar – Rp 15 miliar;</label>
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                              <input type="radio" name="data[profil_pengelolaan_usaha][omzet]" value="Rp 15 miliar – Rp 50 miliar" class="form-check-input" id="profil_pengelolaan_usaha_omzet_3">
                              <label class="form-check-label" for="profil_pengelolaan_usaha_omzet_3">(c) Rp 15 miliar – Rp 50 miliar;</label>
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                              <input type="radio" name="data[profil_pengelolaan_usaha][omzet]" value="Sebutkan" class="form-check-input" id="profil_pengelolaan_usaha_omzet_5">
                              <label class="form-check-label" for="profil_pengelolaan_usaha_omzet_5">(d) Sebutkan;</label>
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12"></div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title font-weight-bold">5. Pengalaman Ekspor</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <table class="table table-sm">
                  <thead class="d-none d-md-block">
                    <tr class="row">
                      <th class="col-md-4 col-sm-12 col-xs-12">Jenis Produk</th>
                      <th class="col-md-2 col-sm-12 col-xs-12">Negara Tujuan Ekspor</th>
                      <th class="col-md-4 col-sm-12 col-xs-12">Nilai Ekspor</th>
                      <th class="col-md-2 col-sm-12 col-xs-12">Tahun</th>
                    </tr>
                  </thead>
                  <tbody class=""></tbody>
                </table>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title font-weight-bold">6. Fasilitas Usaha</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <table class="table table-sm">
                  <thead class="d-none d-md-block">
                    <tr class="row">
                      <th class="col-md-3 col-sm-12 col-xs-12">Jenis Kegiatan Kerja</th>
                      <th class="col-md-6 col-sm-12 col-xs-12">Peralatan/Mesin yang Digunakan</th>
                      <th class="col-md-3 col-sm-12 col-xs-12">Perkiraan Nilai (Rp)</th>
                    </tr>
                  </thead>
                  <tbody class="">
                    <tr class="row">
                      <td class="col-md-3 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Jenis Kegiatan Kerja</label>
                        <br class="d-md-none d-lg-none d-xl-none" /> Penarikan FOC
                      </td>
                      <td class="col-md-6 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Peralatan/Mesin yang Digunakan</label>
                        <br class="d-md-none d-lg-none d-xl-none" /> Mobil, Tangga, Savety belt, Helm, sepatu, sarung tangan
                      </td>
                      <td class="col-md-3 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Perkiraan Nilai (Rp)</label>
                        <br class="d-md-none d-lg-none d-xl-none" /> 300,000,000
                      </td>
                    </tr>
                    <tr class="row">
                      <td class="col-md-3 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Jenis Kegiatan Kerja</label>
                        <br class="d-md-none d-lg-none d-xl-none" /> Intalasi wifi
                      </td>
                      <td class="col-md-6 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Peralatan/Mesin yang Digunakan</label>
                        <br class="d-md-none d-lg-none d-xl-none" /> Motor, tangga, savety belt, helm, spliccer
                      </td>
                      <td class="col-md-3 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Perkiraan Nilai (Rp)</label>
                        <br class="d-md-none d-lg-none d-xl-none" /> 70,000,000
                      </td>
                    </tr>
                  </tbody>
                </table>
                <p class="text-justify">Catatan: Mohon menjelaskan aset yang dimiliki berdasarkan urut-urutan kegiatan yang dijalankan untuk menghasilkan produk/jasa.</p>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title font-weight-bold">7. Pengalaman Kerja Sama/Kemitraan (maksimal 5 kerja sama/kemitraan Terakhir)</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <table class="table table-sm">
                  <thead class="d-none d-md-block">
                    <tr class="row">
                      <th class="col-md-3 col-sm-12 col-xs-12">Nama Mitra/Buyer</th>
                      <th class="col-md-2 col-sm-12 col-xs-12">**Bentuk Kerja Sama/kemitraan</th>
                      <th class="col-md-1 col-sm-12 col-xs-12">Tahun</th>
                      <th class="col-md-2 col-sm-12 col-xs-12">Nilai Kerja Sama</th>
                      <th class="col-md-4 col-sm-12 col-xs-12">Keterangan</th>
                    </tr>
                  </thead>
                  <tbody class="">
                    <tr class="row">
                      <td class="col-md-3 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Nama Mitra/Buyer</label>
                        <br class="d-md-none d-lg-none d-xl-none" /> PT Indonesia Connet Plus
                      </td>
                      <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">**Bentuk Kerja Sama/kemitraan</label>
                        <br class="d-md-none d-lg-none d-xl-none" /> Rekanan/kerja sama operasional
                      </td>
                      <td class="col-md-1 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Tahun</label>
                        <br class="d-md-none d-lg-none d-xl-none" /> 2020
                      </td>
                      <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Nilai Kerja Sama</label>
                        <br class="d-md-none d-lg-none d-xl-none" /> 8,000,000,000
                      </td>
                      <td class="col-md-4 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Keterangan</label>
                        <br class="d-md-none d-lg-none d-xl-none" />
                      </td>
                    </tr>
                  </tbody>
                </table>
                <p class="text-justify">Catatan: **) Bentuk kerja sama/kemitraan dapat berupa inti-plasma, subkontrak, waralaba, perdagangan umum, distribusi dan keagenan, rantai pasok, bagi hasil, kerja sama operasional, usaha patungan, penyumberluaran (outsourcing), dan pola kemitraan lainnya.</p>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title font-weight-bold">8. Hal-hal lain yang perlu disampaikan kepada calon mitra Usaha Besar:</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> - </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-body">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th style="width: 50%;"></th>
                      <th style="width: 50%;"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Dibuat di : Makassar</td>
                      <td>tanggal : 03-06-2022</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title font-weight-bold">Responden</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th style="width: 20%;"></th>
                      <th style="width: 2%;"></th>
                      <th style="width: 78%;"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Nama </td>
                      <td>:</td>
                      <td> ADRIAN HARIADI </td>
                    </tr>
                    <tr>
                      <td>Jabatan</td>
                      <td>:</td>
                      <td> MANAJER PEMBANGUNAN </td>
                    </tr>
                    <tr>
                      <td>Nomor Ponsel </td>
                      <td>:</td>
                      <td> 081355680823 </td>
                    </tr>
                    <tr>
                      <td>Email </td>
                      <td>:</td>
                      <td> buanaciputralestari@gmail.com </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title font-weight-bold">Catatan Revisi</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body p-0">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th style="width: 1%;">No</th>
                      <th style="width: 64%;">Message</th>
                      <th style="width: 15%;">By</th>
                      <th style="width: 19%;">Created At</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-center" colspan="4">
                        <i>Data empty</i>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-12"></div>
                </div>
                <div class="row">
                  <div class="col-6"></div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="status_survey">Status</label>
                      <br /> Bersedia
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>