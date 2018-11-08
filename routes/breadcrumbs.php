<?php

// Activity Log
Breadcrumbs::for('admin.logs.index', function ($trail) {
    $trail->push(__('admin.logs.index.breadcrumb'), url('admin/logs'));
});

// Activity Log > View
Breadcrumbs::for('admin.logs.show', function ($trail, $log) {
    $trail->parent('admin.logs.index');
    $trail->push(__('admin.logs.show.breadcrumb'), url('admin/logs', $log->id));
});

// Clients
Breadcrumbs::for('clients.index', function ($trail) {
    $trail->push(__('clients.index.breadcrumb'), url('clients'));
});

// Clients > Client Profile
Breadcrumbs::for('clients.show', function ($trail, $user) {
    $trail->parent('clients.index');
    $trail->push(
        __('clients.show.breadcrumb'),
        url("clients/$user->id")
    );
});

// Clients > Client Profile > Notes
Breadcrumbs::for('clients.notes.index', function ($trail, $user) {
    $trail->parent('clients.show', $user);
    $trail->push(
        __('clients.notes.index.breadcrumb'),
        url("clients/$user->id/notes")
    );
});

// Clients > Client Profile > Notes > Create
Breadcrumbs::for('clients.notes.create', function ($trail, $user) {
    $trail->parent('clients.notes.index', $user);
    $trail->push(
        __('clients.notes.create.breadcrumb'),
        url("clients/$user->id/notes/create")
    );
});

// Clients > Client Profile > Notes > View
Breadcrumbs::for('clients.notes.show', function ($trail, $user, $note) {
    $trail->parent('clients.notes.index', $user);
    $trail->push(
        __('clients.notes.show.breadcrumb'),
        url("clients/$user->id/notes/$note->uuid")
    );
});

// Clients > Client Profile > Notes > Create Attachment
Breadcrumbs::for('clients.attachments.create', function ($trail, $user) {
    $trail->parent('clients.notes.index', $user);
    $trail->push(
        __('clients.attachments.create.breadcrumb'),
        url("clients/$user->id/attachments/create")
    );
});

// Clients > Client Profile > Notes > View Attachment
Breadcrumbs::for('clients.attachments.show', function ($trail, $user, $attachment) {
    $trail->parent('clients.notes.index', $user);
    $trail->push(
        __('clients.attachments.show.breadcrumb'),
        url("clients/$user->id/attachments/$attachment->uuid")
    );
});

// Clients > Client Profile > Notes > Create Communication Log
Breadcrumbs::for('clients.communication.create', function ($trail, $user) {
    $trail->parent('clients.notes.index', $user);
    $trail->push(
        __('clients.communication.create.breadcrumb'),
        url("clients/$user->id/communication/create")
    );
});

// Clients > Client Profile > Notes > View Communication Log
Breadcrumbs::for('clients.communication.show', function ($trail, $user, $communication) {
    $trail->parent('clients.notes.index', $user);
    $trail->push(
        __('clients.communication.show.breadcrumb'),
        url("clients/$user->id/communication/$communication->uuid")
    );
});

// Clients > Client Profile > Notes > Create Receipt
Breadcrumbs::for('clients.receipts.create', function ($trail, $user) {
    $trail->parent('clients.notes.index', $user);
    $trail->push(
        __('clients.receipts.create.breadcrumb'),
        url("clients/$user->id/receipts/create")
    );
});

// Clients > Client Profile > Questionnaires
Breadcrumbs::for('clients.questionnaires.index', function ($trail, $user) {
    $trail->parent('clients.show', $user);
    $trail->push(
        __('clients.questionnaires.index.breadcrumb'),
        url("clients/$user->id/questionnaires")
    );
});

// Clients > Client Profile > Questionnaires > Assign
Breadcrumbs::for('clients.questionnaires.create', function ($trail, $user) {
    $trail->parent('clients.questionnaires.index', $user);
    $trail->push(
        __('clients.questionnaires.create.breadcrumb'),
        url("clients/$user->id/questionnaires/create")
    );
});

