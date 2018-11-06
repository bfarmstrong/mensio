<?php

return [
    'dashboard' => [
        'breadcrumb' => 'Dashboard',
    ],
	'clinics' => [
        'create' => [
            'breadcrumb' => 'Create',
            'form-title' => 'Create Clinic',
            'title' => 'Create Clinic',
        ],
		'assignclinic' => [
            'assign' => 'Assign User',
			'breadcrumb' => 'Assign User',
			'users' => 'Users',
			'assign-users' =>'Assign',
			'no-results' => 'No users were found...',
			'form-title' => 'Create Clinic',
			'form-assign-button' => 'Assign',
			'user-assigned' => "Clinic was successfully assigned",
			'form-delete' => 'Unassign',
			'on-submit' => 'Are you sure you want to unassign this user?',
			'deleted-user-clinic' => 'User was unassigned successfully',
            'title' => 'All Users',
        ],
        'edit' => [
            'breadcrumb' => 'Edit',
            'form-title' => 'Edit Clinic',
            'title' => 'Edit Clinic',
        ],
        'form' => [
            'address' => 'Address',
            'name' => 'Name',
            'save' => 'Save',
            'subdomain' => 'Subdomain',
        ],
        'form-delete' => [
            'delete' => 'Delete',
            'on-submit' => 'Are you sure you want to delete this clinic?',
        ],
        'form-search' => [
            'search' => 'Search...',
            'submit' => 'Get Results',
        ],
        'index' => [
            'breadcrumb' => 'Clinics',
            'create-clinic' => 'Create Clinic',
            'created-clinic' => 'Clinic was successfully created.',
            'deleted-clinic' => 'Clinic was successfully deleted.',
            'clinics' => 'Clinics',
            'no-results' => 'No clinics were found...',
            'title' => 'All Clinics',
            'updated-clinic' => 'Clinic was successfully updated.',
			'switched-back' => 'You have restored your original session.',
        ],
        'table' => [
            'actions' => 'Actions',
            'edit' => 'Edit',
            'name' => 'Name',
            'email' => 'Email',
        ],
    ],
    'doctors' => [
        'create' => [
            'breadcrumb' => 'Create',
            'form-title' => 'Create Doctor',
            'title' => 'Create Doctor',
        ],
        'edit' => [
            'breadcrumb' => 'Edit',
            'form-title' => 'Edit Doctor',
            'title' => 'Edit Doctor',
        ],
        'form' => [
            'address' => 'Address',
            'email' => 'Email',
            'name' => 'Name',
            'phone' => 'Practice Phone',
            'save' => 'Save',
            'specialty' => 'Specialty',
        ],
        'form-delete' => [
            'delete' => 'Delete',
            'on-submit' => 'Are you sure you want to delete this doctor?',
        ],
        'form-search' => [
            'search' => 'Search...',
            'submit' => 'Get Results',
        ],
        'index' => [
            'breadcrumb' => 'Doctors',
            'create-doctor' => 'Create Doctor',
            'created-doctor' => 'Doctor was successfully created.',
            'deleted-doctor' => 'Doctor was successfully deleted.',
            'doctors' => 'Doctors',
            'no-results' => 'No doctors were found...',
            'title' => 'All Doctors',
            'updated-doctor' => 'Doctor was successfully updated.',
        ],
        'table' => [
            'actions' => 'Actions',
            'edit' => 'Edit',
            'name' => 'Name',
        ],
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
	'groups' => [
			'create' => [
				'breadcrumb' => 'Create',
				'form-title' => 'Create Group',
				'title' => 'Create Group',
			],
			'edit' => [
				'breadcrumb' => 'Edit',
				'form-title' => 'Edit Group',
				'title' => 'Edit Group',
			],
			'form' => [
				'cancel' => 'Cancel',
				'name' => 'Name',
				'therapists' => 'Therapists',
				'save' => 'Save',
			],
			'form-delete' => [
				'delete' => 'Delete',
				'on-submit' => 'Are you sure you want to delete this group?',
			],
			'form-search' => [
				'search' => 'Search...',
				'submit' => 'Get Results',
			],
			'index' => [
				'breadcrumb' => 'Groups',
				'create-groups' => 'Create Group',
				'created-group' => 'Group was successfully created.',
				'deleted-group' => 'Group was successfully deleted.',
				'no-results' => 'No groups were found...',
				'groups' => 'Groups',
				'updated-group' => 'Group was successfully updated.',
				'title' => 'All Groups',
			],
			'table' => [
				'actions' => 'Actions',
				'delete' => 'Delete',
				'edit' => 'Edit',
                'label' => 'Label',
                'members' => 'Members',
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
            'address-line-1' => 'Line 1',
            'address-line-2' => 'Line 2',
            'address' => 'Address',
            'basic-information' => 'Basic Information',
            'cell-phone' => 'Cell Phone',
            'city' => 'City',
            'country' => 'Country',
            'doctor' => 'Doctor',
            'email' => 'Email',
            'emergency-contact' => 'Emergency Contact',
            'emergency-name' => 'Name',
            'emergency-phone' => 'Phone',
            'emergency-relationship' => 'Relationship',
            'health-card-number' => 'Health Insurance Number',
            'home-phone' => 'Home Phone',
            'license' => 'License Number',
            'name' => 'Name',
            'notes' => 'Notes',
            'postal-code' => 'Postal Code',
            'preferred-contact-method' => 'Preferred Contact Method',
            'province' => 'Province',
            'referrer' => 'Referrer',
            'user-since' => ':name Since',
            'work-phone' => 'Work Phone',
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
            'assign-clinic' => 'Assign Clinics',
			'inactive-user' => 'User is inactive',
			'active-user' => 'User is active',
        ],
        'show' => [
            'breadcrumb' => ':Role Profile',
            'edit' => 'Edit',
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
            'form-supervisor' => [
                'save' => 'Save',
            ],
            'index' => [
                'add-therapist' => 'Add Therapist',
                'added-supervisor' => 'The supervisor was added successfully.',
                'added-therapist' => 'The therapist was added successfully.',
                'breadcrumb' => 'Therapist',
                'current-therapists' => 'Current Therapists',
                'removed-supervisor' => 'The supervisor was removed successfully.',
                'removed-therapist' => 'The therapist was removed successfully.',
                'title' => 'Therapists',
            ],
            'table' => [
                'actions' => 'Actions',
                'name' => 'Name',
                'supervisor' => 'Supervisor',
                'supervisor-required' => 'A supervisor should be assigned.',
            ],
        ],

       'groups' => [
            'form-add' => [
                'name' => 'Name',
                'save' => 'Save',
            ],
            'form-delete' => [
                'on-submit' => 'Are you sure you want to remove this Group?',
                'remove' => 'Remove',
            ],
            'index' => [
                'add-group' => 'Add Group',
                'added-group' => 'The Group was added successfully.',
                'breadcrumb' => 'Groups',
                'current-groups' => 'Current Groups',
                'removed-supervisor' => 'The supervisor was removed successfully.',
                'removed-group' => 'The Group was removed successfully.',
                'already-in-group' => 'The Group was already added',
				'title' => 'Groups',
            ],
            'table' => [
                'actions' => 'Actions',
                'name' => 'Name',
            ],
        ],
    ],
];
