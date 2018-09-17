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

// User Settings
Breadcrumbs::for('user.settings', function ($trail) {
    $trail->push(__('user.settings.breadcrumb'), url('user/settings'));
});

// User Settings > Change Password
Breadcrumbs::for('user.password', function ($trail) {
    $trail->parent('user.settings');
    $trail->push(__('user.password.breadcrumb'), url('user/password'));
});
