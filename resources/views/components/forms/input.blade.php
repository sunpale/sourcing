<div class="{{$marginBottom}}">
    <label class="form-label" for="{{$id}}">{{$label}}</label>
    @if($formInput==='input')
        <input type="{{$type}}" id="{{$id}}" class="form-control @error($name) is-invalid @enderror " name="{{$name}}" value="{{old($name)??$value}}" placeholder="{{$placeholder}}" {{$isRequired ? 'required' : ''}}>
        @error($name)
        <div class="invalid-feedback">{{$message}}</div>
        @enderror
    @else
        <textarea class="form-control  @error($name) is-invalid @enderror" id="{{$id}}" name="{{$name}}" placeholder="{{$placeholder}}" {{$isRequired ? 'required':''}} rows="3">{{old($name)??$value}}</textarea>
        @error($name)
        <div class="invalid-feedback">{{$message}}</div>
        @enderror
    @endif
</div>
