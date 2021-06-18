<div class="col-md-{{$largura ?? 12}} col-md-offset-{{$recuo ?? ''}} {{$errors->has($input) ? ' has-error' : '' }}">
	<label for="{{$input}}" class="control-label">{{$label ?? ''}}  @php $a = "<font color=#f00>*</font>"; echo isset($attributes['required']) ? $a : ''; @endphp</label>
    <div class="input-group custom-search-form">
		{!!  Form::text($input, 
			$value ?? null, 
			$attributes + ['class' => 'form-control form-control-sm' ])
		!!}
        <span class="input-group-btn">
            <button class="btn btn-success" type="button" id="{{$buttonId}}">
                <i class="glyphicon glyphicon-search"></i>
            </button>
        </span>
    </div>
	@if ($errors->has($input))
	    <span class="help-block">
	    	<strong>{{ $errors->first($input) }}</strong>
	    </span>
	@endif
</div>
