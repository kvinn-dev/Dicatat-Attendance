<?php

return [
    'breadcrumb-before' => 'Settings',
    'breadcrumb-now' => 'Profile',
    'title' => 'Profile Settings',

    'profile_info' => [
        'title' => 'Profile Information',
        'description' => 'Update your personal information and email address.',

        'fields' => [
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone Number',
            'department' => 'Department / Division',
            'position' => 'Position / Job Title',
        ],

        'actions' => [
            'save' => 'Save Changes',
        ],
    ],

    'change_password' => [
        'title' => 'Update Password',
        'description' => 'Ensure your account uses a long, random password to stay secure.',

        'fields' => [
            'new_password' => 'New Password',
            'confirm_password' => 'Confirm Password',
        ],

        'actions' => [
            'update' => 'Update Password',
        ],
    ],
];