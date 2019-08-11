<div class="col-md-{{$largura ?? 12}} {{$errors->has($input) ? ' has-error' : '' }}">
	<label for="{{$input}}" class="control-label">{{$label ?? ''}}</label>
    <div class="input-group custom-search-form">
		{!!  Form::text($input, 
			$value ?? null, 
			$attributes + ['class' => 'form-control form-control-sm' ])
		!!}
        <span class="input-group-btn">
            <button class="btn btn-success" type="button">
                <i class="fa fa-search"></i>
            </button>
        </span>
    </div>
	@if ($errors->has($input))
	    <span class="help-block">
	    	<strong>{{ $errors->first($input) }}</strong>
	    </span>
	@endif
</div>
