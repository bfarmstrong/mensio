<ul class="nav nav-tabs">
  <li class="nav-item">
    <a data-toggle="tab" class="nav-link active" href="#final-notes">Final Notes</a>
  </li>
  <li class="nav-item">
    <a data-toggle="tab" class="nav-link" href="#drafts">Drafts</a>
  </li>
</ul>
<div class="tab-content">
	<div id="final-notes" class="tab-pane active">
		<table class="table table-hover table-outline table-striped">
			<thead class="thead-light">
				<tr>
					<th>@lang('clients.notes.table.creator')</th>
					<th>@lang('clients.notes.table.date')</th>
					<th>@lang('clients.notes.table.status')</th>
					<th>@lang('clients.notes.table.actions')</th>
				</tr>
			</thead>

			<tbody>
				@foreach ($notes as $note)
				@if ($note->is_draft == 0)
					<tr>
						<td>{{ $note->therapist->name }}</td>
						<td>{{ $note->updated_at }}</td>
						<td>@lang('clients.notes.table.final')</td>
						<td>
							<a
								class="btn btn-primary btn-sm"
								href="{{ url("clients/$user->id/notes/$note->uuid") }}"
							>
								<i class="fas fa-search mr-1"></i>
								@lang('clients.notes.table.view')
							</a>
						</td>
					</tr>
				@endif
				@endforeach
			</tbody>
		</table>
	</div>
	<div id="drafts" class="tab-pane fade">
		<table class="table table-hover table-outline table-striped">
			<thead class="thead-light">
				<tr>
					<th>@lang('clients.notes.table.creator')</th>
					<th>@lang('clients.notes.table.date')</th>
					<th>@lang('clients.notes.table.status')</th>
					<th>@lang('clients.notes.table.actions')</th>
				</tr>
			</thead>

			<tbody>
				@foreach ($notes as $note)
				@if ($note->is_draft)
					<tr>
						<td>{{ $note->therapist->name }}</td>
						<td>{{ $note->updated_at }}</td>
						<td>@lang('clients.notes.table.draft')</td>
						<td>
							<a
								class="btn btn-primary btn-sm"
								href="{{ url("clients/$user->id/notes/$note->uuid") }}"
							>
								<i class="fas fa-search mr-1"></i>
								@lang('clients.notes.table.view')
							</a>
						</td>
					</tr>
				@endif
				@endforeach
			</tbody>
		</table>
  </div>
</div>