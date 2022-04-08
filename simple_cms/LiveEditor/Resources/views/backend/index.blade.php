@extends('core::layouts.backend')
@section('title','Live Code Editor')
@section('breadcrumb')
	<li class="breadcrumb-item active"><a title="Live Code Editor"> Live Code Editor</a></li>
@endsection
@push('css_stack')
	{!! library_livecode_editor('css') !!}
@endpush
@section('layout')
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="selectPath">Folder</label>
							<select id="selectPath" name="selectPath" class="form-control">
								<option value="{{ route('simple_cms.live_editor.backend.index',['path'=>'themes']) }}" {{ ($active_path == 'themes' ? 'selected':'') }}>Themes</option>
								<option value="{{ route('simple_cms.live_editor.backend.index',['path'=>'env']) }}" {{ ($active_path == 'env' ? 'selected':'') }}>File .env</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="card">
					<div class="card-body">
						<div id="liveeditor" data-dir="{{ $path }}" class="row">
							<div class="col-md-2 col-sm-3">
								<div class="la-header">
									Live Code Editor
								</div>
								<div class="la-file-tree" style="max-height: 600px; overflow: auto;">

								</div>
							</div>
							<div class="col-md-10 col-sm-9">
								<ul class="liveeditor-tabs nav nav-pills">

								</ul>
								<pre id="la-ace-editor"></pre>
							</div>
						</div>

					</div>
					<div class="card-footer text-right">
						<button id="saveLiveEditor" class="btn btn-xs btn-primary" type="button" title="Save"><i class="fa fa-save"></i> Save</button>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('js_stack')
	{!! library_livecode_editor('js') !!}
	{!! module_script('liveeditor', 'backend/js/index.js') !!}
	<script>
		$(document).ready(function(){
			$(document).on('change','select#selectPath',function(e){
				e.stopPropagation();
				let self = $(this),
						value = self.val();
				if(value !== ''){
					window.location.href = value;
				}
			});
		});
	</script>
@endpush