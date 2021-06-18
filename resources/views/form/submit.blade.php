<div class="col-md-{{$largura ?? 12}} col-md-offset-{{$recuo ?? ''}}">
	{!!  Form::submit($input, 
		$attributes ?? [''] + ['class' => 'btn btn-success btn-block font-weight-bold']) 
	!!}
</div>