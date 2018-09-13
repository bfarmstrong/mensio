@if (session('message'))
    <div
        class="alert alert-primary rounded-0 mb-0"
        role="alert"
    >
        {{ session('message') }}

        <button
            aria-label="{{ __('partials.message.close') }}"
            class="close"
            data-dismiss="alert"
            type="button"
        >
            <span aria-hidden="true">
                &times;
            </span>
        </button>
    </div>
@endif
