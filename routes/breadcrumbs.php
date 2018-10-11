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
