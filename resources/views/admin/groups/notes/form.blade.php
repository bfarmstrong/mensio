{!! Form::hidden('group_id', $group->id) !!}
{!! Form::hidden('created_by', \Auth::user()->id) !!}

<div class="form-row">
    <div class="form-group col-3">
        <strong>
            @lang('groups.notes.form.group')
        </strong>
    </div>

    <div class="form-group col-9">
        {{ $group->name }}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-3">
        <strong>
            @lang('groups.notes.form.date')
        </strong>
    </div>

    <div class="form-group col-9">
        @if (isset($note))
            {{ $note->updated_at }}
        @else
            {{ date('Y-m-d') }}
        @endif
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12">
        {!!
            Form::label(
                'contents',
                __('groups.notes.form.contents'),
                ['class' => 'font-weight-bold']
            )
        !!}

        @unless (isset($note) && !$note->is_draft)
            @include('partials.wysiwyg', [
                'name' => 'contents',
                'value' => isset($note) ? $note->contents : null,
            ])
        @else
            <div class="bg-light border p-3">
                {!! $note->contents !!}
            </div>

            @foreach($note->children as $child)
                <div class="bg-light border p-3 mt-3">
                    {!! $child->contents !!}
                </div>

                <small class="align-items-center d-inline-flex form-text justify-content-between text-muted w-100">
                    {{ $child->updated_at }}
                    @if ($child->isSignatureValid($child->therapist_id))
                        <i class="fas fa-lock text-success pull-right"></i>
                    @else
                        <i
                            class="fas fa-exclamation-triangle text-danger pull-right"
                            data-toggle="tooltip"
                            data-placement="top"
                            title="{{ __('clients.notes.form.signature-invalid') }}"
                        >
                        </i>
                    @endif

                </small>
            @endforeach
        @endunless
    </div>
</div>
@unless (isset($note) && !$note->is_draft)
@include('partials.digital-signature')

<div class="form-row">
    <div class="form-group col-12 mb-0">
        <button
            class="btn btn-primary"
            name="is_draft"
            type="submit"
            value="0"
        >
            <i class="fas fa-file-signature mr-1"></i>
            @lang('groups.notes.form.save-final')
        </button>

        
            <button
                class="btn btn-secondary"
                name="is_draft"
                type="submit"
                value="1"
            >
                @lang('groups.notes.form.save-draft')
            </button>
        
    </div>
</div>
@endunless