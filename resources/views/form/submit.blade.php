<div class="col-md-{{$largura ?? 12}} col-md-offset-{{$recuo ?? ''}}"  style="margin-top:20px;">
	{!!  Form::submit($input, 
		$attributes ?? [''] + ['class' => 'btn btn-success btn-block']) 
	!!}
</div>