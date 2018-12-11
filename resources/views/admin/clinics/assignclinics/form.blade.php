{!! Form::hidden('clinic_id', $clinic->id) !!}

<div class="form-row">
    <div class="form-group col-12">
        {!!
            Form::label(
                'user_id',
                __('admin.clinics.assignclinic.user')
            )
        !!}

        {!!
            Form::select(
                'user_id',
                $clients->pluck('name', 'id'),
                old('user_id'),
                ['class' => 'form-control selectpicker','onchange'=>'getMessage(this.value);']
            )
        !!}
    </div>
</div>
@if(!empty($clients[0]))
<div class="form-row">
    <div class="form-group col-12" id="role">

		{!!
            Form::label(
                'role_id',
                __('admin.clinics.assignclinic.roles')
            )
        !!}

        {!!
            Form::select(
                'role_id[]',
                $clients[0]->roles()->pluck('label','roles.id'),
                old('role_id'),
                ['class' => 'form-control selectpicker']
            )
        !!}
	</div>
</div>
@endif
<div class="form-row">
    <div class="form-group col-12 mb-0">
        {!!
            Form::submit(
                __('admin.clinics.assignclinic.form-assign-button'),
                ['class' => 'btn btn-primary']
            )
        !!}
    </div>
</div>
<script>
         function getMessage(thisval){

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
            $.ajax({
				type:'POST',
				url:"/admin/clinics/<?php echo request()->segment(3);?>/assignRoletoClinic/"+thisval,
                success:function(data){
					$('#role').html(data);
				}
            });
         }


</script>
