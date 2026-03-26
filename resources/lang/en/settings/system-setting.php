<?php

return [
    'breadcrumb-before' => 'Settings',
    'breadcrumb-now' => 'System',
    'title' => 'System Settings',

    'general' => [
        'language' => [
            'label' => 'System Language',
        ],
        'theme' => [
            'label' => 'Display Theme',
            'options' => [
                'system' => 'Follow System (Default)',
                'light' => 'Light Mode',
                'dark' => 'Dark Mode',
            ],
        ],
    ],

    'work_schedule' => [
        'title' => 'Work Schedule Settings',

        'start_time' => 'Start Time',
        'end_time' => 'End Time',

        'work_days' => [
            'label' => 'Effective Work Days',
            'options' => [
                'monday' => 'Monday',
                'tuesday' => 'Tuesday',
                'wednesday' => 'Wednesday',
                'thursday' => 'Thursday',
                'friday' => 'Friday',
                'saturday' => 'Saturday',
                'sunday' => 'Sunday',
            ],
            'description' => 'Select the days when employees are required to check in and check out.',
        ],
    ],

    'actions' => [
        'save' => 'Save Settings',
    ],
];