
{{-- <form method="POST" action="{{ route('profiles.update', $profile->id )}}"> --}}
	<form method="POST" action="">
	{!! csrf_field() !!}
	{!! method_field('PUT') !!}

	<div class="row">
		<div class="col-sm-12">
			<!-- Primary table -->
			<div class="table-primary">
				<div class="table-header">
					<div class="table-caption">
						Primary Table
					</div>
				</div>
				<table class="table table-bordered table-striped table-hover table-condensed dataTable no-footer tbl-enero">
					<thead>
						<tr>
							<th>#</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Username</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>Mark</td>
							<td>Otto</td>
							<td>@mdo</td>
						</tr>
						<tr>
							<td>2</td>
							<td>Jacob</td>
							<td>Thornton</td>
							<td>@fat</td>
						</tr>
						<tr>
							<td>3</td>
							<td>Larry</td>
							<td>the Bird</td>
							<td>@twitter</td>
					  </tr>
					</tbody>
				</table>
				<div class="table-footer">
					Footer
				</div>
			</div>
			<!-- / Primary table -->
		</div>
	</div>





	<div class="row">
		<div class="col-md-4 text-center">
			<label class="control-label">MODULO</label>
			<div class="checkbox text-left">
			    @foreach($assigned as $assign)
			        <label>
			            <input 
			                type="checkbox" 
			                value="{{ $assign->id }}"
			                {{ $assign->mod=="1" ? 'checked' : '' }}
			                name="roles[]">
			            {{ $assign->name }}
			        </label>
			    @endforeach
			</div>
		</div>

		<div class="col-md-2 text-center">
			<label class="control-label">NUEVO</label>
			<div class="checkbox text-left">
			    @foreach($assigned as $assign)
			        <label>
			            <input 
			                type="checkbox" 
			                value="{{ $assign->id }}"
			                {{ $assign->mod=="1" ? 'checked' : '' }}
			                name="roles[]">
			            {{ $assign->name }}
			        </label>
			    @endforeach
			</div>
		</div>

		<div class="col-md-2 text-center">
			<label class="control-label">ACTUALIZAR</label>
			<div class="checkbox text-left">
			    @foreach($assigned as $assign)
			        <label>
			            <input 
			                type="checkbox" 
			                value="{{ $assign->id }}"
			                {{ $assign->mod=="1" ? 'checked' : '' }}
			                name="roles[]">
			            {{ $assign->name }}
			        </label>
			    @endforeach
			</div>
		</div>
		<div class="col-md-2 text-center">
			<label class="control-label">ELIMINAR</label>
			<div class="checkbox text-left">
			    @foreach($assigned as $assign)
			        <label>
			            <input 
			                type="checkbox" 
			                value="{{ $assign->id }}"
			                {{ $assign->mod=="1" ? 'checked' : '' }}
			                name="roles[]">
			            {{ $assign->name }}
			        </label>
			    @endforeach
			</div>
		</div>
		<div class="col-md-2 text-center">
			<label class="control-label">ANULAR</label>
			<div class="checkbox text-left">
			    @foreach($assigned as $assign)
			        <label>
			            <input 
			                type="checkbox" 
			                value="{{ $assign->id }}"
			                {{ $assign->mod=="1" ? 'checked' : '' }}
			                name="roles[]">
			            {{ $assign->name }}
			        </label>
			    @endforeach
			</div>
		</div>
	</div>

	<input class="btn btn-primary" type="submit" value="Enviar">
</form>


