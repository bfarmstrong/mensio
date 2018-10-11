@php $id = str_random(24); @endphp

{!!
    Form::textarea(
        $name,
        $value ?? null,
        [
            'data-wysiwyg' => $id,
            'style' => 'display: none;',
        ]
    )
!!}

@push('scripts')
    <script type="text/javascript">
        var wysiwyg = window.$('textarea[data-wysiwyg="{{ $id }}"]');
        wysiwyg.summernote({
            height: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ],
        });
    </script>
@endpush
