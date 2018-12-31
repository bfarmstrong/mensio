@extends('layout.dashboard')

@section('title', __('admin.users.add.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.users.add'))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-user-plus mr-1"></i>
            @lang('admin.users.add.form-title')
        </div>

        {!!
            Form::model(
                $clinic,
                ['url' => url("admin/users/assign")]
            )
        !!}
        <div class="card-body">
			<div class="form-row">
				<div class="form-group col-12">
					{!!
						Form::label(
							'health_card_number',
							__('user.form-settings.health-card-number')
						)
					!!}

					{!!
						Form::text(
							'health_card_number',
							old('health_card_number'),
							['class' => 'form-control']
						)
                    !!}

                    <small class="form-text text-muted">
                        @lang('admin.users.add.health-card-help')
                    </small>
				</div>
			</div>

            <div class="form-row">
                <div class="form-group col-12 mb-0">
                    {!!
                        Form::submit(
                            __('user.form-settings.save'),
                            ['class' => 'btn btn-primary']
                        )
                    !!}
                </div>
            </div>
        </div>
		{!! Form::close() !!}
    </div>
@endsection
