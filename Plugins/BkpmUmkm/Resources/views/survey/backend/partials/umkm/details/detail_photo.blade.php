<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">List Photo Survey</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead>
            <tr>
                <th></th>                
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    @if(isset($list_photo->foto1))
						<a href="{{ url($list_photo->foto1) }}" target="_blank" class="d-block mb-4 m-3 h-100">
							<img class="img-fluid img-thumbnail" width="200px" height="200px" src="{{ url($list_photo->foto1) }}">  
						</a>
					@endif
					@if(isset($list_photo->foto2))
						<a href="{{ url($list_photo->foto2) }}" target="_blank" class="d-block mb-4 m-3 h-100">
							<img class="img-fluid img-thumbnail" width="200px" height="200px" src="{{ url($list_photo->foto2) }}">  
						</a>
					@endif
                    @if(isset($list_photo->foto3))
						<a href="{{ url($list_photo->foto3) }}" target="_blank" class="d-block mb-4 m-3 h-100">
							<img class="img-fluid img-thumbnail" width="200px" height="200px" src="{{ url($list_photo->foto3) }}">  
						</a>
					@endif
                    @if(isset($list_photo->foto4))
						<a href="{{ url($list_photo->foto4) }}" target="_blank" class="d-block mb-4 m-3 h-100">
							<img class="img-fluid img-thumbnail" width="200px" height="200px" src="{{ url($list_photo->foto4) }}">  
						</a>
					@endif
                    @if(isset($list_photo->foto5))
						<a href="{{ url($list_photo->foto5) }}" target="_blank" class="d-block mb-4 m-3 h-100">
							<img class="img-fluid img-thumbnail" width="200px" height="200px" src="{{ url($list_photo->foto5) }}">  
						</a>
					@endif
                    @if(isset($list_photo->foto6))
						<a href="{{ url($list_photo->foto6) }}" target="_blank" class="d-block mb-4 m-3 h-100">
							<img class="img-fluid img-thumbnail" width="200px" height="200px" src="{{ url($list_photo->foto6) }}">  
						</a>
					@endif
                    @if(isset($list_photo->foto7))
						<a href="{{ url($list_photo->foto7) }}" target="_blank" class="d-block mb-4 m-3 h-100">
							<img class="img-fluid img-thumbnail" width="200px" height="200px" src="{{ url($list_photo->foto7) }}">  
						</a>
					@endif
                    @if(isset($list_photo->foto8))
						<a href="{{ url($list_photo->foto8) }}" target="_blank" class="d-block mb-4 m-3 h-100">
							<img class="img-fluid img-thumbnail" width="200px" height="200px" src="{{ url($list_photo->foto8) }}">  
						</a>
					@endif
                    @if(isset($list_photo->foto9))
						<a href="{{ url($list_photo->foto9) }}" target="_blank" class="d-block mb-4 m-3 h-100">
							<img class="img-fluid img-thumbnail" width="200px" height="200px" src="{{ url($list_photo->foto9) }}">  
						</a>
					@endif
                    @if(isset($list_photo->foto10))
						<a href="{{ url($list_photo->foto10) }}" target="_blank" class="d-block mb-4 m-3 h-100">
							<img class="img-fluid img-thumbnail" width="200px" height="200px" src="{{ url($list_photo->foto10) }}">  
						</a>
					@endif
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
