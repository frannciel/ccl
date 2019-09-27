<div class="col-md-{{$largura ?? 12}} col-md-offset-{{$recuo ?? ''}} mt-2">
	{!!  Form::submit($input, 
		$attributes ?? [''] + ['class' => 'btn btn-success btn-block']) 
	!!}
</div>