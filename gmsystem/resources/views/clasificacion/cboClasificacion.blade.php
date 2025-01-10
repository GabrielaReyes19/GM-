@if($id=="1")
	<option value="">[TODOS]</option> 
@else
	<option value=""></option> 
@endif()
@foreach($clasificacion as $dato)
	@if($dato->pk_cla_id==$id2)
		<option value="{{ $dato->pk_cla_id }}" selected="">{{ $dato->c_nom }}</option>
	@else
		<option value="{{ $dato->pk_cla_id }}">{{ $dato->c_nom }}</option>
	@endif

@endforeach  


