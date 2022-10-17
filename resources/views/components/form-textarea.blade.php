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

    <textarea
        id="{{ $id }}"
        name="{{ $name }}"
        placeholder="{{ $placeholder ?? '' }}"
        class="form-control @isset($tinymce) tinymce @endisset @error($name) is-invalid @enderror"
        @isset($required) required @endisset
        @isset($readonly) readonly @endisset
        @isset($disabled) disabled @endisset
        @isset($autofocus) autofocus @endisset
    >{!! $slot ?? old($name) !!}</textarea>

    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

@isset ($tinymce)
    @pushOnce('js')
        <script>
            $(document).ready(function() {
                tinymce.init({
                    selector: '.tinymce',
                    language: 'id',
                    plugins: 'image table lists fullscreen code',
                    menubar: 'file edit insert view table format table tools help',
                    toolbar: 'undo redo | styles | bold italic underline | numlist bullist | image | alignleft aligncenter alignright alignjustify | code fullscreen',
                    images_upload_handler: tinyMCEImageUploadHandler("{{ route('uploader.tinymce') }}", "{{ csrf_token() }}")
                });
            })
        </script>
    @endPushOnce
@endisset
