<div class="{{$marginBottom}}">
    <label class="form-label" for="{{$id}}">{{$label}}</label>
    <input id="{{$id}}" name="{{$name}}" {{$attributes->merge(['class'=>'form-control'.($errors->has($name) ? ' is-invalid' : '')])}}  value="{{old($name)??$value}}" {{$attributes->merge(['type'=>'text'])}}>
    @error($name)
    <div class="invalid-feedback">{{$message}}</div>
    @enderror
</div>
