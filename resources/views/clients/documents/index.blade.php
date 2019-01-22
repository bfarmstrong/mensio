@extends('layout.dashboard')

@section('title', __('admin.documents.index.title'))
@section('content.breadcrumbs', Breadcrumbs::render('admin.documents.index', request()->user()))
@section('content.dashboard')
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.0/css/buttons.bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.4/css/select.bootstrap.min.css">

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span>
                <i class="nav-icon fas fa-file"></i>
                @lang('admin.documents.index.documents')
            </span>
		@if (Auth::user()->isAdmin())

            <a
                class="btn btn-primary btn-sm ml-auto"
                href='{{ url("clients/documents/create/".Request::segment(3)) }}'
            >
                @lang('admin.documents.index.create-document')
            </a>

		@endif
        </div>

            <div class="row">
                <div class="col-12 custm_doc_tbl">
						
						{{$dataTable->table(['id' => 'documents'])}}
                        
                   
                    
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
                    ajax: "/clients/documents/{{Request::segment(3)}}",
                    table: "#documents",
					idSrc:  'id',
                    display: "bootstrap",
                    fields: [
                        {label: "Name: ", name: "name"},
                        {label: "Document Type:",
							name: "document_type",
							type: "select",
							ipOpts: [
								{ label: "Notes", value: "1" },
								{ label: "Other Attachments", value: "2"}
								],
							editField: "document_type" ,
							"default": 1							
						},
						{ label: "Allocated Date:", name: "date", type:  'datetime',
							def:   function () { return new Date(); }},
							
                        {
						label: "Is Signed:", 
						name: "is_signed",
						type: "select",
							ipOpts: [
								{ label: "Signed", value: "1" },
								{ label: "Unsigned", value: "0"}
								],
						editField: "is_signed"},
                    ]
                });

                $('#documents').on('click', 'tbody td:not(:first-child)', function (e) {
                   // editor.inline(this);
				    editor.inline( this, {
						buttons: { label: '&gt;', fn: function () { this.submit(); } }
					});
                });
				$('#documents').DataTable( {
					    bProcessing: true,
						bServerSide: true,
						searching: false,
						dom: "Bfrtip",
						ajax: "/clients/documents/{{Request::segment(3)}}",
						order: [[ 1, 'asc' ]],
						columns: [
							{
								data: null,
								defaultContent: '',
								className: 'select-checkbox',
								orderable: false
							},
							{ data: "name" },
							{ data: "document_type" ,  editField: "document_type",
								"render": function (data, type, row) {
 
									if (row.document_type == 1) {
										return 'Notes';
									} 
									if (row.document_type == 2) {
									 	return 'Other Attachments';
									}
								}
							},
							{ data: "date"},
							{ data: "is_signed",
								"render": function (data, type, row) {
 
									if (row.is_signed == 1) {
										return 'Signed';
									} else {
									 	return 'Unsigned';
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