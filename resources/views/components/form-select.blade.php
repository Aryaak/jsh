<div {!! $attributes !!}>

    @if ($label)
        <x-form-label for="{{ $id ?? '' }}" required="{{ $required ?? 0 }}">
            {{ $label }}
            @if ($labelBadge)
                @slot('badge')
                    {!! $labelBadge !!}
                @endslot
            @endif
        </x-form-label>
    @endif

    <select
        class="form-select select2"
        id="{{ $id }}" name="{{ $name }}"
        data-placeholder="{{ $placeholder }}"
        @isset($required) required @endisset
        @isset($readonly) readonly @endisset
        @isset($disabled) disabled @endisset
        @isset($autofocus) autofocus @endisset
    >

        @isset($multiple)
            @php
                $name = str_replace('[]', '', $name);
            @endphp
            @foreach ($options as $key => $option)
                @isset($value)
                    <option value="{{ $key }}" {{ (in_array($key, ($value))) ? "selected" : '' }}>{{ $option }}</option>
                @else
                    <option value="{{ $key }}" {{ (in_array($key, (old($name) ?? []))) ? "selected" : '' }}>{{ $option }}</option>
                @endisset
            @endforeach
        @else
            @isset($empty)
            @else
                <option selected value="">{{ $selectedNone }}</option>
            @endisset
            @foreach ($options as $key => $option)
                @isset($value)
                    <option value="{{ $key }}" {{ ($value == $key) ? "selected" : '' }}>{{ $option }}</option>
                @else
                    <option value="{{ $key }}" {{ (old($name) == $key) ? "selected" : '' }}>{{ $option }}</option>
                @endisset
            @endforeach
        @endisset

    </select>

    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
