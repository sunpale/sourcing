<div class="{{$marginBottom}}">
    <label class="form-label" for="{{$id}}">{{$label}}</label>
    <textarea {{$attributes->merge(['class'=>'form-control'.($errors->has($name) ? ' is-invalid' : '')])}} id="{{$id}}" name="{{$name}}" {{$attributes->merge(['type'=>'text'])}} rows="3">{{old($name)??$value}}</textarea>
    @error($name)
    <div class="invalid-feedback">{{$message}}</div>
    @enderror
</div>
