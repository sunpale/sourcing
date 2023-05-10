<div class="{{$marginBottom}}">
    @if(strlen($label)>0)
    <label class="form-label" for="{{$id}}">{{$label}}</label>
    @endif
    <input id="{{$id}}" name="{{$name}}" {{$attributes->merge(['class'=>'form-control'.($errors->has($name) ? ' is-invalid' : '')])}}  value="{{$errors->has($name) ? old($name):(old($name)??$value)}}" {{$attributes->merge(['type'=>'text'])}}>
    @error($name)
    <div class="invalid-feedback">{{$message}}</div>
    @enderror
</div>
