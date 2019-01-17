@extends('layout.dashboard')

@section('title', __('clients.notes.index.title'))

@section('content.breadcrumbs', Breadcrumbs::render('clients.notes.index', $user))
@section('content.dashboard')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.0/css/buttons.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.4/css/select.bootstrap.min.css">
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span>
                <i class="fas fa-list-ul mr-1"></i>
                @lang('clients.notes.index.notes')
            </span>

            <div class="ml-auto">
                <a
                    class="btn btn-primary btn-sm"
                    href="{{ url("clients/$user->id/attachments/create") }}"
                >
                    <i class="fas fa-paperclip mr-1"></i>
                    @lang('clients.notes.index.create-attachment')
                </a>

                <a
                    class="btn btn-primary btn-sm"
                    href="{{ url("clients/$user->id/communication/create") }}"
                >
                    <i class="fas fa-comment-alt mr-1"></i>
                    @lang('clients.notes.index.create-communication-log')
                </a>

                <a
                    class="btn btn-primary btn-sm"
                    href="{{ url("clients/$user->id/notes/create") }}"
                >
                    <i class="fas fa-sticky-note mr-1"></i>
                    @lang('clients.notes.index.create')
                </a>

                <a
                    class="btn btn-primary btn-sm"
                    href="{{ url("clients/$user->id/receipts/create") }}"
                >
                    <i class="fas fa-receipt mr-1"></i>
                    @lang('clients.notes.index.create-receipt')
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
				{!!
                Form::open([
                    'url' => url("clients/$user->id/notes/submit"),
                ])
				!!}
                    @if (
                        $attachments->isNotEmpty() ||
                        $communication->isNotEmpty() ||
                        $drafts->isNotEmpty() ||
                        $finals->isNotEmpty() ||
                        $receipts->isNotEmpty()
                    )
                        @include('clients.notes.table', [
                            'attachments' => $attachments,
                            'communication' => $communication,
                            'drafts' => $drafts,
                            'finals' => $finals,
                            'prefix' => "clients/$user->id",
                            'receipts' => $receipts,
                        ])
				 {!! Form::close() !!}
                    @else
                        <p class="lead text-center text-muted mt-3">
                            @lang('clients.notes.index.no-results')
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.4/js/dataTables.select.min.js"></script>
<script src="{{asset('plugins/editor/js/dataTables.editor.js')}}"></script>
<script src="{{asset('plugins/editor/js/editor.bootstrap.min.js')}}"></script>
<script>
           $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var editor = new $.fn.dataTable.Editor({
                    ajax: "/clients/{{Request::segment(2)}}/notes",
                    table: "#commun",
					idSrc:  'id',
                    display: "bootstrap",
                    fields: [
                        {label: "@lang('clients.notes.index.appointment_date')", name: "appointment_date", type:  'datetime',
							def:   function () { return new Date(); }},
                        {label: "@lang('clients.notes.index.actions')",name: "actions" },
                        {label: "@lang('clients.notes.index.notes')",name: "notes" },
                        {
						label: "@lang('clients.notes.index.digital-signature')",
						name: "digital_signature",
						type: "select",
						ipOpts: [
								{ label: 'Signed', value: "1" },
								{ label: 'Unsigned', value: "0"}
								],
						editField: "digital_signature"
						},
                    ]
                });

                $('#commun').on('click', 'tbody td:not(:first-child)', function (e) {
				    editor.inline( this, {
						buttons: { label: '&gt;', fn: function () { this.submit(); } }
					} );
                });
				$('#commun').DataTable( {
					    bProcessing: true,
						bServerSide: true,
						searching: false,
						dom: "Bfrtip",
						ajax: "/clients/{{Request::segment(2)}}/notes",
						order: [[ 1, 'asc' ]],
						columns: [
							{
								data: null,
								defaultContent: '',
								className: 'select-checkbox',
								orderable: false
							},
							{ data: "appointment_date" },
							{ data: "actions" },
							{ data: "notes" },
							{ data: "digital_signature",
								"render": function (data, type, row) {
 
									if (row.digital_signature != '') {
										return '<i class="fas fa-lock text-success">';
									} else {
									 	return '<i class="fas fa-lock text-error">';
									}
								}
							},
						  
						],
						select: {
							style:    'os',
							selector: 'td:first-child'
						},
						buttons: [
							{ extend: "edit",   editor: editor },
							{ extend: "remove", editor: editor }
						],
						
				});
               
            });
        </script>
@endpush