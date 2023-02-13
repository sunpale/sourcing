<div class="{{$marginBottom}}">
    <label class="form-label" for="{{$id}}">{{$label}}</label>
    <select {{$attributes->merge(['class'=>'form-control'.($errors->has($name) ? ' is-invalid' : '')])}} id="{{$id}}" name="{{$name}}">
        @if(count($listValue)==0)
            {{$slot}}
        @else
            <option disabled selected value>-{{$slot}}-</option>
            @foreach($listValue as $rowData)
                @if(old($name))
                    <option value="{!! $rowData[$dataValue] !!}" {{old($name)==$rowData[$dataValue] ? 'selected':''}}>{!! $rowData[$dataColumn] !!}</option>
                @else
                    <option value="{!! $rowData[$dataValue] !!}" {{$value==$rowData[$dataValue] ? 'selected':''}}>{!! $rowData[$dataColumn] !!}</option>
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

