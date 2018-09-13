@include('partials.errors')

@if (session('message'))
    <div class="">
        {{ session('message') }}
    </div>
@endif

<h1>User: Invite</h1>

<form method="POST" action="/admin/users/invite">
    {!! csrf_field() !!}

    <div class="">
        @input_maker_label('Email')
        @input_maker_create('email', ['type' => 'string'])
    </div>

    <div class="">
         @input_maker_label('FirstName')
        @input_maker_create('firstname', ['type' => 'string'])
    </div>

    <div class="">
        @input_maker_label('LastName')
        @input_maker_create('lastname', ['type' => 'string'])
    </div>

    <div class="">
        @input_maker_label('Role')
        @input_maker_create('role', ['type' => 'relationship', 'model' => 'App\Models\Role', 'label' => 'label', 'value' => 'name'])
    </div>

    <div class="">
        <a href="{{ URL::previous() }}">Cancel</a>
        <button type="submit">Save</button>
    </div>
</form>

<a href="/admin/users">User Admin</a>
