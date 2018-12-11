@extends('layout.guest')

@section('title', __('errors.no-selected-clinic.title'))

@section('content.guest')
    <div class="clearfix">
        <h1 class="float-left display-3 mr-4">
            @lang('errors.no-selected-clinic.headline')
        </h1>

        <h4 class="pt-3">
            @lang('errors.no-selected-clinic.subheadline')
        </h4>

        <p class="text-muted">
            @lang('errors.no-selected-clinic.contents')
        </p>

        @isset($availableClinics)
            {!!
                Form::select(
                    'clinic',
                    [null => __('errors.no-selected-clinic.select')] + $availableClinics->pluck('name', 'subdomain')->all(),
                    null,
                    ['class' => 'form-control selectpicker']
                )
            !!}
        @else
            <a
                class="btn btn-primary"
                href="{{ url('/') }}"
            >
                @lang('errors.no-selected-clinic.return-home')
            </a>
        @endisset
    </div>

    @isset($availableClinics)
        @push('scripts')
            <script type="text/javascript">
                window.$('select[name="clinic"]').change(function (event) {
                    if (event.target.value) {
                        var subdomain = '{{ config('app.url') }}'.replace(
                            '//',
                            '//' + event.target.value + '.'
                        );
                        window.location.href = subdomain;
                    }
                });
            </script>
        @endpush
    @endisset
@endsection
