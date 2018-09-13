@if ($errors->count())
    @foreach ($errors->all() as $error)
        <div
            class="alert alert-danger rounded-0 mb-0"
            role="alert"
        >
            {{ $error }}

            <button
                aria-label="{{ __('partials.errors.close') }}"
                class="close"
                data-dismiss="alert"
                type="button"
            >
                <span aria-hidden="true">
                    &times;
                </span>
            </button>
        </div>
    @endforeach
@endif
