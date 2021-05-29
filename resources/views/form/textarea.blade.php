<div class="col-md-{{$largura ?? 12}} {{$errors->has($input) ? ' has-error' : '' }}">
	<label for="{{$input}}" class="control-label">{{$label ?? ''}} @php $a = "<font color=#f00>*</font>"; echo isset($attributes['required']) ? $a : ''; @endphp</label>
	{!!  Form::textarea($input, 
		$value ?? null, 
		$attributes + ['class' => 'form-control form-control-sm' ])
	!!}
	@if ($errors->has($input))
	    <span class="help-block">
	    	<strong>{{ $errors->first($input) }}</strong>
	    </span>
	@endif
</div>