// Clients > Client Profile > Questionnaires > View
Breadcrumbs::for('clients.questionnaires.show', function ($trail, $user, $response) {
    $trail->parent('clients.questionnaires.index', $user);
    $trail->push(
        __('clients.questionnaires.show.breadcrumb'),
        url("clients/$user->id/questionnaires/$response->id")
    );
});

// Dashboard (Admin)
Breadcrumbs::for('admin.dashboard', function ($trail) {
    $trail->push(__('admin.dashboard.breadcrumb'), url('admin/dashboard'));
});

// Dashboard (Client & Therapist)
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push(__('dashboard.breadcrumb'), url('dashboard'));
});

// Doctors
Breadcrumbs::for('admin.doctors.index', function ($trail) {
    $trail->push(__('admin.doctors.index.breadcrumb'), url('admin/doctors'));
});

// Doctors > Create
Breadcrumbs::for('admin.doctors.create', function ($trail) {
    $trail->parent('admin.doctors.index');
    $trail->push(__('admin.doctors.create.breadcrumb'), url('admin/doctors/create'));
});

// Doctors > Edit
Breadcrumbs::for('admin.doctors.edit', function ($trail, $doctor) {
    $trail->parent('admin.doctors.index');
    $trail->push(
        __('admin.doctors.edit.breadcrumb'),
        url("admin/doctors/$doctor->uuid/edit")
    );
});

// Clinics
Breadcrumbs::for('admin.clinics.index', function ($trail) {
    $trail->push(__('admin.clinics.index.breadcrumb'), url('admin/clinics'));
});

// Clinics > assign
Breadcrumbs::for('admin.clinics.assignclinic', function ($trail,$clinic) {
	$trail->parent('admin.clinics.index');
    $trail->push(__('admin.clinics.assignclinic.breadcrumb'), url('admin/clinics/$clinic->id/assignclinics'));
});

// Clinics > assign >assign user
Breadcrumbs::for('admin.clinics.assignclinic.assignuser', function ($trail,$clinic) {
	$trail->parent('admin.clinics.index');
    $trail->push(__('admin.clinics.assignclinic.breadcrumb'), url('admin/clinics/$clinic->id/assignclinics/assign'));
});

// Clinics > Create
Breadcrumbs::for('admin.clinics.create', function ($trail) {
    $trail->parent('admin.clinics.index');
    $trail->push(__('admin.clinics.create.breadcrumb'), url('admin/clinics/create'));
});

// Clinics > Edit
Breadcrumbs::for('admin.clinics.edit', function ($trail, $clinic) {
    $trail->parent('admin.clinics.index');
    $trail->push(
        __('admin.clinics.edit.breadcrumb'),
        url("admin/clinics/$clinic->uuid/edit")
    );
});

// Questionnaires
Breadcrumbs::for('responses.index', function ($trail) {
    $trail->push(__('responses.index.breadcrumb'), url('responses'));
});

// Questionnaires > View
Breadcrumbs::for('responses.show', function ($trail, $response) {
    $trail->parent('responses.index');
    $trail->push(__('responses.show.breadcrumb'), url("responses/$response->uuid"));
});

// Roles
Breadcrumbs::for('admin.roles.index', function ($trail) {
    $trail->push(__('admin.roles.index.breadcrumb'), url('admin/roles'));
});

// Roles > Edit
Breadcrumbs::for('admin.roles.edit', function ($trail, $role) {
    $trail->parent('admin.roles.index');
    $trail->push(__('admin.roles.edit.breadcrumb'), url("admin/roles/$role->id/edit"));
});

// Roles > Create
Breadcrumbs::for('admin.roles.create', function ($trail) {
    $trail->parent('admin.roles.index');
    $trail->push(__('admin.roles.create.breadcrumb'), url('admin/roles/create'));
});

// Groups
Breadcrumbs::for('admin.groups.index', function ($trail) {
    $trail->push(__('admin.groups.index.breadcrumb'), url('admin/groups'));
});

// Groups > Create
Breadcrumbs::for('admin.groups.create', function ($trail) {
    $trail->parent('admin.groups.index');
    $trail->push(__('admin.groups.create.breadcrumb'), url('admin/groups/create'));
});

