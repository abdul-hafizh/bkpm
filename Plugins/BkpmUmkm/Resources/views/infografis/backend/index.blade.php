@extends('core::layouts.backend')
@section('title', $title)
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')
    {!! library_datatables('css') !!}
@endpush
@section('layout')
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/highcharts-3d.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/accessibility.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<style>
		@import "https://code.highcharts.com/css/highcharts.css";

		.highcharts-figure,
		.highcharts-data-table table {
			min-width: 310px;
			max-width: 800px;
			margin: 1em auto;
		}

		.highcharts-data-table table {
			font-family: Verdana, sans-serif;
			border-collapse: collapse;
			border: 1px solid #ebebeb;
			margin: 10px auto;
			text-align: center;
			width: 100%;
			max-width: 500px;
		}

		.highcharts-data-table caption {
			padding: 1em 0;
			font-size: 1.2em;
			color: #555;
		}

		.highcharts-data-table th {
			font-weight: 600;
			padding: 0.5em;
		}

		.highcharts-data-table td,
		.highcharts-data-table th,
		.highcharts-data-table caption {
			padding: 0.5em;
		}

		.highcharts-data-table thead tr,
		.highcharts-data-table tr:nth-child(even) {
			background: #f8f8f8;
		}

		.highcharts-data-table tr:hover {
			background: #f1f7ff;
		}

		.nominal {
			position: relative;
			text-align: center;
		}

		th {
			background-color: #0b56a4;        
			color: #fff;
		}

		h4 { font-family: Righteous; font-size: 30px; font-style: normal; font-variant: normal; font-weight: 580; line-height: 30.4px; color: #086634; } 
		h5 { font-family: Righteous; font-size: 30px; font-style: normal; font-variant: normal; font-weight: 580; line-height: 30.4px; color: #2c2e83; } 
		h6 { font-family: Montserrat; font-size: 24px; font-style: normal; font-variant: normal; font-weight: 700; line-height: 26.4px; color: #ffffff; } 
		h7 { font-family: Montserrat; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 500; color: #ffffff; }  
		isi1 { font-family: Montserrat; font-size: 22px; font-style: normal; font-variant: normal; font-weight: 600; color: #ffffff; margin:10px}   
		isi2 { font-family: Montserrat; font-size: 16px; font-style: normal; font-variant: normal; font-weight: 500; color: #ffffff; margin:10px }     
		
		.ol-popup {
			position: absolute;
			background-color: white;
			/*--webkit-filter: drop-shadow(0 1px 4px rgba(0,0,0,0.2));*/
			filter: drop-shadow(0 1px 4px rgba(0,0,0,0.2));
			padding: 15px;
			border-radius: 10px;
			border: 1px solid #cccccc;
			bottom: 12px;
			left: -50px;
			min-width: 480px;
		}

		.ol-popup:after, .ol-popup:before {
			top: 100%;
			border: solid transparent;
			content: " ";
			height: 0;
			width: 0;
			position: absolute;
			pointer-events: none;
		}

		.ol-popup:after {
			border-top-color: white;
			border-width: 10px;
			left: 48px;
			margin-left: -10px;
		}

		.ol-popup:before {
			border-top-color: #cccccc;
			border-width: 11px;
			left: 48px;
			margin-left: -11px;
		}

		#mapa {
			background-image:url('https://kemitraan.fasilitasi.id/uploads/img/bck.jpeg')  ;
			object-fit: fill;
		}

		.logobkpm {
			background-image:url('https://kemitraan.fasilitasi.id/uploads/img/logobkpm.png')  ;
		}  
		
	</style>

    <div class="container-fluid nominal">
		@foreach ($target_realisasi as $v)
			<div class="row">
				<div class="col-xl-4 col-12"> 
					<div class="card">
						<div class="card-content">
							<div class="card-body" style="background-color: #8ec045">
								<div class="media d-flex">
									<div class="align-self-center">
										<i class="far fa-building primary float-left" style="font-size: 60px; opacity: 0.2;"></i>
									</div>
									<div class="media-body text-right">
										<span style="color: #fff; font-size: 50px; font-weight: bold">{{ $v->target_UB }}</span><br>
										<span style="color: #fff; font-size: 25px;">Target Usaha Besar</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-12">
					<div class="card">
						<div class="card-content">
							<div class="card-body" style="background-color: #8ec045">
								<div class="media d-flex">
									<div class="align-self-center">
										<i class="far fa-building primary float-left" style="font-size: 60px; opacity: 0.2;"></i>
									</div>
									<div class="media-body text-right">
										<span style="color: #fff; font-size: 50px; font-weight: bold">{{ $v->realisasi_ub }}</span><br>
										<span style="color: #fff; font-size: 25px;">Realisasi Usaha Besar</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-12">
					<div class="card">
						<div class="card-content">
							<div class="card-body" style="background-color: #8ec045">
								<div class="media d-flex">
									<div class="align-self-center">
										<i class="fa fa-percent primary float-left" style="font-size: 60px; opacity: 0.2;"></i>
									</div>
									<div class="media-body text-right">
										<span style="color: #fff; font-size: 50px; font-weight: bold">{{ number_format($v->UB_PERCENT, 2) }}%</span><br>
										<span style="color: #fff; font-size: 25px;">Persentase Usaha Besar</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xl-4 col-12"> 
					<div class="card">
						<div class="card-content">
							<div class="card-body" style="background-color: #325bb3">
								<div class="media d-flex">
									<div class="align-self-center">
										<i class="fa fa-money primary float-left" style="font-size: 60px; opacity: 0.2;"></i>
									</div>
									<div class="media-body text-right">
										<span style="color: #fff; font-size: 50px; font-weight: bold">{{ $v->target_realisasi/1000000000000 }} Triliun</span><br>
										<span style="color: #fff; font-size: 25px;">Target Capaian Realisasi Kemitraan</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-12">
					<div class="card">
						<div class="card-content">
							<div class="card-body" style="background-color: #325bb3">
								<div class="media d-flex">
									<div class="align-self-center">
										<i class="fa fa-money primary float-left" style="font-size: 60px; opacity: 0.2;"></i>
									</div>
									<div class="media-body text-right">
										<span style="color: #fff; font-size: 50px; font-weight: bold">
											<a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.kemitraan.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.kemitraan.index", ['in-modal' => encrypt_decrypt('modal'), 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.total_realisasi_nilai_kontrak') .'"' : '') !!}>
												{{ number_format($v->realisasi_kemitraan/1000000000000, 2) }} Triliun
											</a>
										</span>
										<br>
										<span style="color: #fff; font-size: 25px;">Realisasi Kemitraan</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-12">
					<div class="card">
						<div class="card-content">
							<div class="card-body" style="background-color: #325bb3">
								<div class="media d-flex">
									<div class="align-self-center">
										<i class="fa fa-percent primary float-left" style="font-size: 60px; opacity: 0.2;"></i>
									</div>
									<div class="media-body text-right">
										<span style="color: #fff; font-size: 50px; font-weight: bold">{{ number_format($v->REALISASI_PERCENT, 2) }}%</span><br>
										<span style="color: #fff; font-size: 25px;">Persentase Realisasi Kemitraan</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endforeach

		<div class="row">
			<div class="col-md-12">
                <div class="card">
                    <div class="card-body">
						<div class="row">
							<div class="col-sm-2 col-12"></div>
							<div class="col-xl-7 col-12">
								<div >
									<div class="text-center">
										<h5><span>Total Nilai Komitmen Berdasarkan Usaha Besar (dalam miliyar)</span></h5>
									</div>
								</div>
							</div>
							<div class="col-sm-2 col-12"></div>
						</div> <hr/>
						<div id="container-1"></div>
                    </div>
                </div>
            </div>
    	</div>
		<div class="row">
			<div class="col-md-12">
                <div class="card">
                    <div class="card-body">
						<div class="row">
							<div class="col-sm-2 col-12"></div>
							<div class="col-xl-7 col-12">
								<div >
									<div class="text-center">
										<h5><span>Total Nilai Komitmen Berdasarkan Sektor Usaha Yang Dimitrakan (dalam miliyar)</span></h5>
									</div>
								</div>
							</div>
							<div class="col-sm-2 col-12"></div>
						</div> <hr/>
						<div id="container-2"></div>
                    </div>
                </div>
            </div>
    	</div>
		<div class="row">
			<div class="col-lg-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
						<div class="row">
							<div class="col-sm-2 col-12"></div>
							<div class="col-xl-7 col-12">
								<div >
									<div class="text-center">
										<h5><span>5 Usaha Besar Dengan Nilai Komitmen Tertinggi</span></h5>
									</div>
								</div>
							</div>
							<div class="col-sm-2 col-12"></div>
						</div> <hr/>
						<div id="container-3"></div>
                    </div>
                </div>
            </div>
			<div class="col-lg-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
						<div class="row">
							<div class="col-sm-2 col-12"></div>
							<div class="col-xl-7 col-12">
								<div >
									<div class="text-center">
										<h5><span>Total Nilai Komitmen Berdasarkan Jenis Kebutuhan</span></h5>
									</div>
								</div>
							</div>
							<div class="col-sm-2 col-12"></div>
						</div> <hr/>
						<div id="container-4"></div>
                    </div>
                </div>
            </div>
    	</div>
		<div class="row">
            <div class="col-md-12">
				<div class="col-lg-12"  >
					<div class="bg-image" style="background-image:url('https://kemitraan.fasilitasi.id/uploads/img/bck.jpeg');background-repeat:no-repeat;background-size: cover; " >

						<div class="row">
							<div class="col-sm-2 col-12">
								<div>
									<div class="my-1 text-center ">
										<img src="https://kemitraan.fasilitasi.id/uploads/img/logobkpm.png"  width="120" class="img-fluid">                            
									</div>
								</div>
							</div>

							<div class="col-xl-7 col-12">
								<div >
									<div class="text-center ">
									<h4><span>SEBARAN REALISASI & POTENSI</span><bR> </h4>   
									<h5><span>KEMITRAAN USAHA BESAR (WILAYAH)</span>     </h5>    
									</div>
								</div>
							</div>

							<div class="col-sm-3 col-12">
								<div >
									<div class="text-center my-1 img-fluid">
										<img src="https://kemitraan.fasilitasi.id/uploads/img/pulih_logo1.png"  width="100" >
									</div>
								</div>
							</div>
						</div>
						
						<div class="card-content">
							<div class="card-body">
								<div class="table-responsive">
									<div class="box-body">
										<div id="map" style="width:auto; height:500px"></div>
										<div id="popup" class="ol-popup">
											<a href="#" id="popup-closer" class="ol-popup-closer"></a>
											<div id="popup-content"></div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-12">
								<table width="100%">	
									<tr>
										<td style="background-color: #1b1e3d; color:#fff; font-weight: bold; font-size: 24px">DW 1</td>
										<td style="background-color: #2b5d2a; color:#fff; font-weight: bold; font-size: 24px">DW 2</td>
										<td style="background-color: #1e4495; color:#fff; font-weight: bold; font-size: 24px">DW 3</td>
										<td style="background-color: #8ec045; color:#fff; font-weight: bold; font-size: 24px">DW 4</td>
										<td style="background-color: #2bad6f; color:#fff; font-weight: bold; font-size: 24px">DW 5</td>
									</tr>	
									<tr>
										<td style="background-color: #d7ebe9;" colspan="5">&nbsp;</td>
									</tr>							
									<tr>
										<td style="background-color: #1b1e3d; color:#fff; height: 80px;">
											<div class="text-left">
												@foreach ($data_dw1 as $v)
												<table width="100%">
													<tr>
														<td><h7 style="margin:10px">Nilai Komitmen</h7></td>
														<td style="text-align:right"><h7 style="margin:10px">{{ $v->JUM_UB }} Usaha Besar</h7></td>
													</tr>    
													<tr> 
														<td><isi1> Rp 
															@if (Str::length($v->nilai) > 12)
																{{ number_format($v->nilai/1000000000000, 2) }} T 															
															@elseif (Str::length($v->nilai) <= 12)
																{{ number_format($v->nilai/1000000000, 1) }} M 
															@endif
														</isi1></td>
														<td style="text-align:right"><isi2>{{ $v->JUM_UMKM }} UMKM</isi2></td>
													</tr>
												</table>    
												@endforeach
											</div>
										</td>
										<td style="background-color: #2b5d2a; color:#fff; height: 80px;">
											<div class="text-left">
												@foreach ($data_dw2 as $v)
												<table width="100%">
													<tr>
														<td><h7 style="margin:10px">Nilai Komitmen</h7></td>
														<td style="text-align:right"><h7 style="margin:10px">{{ $v->JUM_UB }} Usaha Besar</h7></td>
													</tr>    
													<tr> 
														<td><isi1> Rp 
															@if (Str::length($v->nilai) > 12)
																{{ number_format($v->nilai/1000000000000, 2) }} T 
															@elseif (Str::length($v->nilai) <= 12)
																{{ number_format($v->nilai/1000000000, 1) }} M 
															@endif
														</isi1></td>
														<td style="text-align:right"><isi2>{{ $v->JUM_UMKM }} UMKM</isi2></td>
													</tr>
												</table>    
												@endforeach  
											</div>
										</td>
										<td style="background-color: #1e4495; color:#fff; height: 80px;">
											<div class="text-left">
												@foreach ($data_dw3 as $v)
												<table width="100%">
													<tr>
														<td><h7 style="margin:10px">Nilai Komitmen</h7></td>
														<td style="text-align:right"><h7 style="margin:10px">{{ $v->JUM_UB }} Usaha Besar</h7></td>
													</tr>    
													<tr> 
														<td><isi1> Rp 
															@if (Str::length($v->nilai) > 12)
																{{ number_format($v->nilai/1000000000000, 2) }} T 
															@elseif (Str::length($v->nilai) <= 12)
																{{ number_format($v->nilai/1000000000, 1) }} M 
															@endif
														</isi1></td>
														<td style="text-align:right"><isi2>{{ $v->JUM_UMKM }} UMKM</isi2></td>
													</tr>
												</table>    
												@endforeach    
											</div>
										</td>
										<td style="background-color: #8ec045; color:#fff; height: 80px;">
											<div class="text-left">
												@foreach ($data_dw4 as $v)
												<table width="100%">
													<tr>
														<td><h7 style="margin:10px">Nilai Komitmen</h7></td>
														<td style="text-align:right"><h7 style="margin:10px">{{ $v->JUM_UB }} Usaha Besar</h7></td>
													</tr>    
													<tr> 
														<td><isi1> Rp 
															@if (Str::length($v->nilai) > 12)
																{{ number_format($v->nilai/1000000000000, 2) }} T 
															@elseif (Str::length($v->nilai) <= 12)
																{{ number_format($v->nilai/1000000000, 1) }} M 
															@endif
														</isi1></td>
														<td style="text-align:right"><isi2>{{ $v->JUM_UMKM }} UMKM</isi2></td>
													</tr>
												</table>    
												@endforeach    
											</div>
										</td>
										<td style="background-color: #2bad6f; color:#fff; height: 80px;">
											<div class="text-left">
												@foreach ($data_dw5 as $v)
												<table width="100%">
													<tr>
														<td><h7 style="margin:10px">Nilai Komitmen</h7></td>
														<td style="text-align:right"><h7 style="margin:10px">{{ $v->JUM_UB }} Usaha Besar</h7></td>
													</tr>    
													<tr> 
														<td><isi1> Rp 
															@if (Str::length($v->nilai) > 12)
																{{ number_format($v->nilai/1000000000000, 2) }} T 
															@elseif (Str::length($v->nilai) <= 12)
																{{ number_format($v->nilai/1000000000, 1) }} M 
															@endif
														</isi1></td>
														<td style="text-align:right"><isi2>{{ $v->JUM_UMKM }} UMKM</isi2></td>
													</tr>
												</table>    
												@endforeach     
											</div>
										</td>
									</tr>
								</table>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
    </div>

	<script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.15.1/build/ol.js"></script>
	<script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>

	<script>

		Highcharts.chart('container-1', {
			chart: {
				type: 'column',
				height: 500,
				styledMode: true,
				options3d: {
					enabled: true,
					alpha: 1,
					beta: 1,
					depth: 50
				}
			},
			title: {
				text: ''
			},
			plotOptions: {
				column: {
					depth: 40
				},
				series: {
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        inside: true
                    },
                }
			},
			legend:{ 
				enabled:false 
			},
			xAxis: {
				categories: [
					@foreach ($data_komitmen as $v)
					'{{ $v->sektor }}',
					@endforeach
				]
			},
			series: [{
				name: 'NILAI',
				data: [
					@foreach ($data_komitmen as $v)
					{{ $v->nilai }},
					@endforeach
				],
				colorByPoint: false
			}]
		});

		Highcharts.chart('container-2', {
			chart: {
				type: 'column',
				height: 500,
				styledMode: true,
				options3d: {
					enabled: true,
					alpha: 1,
					beta: 1,
					depth: 50
				}
			},
			plotOptions: {
				column: {
					depth: 40
				},
				series: {
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        inside: true
                    },
                }
			},
			title: {
				text: ''
			},
			legend:{ 
				enabled:false 
			},
			xAxis: {
				categories: [
					@foreach ($data_sektor as $v)
					'{{ $v->sektor }}',
					@endforeach
				]
			},
			series: [{
				name: 'NILAI',
				data: [
					@foreach ($data_sektor as $v)
					{{ $v->nilai }},
					@endforeach
				],
				colorByPoint: false
			}]
		});

		Highcharts.chart('container-3', {
			chart: {
				type: 'pie',
				options3d: {
					enabled: true,
					alpha: 45
				}
			},
			title: {
				text: ''
			},
			plotOptions: {
				pie: {
				innerSize: 100,
				depth: 45
				}
			},
			series: [{
				name: 'Nilai',
				data: [
					@foreach ($data_top_ub as $v)
						['{{ $v->nama_ub }}', {{ $v->nilai }}],
					@endforeach
				]
			}]
		});

		Highcharts.chart('container-4', {
			chart: {
				type: 'pie',
				options3d: {
					enabled: true,
					alpha: 45
				}
			},
			title: {
				text: ''
			},
			plotOptions: {
				pie: {
				innerSize: 100,
				depth: 45
				}
			},
			series: [{
				name: 'Nilai',
				data: [
					@foreach ($data_jenis_keb as $v)
						['{{ $v->jasa }}', {{ $v->nilai }}],
					@endforeach
				]
			}]
		});

		//-------------- map --------------

		var data_lokasi = @json($lokasi);
		var ALLL = ol.proj.fromLonLat([118.0148634,-2.548926 ]);
		var SUMATERA = ol.proj.fromLonLat([98.678513,3.597031]);
		var JAWA = ol.proj.fromLonLat([111.257832302, -7.50166466]);
		var KALIMANTAN = ol.proj.fromLonLat([114.44753857758242,  1.4197101910832077]);
		var SULAWESI = ol.proj.fromLonLat([120.57077305954977, -1.5781610328357976]);
		var INDONESIA = ol.proj.fromLonLat([121.08456549814444, -8.68003488395259]);

		var view = new ol.View({
			center: ALLL,
			zoom: 5.4
		});

		var map = new ol.Map({
			target: 'map',
			controls : ol.control.defaults({
			attribution : false,
			zoom : false,
			rotate : false
					}),
	

			loadTilesWhileAnimating: true,
			view: view
		});


		var vectorSource = new ol.source.Vector({});
		var features = [];
		for (let i = 0; i < data_lokasi.length; i++) {
			var pict;
			var area  = data_lokasi[i][3];

			switch(area) {
			case 1:
				pict = "https://kemitraan.fasilitasi.id/uploads/img/map-coklat.png";
				break;
			case 2:
				pict = "https://kemitraan.fasilitasi.id/uploads/img/map-biru.png";
				break;
			case 3:
				pict = "https://kemitraan.fasilitasi.id/uploads/img/map-hijautua.png";
				break;
			case 4:
				pict = "https://kemitraan.fasilitasi.id/uploads/img/map-ungu.png";
				break;
			case 5:
				pict = "https://kemitraan.fasilitasi.id/uploads/img/map-hijaumuda.png";
				break;        
			default:
				pict = "https://kemitraan.fasilitasi.id/uploads/img/map-biru.png";
			}

			if (data_lokasi[i][6]=="Belum Selesai" && data_lokasi[i][7]=="Belum Selesai") {
				
				pict = "https://kemitraan.fasilitasi.id/uploads/img/map-merah.png";

			}

			var iconFeature = new ol.Feature({
		
			geometry: new ol.geom.Point(ol.proj.transform([data_lokasi[i][4],data_lokasi[i][5]],  'EPSG:4326', 'EPSG:3857')),
			id : data_lokasi[i][0],
			name : 'peta',
			description : '<table width="480" border="0"  cellspacing="0" cellpadding="0" ><tr valign="top"><td width="166">Nama Badan Usaha</td><td width="5">:</td><td width="295">'+data_lokasi[i][1]+'</td></tr><tr valign="top"><td>Nama Proyek</td><td>:</td><td><a href="https://eri.progressreport.net/index.php/kunjungan/view/'+data_lokasi[i][0]+'" target="_blank" rel="noopener noreferrer">'+data_lokasi[i][2]+'</a></td></tr><tr valign="top"><td>Status Kunjungan</td><td>:</td><td>'+data_lokasi[i][6]+'</td></tr><tr valign="top"><td>Status FGD</td><td>:</td><td>'+data_lokasi[i][7]+'</td></tr></table>',
			
			});

			var iconStyle = new ol.style.Style({
				image: new ol.style.Icon({
					anchor: [0.5, 0.5],
					anchorXUnits: "fraction",
					anchorYUnits: "fraction",
					src: pict
					})
				});
			iconFeature.setStyle(iconStyle);
			vectorSource.addFeature(iconFeature);
		}

		var vectorLayer = new ol.layer.Vector({
			source: vectorSource,
			updateWhileAnimating: true,
			updateWhileInteracting: true
		});

		var styleFunction = function(feature) {
			var color;

			if ((feature.get("kode")>=11 && feature.get("kode")<=14) || (feature.get("kode")==16) || (feature.get("kode")==18) || (feature.get("kode")==21)){    
				color  = "#ffffff";
				fill   = "#1b1e3d";
				stroke = "#ffffff";
			} else if ((feature.get("kode")>=61 && feature.get("kode")<=64) || (feature.get("kode")==15) || (feature.get("kode")==31) ||  (feature.get("kode")==34)  ){
				color  = "#ffffff";
				fill   = "#2b5d2a";
				stroke = "#ffffff";
			} else if ((feature.get("kode")>=71 && feature.get("kode")<=74) || (feature.get("kode")==36) ||  (feature.get("kode")==32) ||  (feature.get("kode")==33)  ){   
				color  = "#ffffff";
				fill   = "#1e4495" ;
				stroke = "#ffffff";     
			} else if ((feature.get("kode")>=51 && feature.get("kode")<=53) || (feature.get("kode")==81) ||  (feature.get("kode")==82) ||  (feature.get("kode")==91)  ){   
				color  = "#ffffff"; 
				fill   = "#8ec045";
				stroke = "#ffffff";
			} else {
				color  = "#ffffff"; 
				fill   = "#2bad6f";
				stroke = "#ffffff";
			}

			var retStyle =   new ol.style.Style({
			stroke: new ol.style.Stroke({ 
				color: color,
				width: 1,
				stroke: stroke
			}),
			fill: new ol.style.Fill({ 
				color: fill
			})

			});

			return retStyle;

		};

	
		var vectorGeojson = new ol.source.Vector({
			format: new ol.format.GeoJSON(),
			url :'https://kemitraan.fasilitasi.id/uploads/prov.json'
		
		});
		
		var myGeo = new ol.layer.Vector({
			source: vectorGeojson, 
			style: styleFunction
		});
		
		map.addLayer(myGeo); 
	
		var container = document.getElementById('popup');
		var content = document.getElementById('popup-content');
		var closer = document.getElementById('popup-closer');  
		var overlay = new ol.Overlay({
			element: container,
			autoPan: true,
			autoPanAnimation: {
				duration: 250
			}
		});
		map.addOverlay(overlay);

		closer.onclick = function() {
			overlay.setPosition(undefined);
			closer.blur();
			return false;
		};

		map.on('click', function (event) {
			var feature = map.forEachFeatureAtPixel(event.pixel, 
			function(feature) {
				return feature;
			});          
			if (feature) {
			var coordinate = feature.getGeometry().getCoordinates();
			content.innerHTML =feature.get('description')         
			overlay.setPosition(coordinate);
		} else {
			overlay.setPosition(undefined);
			closer.blur();
		}
		});

		function flyTo(location, done) {
			var duration = 2000;
			var zoom = view.getZoom();
			var parts = 2;
			var called = false;
			function callback(complete) {
			--parts;
			if (called) {
				return;
			}
			if (parts === 0 || !complete) {
				called = true;
				done(complete);
			}
			}
			view.animate({
			center: location,
			duration: duration
			}, callback);
			view.animate({
			zoom: zoom - 1,
			duration: duration / 2
			}, {
			zoom: zoom,
			duration: duration / 2
			}, callback);
		}

		function onClick(id, callback) {
			document.getElementById(id).addEventListener('click', callback);
		}

		onClick('TO-ALLL', function() {
			flyTo(ALLL, function() {});
		});

		onClick('TO-SUMATERA', function() {
			flyTo(SUMATERA, function() {});
		});

		onClick('TO-JAWA', function() {
			flyTo(JAWA, function() {});
		});
		
		onClick('TO-KALIMANTAN', function() {
			flyTo(KALIMANTAN, function() {});
		});

		onClick('TO-SULAWESI', function() {
			flyTo(SULAWESI, function() {});
		});

		onClick('TO-INDONESIA', function() {
			flyTo(INDONESIA, function() {});
		});

	</script>

@endsection
