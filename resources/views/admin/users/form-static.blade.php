<div class="form-horizontal">
    <div class="form-group row">
        <div class="col-3">
            <strong>
                @lang('admin.users.form-static.name')
            </strong>
        </div>

        <div class="col-9">
            <p class="form-control-static">
                {{ $user->name }}
            </p>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-3">
            <strong>
                @lang('admin.users.form-static.email')
            </strong>
        </div>

        <div class="col-9">
            <p class="form-control-static">
                {{ $user->email }}
            </p>
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-3">
            <strong>
                @lang('admin.users.form-static.user-since', [
                    'name' => $user->roleName()
                ])
            </strong>
        </div>

        <div class="col-9">
            <p class="form-control-static">
                {{ $user->created_at->toDateString() }}
            </p>
        </div>
    </div>
</div>
