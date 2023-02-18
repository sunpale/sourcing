<div class="{{$marginBottom}}">
    <label class="form-label" for="{{$id}}">{{$label}}</label>
    <select {{$attributes->merge(['class'=>'form-select'.($errors->has($name) ? ' is-invalid' : '')])}} id="{{$id}}" name="{{$name}}">
        @if(count($listValue)==0)
            {{$slot}}
        @else
            <option disabled selected value>-{{$slot}}-</option>
            @foreach($listValue as $key => $nilai)
                @if(old($name))
                    <option value="{!! $key !!}" {{old($name)==$key ? 'selected':''}}>{!! $nilai !!}</option>
                @else
                    <option value="{!! $key !!}" {{$value==$key ? 'selected':''}}>{!! $nilai !!}</option>
                @endif

            @endforeach
        @endif
    </select>
    @error($name)
    <div class="invalid-feedback">
        {{$message}}
    </div>
    @enderror
</div>

