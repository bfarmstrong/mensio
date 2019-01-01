<div class="form-horizontal">
    <div class="form-group row">
        <div class="col-3">
            <strong>
                @lang('admin.logs.form-static.causer-type')
            </strong>
        </div>

        <div class="col-9">
            <p class="form-control-static">{{ $log->causer_type ?? 'N/A' }}</p>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-3">
            <strong>
                @lang('admin.logs.form-static.causer-id')
            </strong>
        </div>

        <div class="col-9">
            <p class="form-control-static">
                {{ $log->causer->uuid ?? $log->causer->id ?? 'N/A' }}
            </p>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-3">
            <strong>
                @lang('admin.logs.form-static.action')
            </strong>
        </div>

        <div class="col-9">
            <p class="form-control-static">{{ $log->action ?? 'N/A' }}</p>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-3">
            <strong>
                @lang('admin.logs.form-static.subject-type')
            </strong>
        </div>

        <div class="col-9">
            <p class="form-control-static">{{ $log->subject_type ?? 'N/A' }}</p>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-3">
            <strong>
                @lang('admin.logs.form-static.subject-id')
            </strong>
        </div>

        <div class="col-9">
            <p class="form-control-static">
                {{ $log->subject->uuid ?? $log->subject->id ?? 'N/A' }}
            </p>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-3">
            <strong>
                @lang('admin.logs.form-static.timestamp')
            </strong>
        </div>

        <div class="col-9">
            <p class="form-control-static">{{ $log->created_at }}</p>
        </div>
    </div>

    <div class="form-group row bg-light border py-3">
        <div class="col-3">
            <strong>
                <i
                    class="fas fa-lock mr-1"
                    data-placement="top"
                    data-toggle="tooltip"
                    title="{{ __('admin.logs.form-static.encrypted-value') }}"
                >
                </i>
                @lang('admin.logs.form-static.details')
            </strong>
        </div>

        <div class="col-9">
            <code class="form-control-static">{{ $log->properties }}</code>
        </div>
    </div>
</div>
