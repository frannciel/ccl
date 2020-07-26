<div class="col-md-{{$largura ?? 12}} col-md-offset-{{$recuo ?? ''}} {{$errors->has($input) ? ' has-error' : '' }}">
	<label for="{{$input}}" class="control-label">{{$label ?? ''}}</label>
	<div class="input-group">
		<div id="{{'G'.$input}}" class="btn-group">
			@foreach ($options as $key => $option)
			<a class="btn btn-success btn-sm notActive" onclick='radioButton(this.getAttribute("data-toggle"), this.getAttribute("data-title"))' data-toggle="{{$input}}" data-title="{{$key}}">{{$option}}</a>
			@endforeach
		</div>
	</div>
	{!!  Form::hidden($input, $value ?? null, $attributes) !!}
	@if ($errors->has($input))
	<span class="help-block">
		<strong>{{ $errors->first($input) }}</strong>
	</span>
	@endif
</div>
