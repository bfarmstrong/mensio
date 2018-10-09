<?php

return [
    'dashboard' => [
        'breadcrumb' => 'Dashboard',
    ],
    'logs' => [
        'form-static' => [
            'action' => 'Action',
            'causer-id' => 'Causer Id',
            'causer-type' => 'Causer Type',
            'details' => 'Details',
            'encrypted-value' => 'These details are encrypted',
            'subject-id' => 'Subject Id',
            'subject-type' => 'Subject Type',
            'timestamp' => 'Timestamp',
        ],
        'index' => [
            'activity-log' => 'Activity Log',
            'breadcrumb' => 'Activity Log',
            'no-results' => 'No logs were found...',
            'title' => 'Activity Log',
        ],
        'show' => [
            'activity-log' => 'Activity Log',
            'breadcrumb' => 'View',
            'title' => 'Activity Log',
        ],
        'table' => [
            'action' => 'Action',
            'actions' => 'Actions',
            'causer-id' => 'Causer Id',
            'causer-type' => 'Causer Type',
            'subject-id' => 'Subject Id',
            'subject-type' => 'Subject Type',
            'timestamp' => 'Timestamp',
            'view' => 'View',
        ],
    ],
    'roles' => [
        'create' => [
            'breadcrumb' => 'Create',
            'form-title' => 'Create Role',
            'title' => 'Create Role',
        ],
        'edit' => [
            'breadcrumb' => 'Edit',
            'form-title' => 'Edit Role',
            'title' => 'Edit Role',
        ],
        'form' => [
            'cancel' => 'Cancel',
            'name' => 'Name',
            'label' => 'Label',
            'level' => 'Level',
            'permissions' => 'Permissions',
            'save' => 'Save',
        ],
        'form-delete' => [
            'delete' => 'Delete',
            'on-submit' => 'Are you sure you want to delete this role?',
        ],
        'form-search' => [
            'search' => 'Search...',
            'submit' => 'Get Results',
        ],
        'index' => [
            'breadcrumb' => 'Roles',
            'create-role' => 'Create Role',
            'created-role' => 'Role was successfully created.',
            'deleted-role' => 'Role was successfully deleted.',
            'no-results' => 'No roles were found...',
            'roles' => 'Roles',
            'updated-role' => 'Role was successfully updated.',
            'title' => 'All Roles',
        ],
        'table' => [
            'actions' => 'Actions',
            'delete' => 'Delete',
            'edit' => 'Edit',
            'label' => 'Label',
            'name' => 'Name',
        ],
    ],
    'users' => [
        'create' => [
            'breadcrumb' => 'Invite',
            'form-title' => 'Invite User',
            'title' => 'Invite User',
        ],
        'edit' => [
            'breadcrumb' => 'Edit',
            'form-title' => 'Edit :Role',
            'title' => 'Edit :Role',
        ],
        'form-delete' => [
            'delete' => 'Delete',
            'on-submit' => 'Are you sure you want to delete this user?',
        ],
        'form-search' => [
            'search' => 'Exact name required...',
            'submit' => 'Get Results',
        ],
        'form-static' => [
            'email' => 'Email',
            'name' => 'Name',
            'user-since' => ':name Since',
        ],
        'index' => [
            'breadcrumb' => 'Users',
            'create-user' => 'Invite User',
            'created-user' => 'User was successfully created.',
            'deleted-user' => 'User was successfully deleted.',
            'no-results' => 'No users were found...',
            'no-search-results' => 'No user was found matching your query.',
            'switched-back' => 'You have restored your original session.',
            'switched-to' => 'You are now signed in as :User.',
            'title' => 'All Users',
            'updated-user' => 'User was successfully updated.',
            'users' => 'Users',
        ],
        'show' => [
            'breadcrumb' => ':Role Profile',
            'form-title' => ':Role Profile',
            'title' => ':Role Profile',
        ],
        'table' => [
            'actions' => 'Actions',
            'edit' => 'Edit',
            'email' => 'Email',
            'name' => 'Name',
            'role' => 'Role',
            'view' => 'View',
        ],
        'therapists' => [
            'form-add' => [
                'name' => 'Name',
                'save' => 'Save',
            ],
            'form-delete' => [
                'on-submit' => 'Are you sure you want to remove this therapist?',
                'remove' => 'Remove',
            ],
            'index' => [
                'add-therapist' => 'Add Therapist',
                'added-therapist' => 'The therapist was added successfully.',
                'breadcrumb' => 'Therapists',
                'current-therapists' => 'Current Therapists',
                'removed-therapist' => 'The therapist was removed successfully.',
                'title' => 'Therapists',
            ],
            'table' => [
                'actions' => 'Actions',
                'name' => 'Name',
            ],
        ],
    ],
];
