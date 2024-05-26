@php
    $class ??= null;
    $name ??= '';
    $value ??= '';
    $label ??= Str::ucfirst($name);

@endphp

<div @class(['form-group', $class])>

    <label for="{{ $name }}">{{ $label }}</label>
    <select name="{{ $name }}[]" id="{{ $name }}" multiple>
        @foreach ($tags as $k => $v)
            <option @selected($value->contains($k)) value="{{ $k }}">{{ $v }}</option>
        @endforeach

    </select>

    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
