@extends('layout.dashboard')

@section('title', __('admin.clinics.index.title'))


@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-hospital mr-1"></i>
            @lang('admin.clinics.index.clinics')
        </div>
            {!!
                Form::model(
                    $clinic,
                    ['url' => url("users/assign/$clinic->id")]
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
				</div>
			</div>
        </div>
		{!! Form::close() !!}
    </div>
@endsection
