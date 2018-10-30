{!! Form::hidden('clinic_id', $clinic->id) !!}
<button
    class="btn btn-danger btn-sm"
    type="submit"
>
    <i class="fas fa-trash mr-1"></i>
    @lang('admin.clinics.assignclinic.form-delete')
</button>