// Groups > Edit
Breadcrumbs::for('admin.groups.edit', function ($trail, $group) {
    $trail->parent('admin.groups.index');
    $trail->push(__('admin.groups.edit.breadcrumb'), url("admin/groups/$group->id/edit"));
});

// User > Edit > Groups
Breadcrumbs::for('admin.users.groups.index', function ($trail, $user) {
    $trail->parent('admin.users.edit', $user);
    $trail->push(
        __('admin.users.groups.index.breadcrumb'),
        url("admin/users/$user->id/groups")
    );
});

// Admin > Groups > Notes
Breadcrumbs::for('groups.notes.index', function ($trail, $group) {
    // $trail->parent('groups.index');
    $trail->push(
        __('groups.notes.index.breadcrumb'),
        url("groups/$group->uuid/notes")
    );
});

// Admin > Groups > Notes > Create
Breadcrumbs::for('groups.notes.create', function ($trail, $group) {
    $trail->parent('groups.notes.index', $group);
    $trail->push(
        __('groups.notes.create.breadcrumb'),
        url("groups/$group->uuid/notes/create")
    );
});

// Admin > Groups > Notes > View
Breadcrumbs::for('groups.notes.show', function ($trail, $group, $note) {
    $trail->parent('groups.notes.index', $group, $note);
    $trail->push(
        __('groups.notes.show.breadcrumb'),
        url("groups/$group->uuid/notes/$note->uuid")
    );
});

// Groups > Group Profile > Questionnaires
Breadcrumbs::for('groups.questionnaires.index', function ($trail, $group) {
    $trail->push(
        __('groups.questionnaires.index.breadcrumb'),
        url("groups/$group->uuid/questionnaires")
    );
});

// Groups > Group Profile > Questionnaires > Assign
Breadcrumbs::for('groups.questionnaires.create', function ($trail, $group) {

    $trail->push(
        __('groups.questionnaires.create.breadcrumb'),
        url("groups/$group->uuid/questionnaires/create")
    );
});

// Groups > Group Profile > Questionnaires > View
Breadcrumbs::for('groups.questionnaires.show', function ($trail, $group, $response) {
    $trail->push(
        __('groups.questionnaires.show.breadcrumb'),
        url("groups/$group->uuid/questionnaires/$response->uuid")
    );
});

// Users
Breadcrumbs::for('admin.users.index', function ($trail) {
    $trail->push(__('admin.users.index.breadcrumb'), url('admin/users'));
});

// Users > Edit
Breadcrumbs::for('admin.users.edit', function ($trail, $user) {
    $trail->parent('admin.users.index');
    $trail->push(__('admin.users.edit.breadcrumb'), url("admin/users/$user->id/edit"));
});

// Users > Invite
Breadcrumbs::for('admin.users.invite', function ($trail) {
    $trail->parent('admin.users.index');
    $trail->push(__('admin.users.create.breadcrumb'), url('admin/users/invite'));
});

// Users > User Profile
Breadcrumbs::for('admin.users.show', function ($trail, $user) {
    $trail->parent('admin.users.index');
    $trail->push(
        __('admin.users.show.breadcrumb', ['role' => $user->roleName()]),
        url("admin/users/$user->id")
    );
});

// Users > Edit > Therapists
Breadcrumbs::for('admin.users.therapists.index', function ($trail, $user) {
    $trail->parent('admin.users.edit', $user);
    $trail->push(
        __('admin.users.therapists.index.breadcrumb'),
        url("admin/users/$user->id/therapists")
    );
});

// User Settings
Breadcrumbs::for('user.settings', function ($trail) {
    $trail->push(__('user.settings.breadcrumb'), url('user/settings'));
});

// User Settings > Change Password
Breadcrumbs::for('user.password', function ($trail) {
    $trail->parent('user.settings');
    $trail->push(__('user.password.breadcrumb'), url('user/password'));
});

// User Settings > Change Signature
Breadcrumbs::for('user.signature', function ($trail) {
    $trail->parent('user.settings');
    $trail->push(__('user.signature.breadcrumb'), url('user/signature'));
});
