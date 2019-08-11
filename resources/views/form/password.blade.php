<div class="col-md-{{$largura ?? 12}} {{$errors->has($input) ? ' has-error' : '' }}">
   <label for="{{$input}}" class="control-label">{{$label ?? ''}}</label>
   {!!  Form::password($input, $attributes)!!}
   @if ($errors->has($input))
      <span class="help-block">
        <strong>{{ $errors->first($input) }}</strong>
      </span>
   @endif
</div>

