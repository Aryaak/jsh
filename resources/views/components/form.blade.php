<form
    {!! $attributes !!}
    action="{{ $action }}"
    method="{{ $method != 'get' ? 'post' : 'get' }}"
    @isset($sendFile) enctype="multipart/form-data" @endisset
    >

    @if ($method != 'get')
        @method($method)
        @csrf
    @endif

    {!! $slot !!}

    @isset($submit)
        <x-button type="submit" face="{{ $submitFace ?? 'primary' }}" icon="{{ $submitIcon ?? 'bx bxs-paper-plane' }}" class="mt-3 {{ $submitWide ? 'w-100' : '' }}" >{{ $submit }}</x-button>
    @endisset
</form>
