<?php

return [
    'breadcrumb-before' => 'Pengaturan',
    'breadcrumb-now' => 'Sistem',
    'title' => 'Pengaturan Sistem',

    'general' => [
        'language' => [
            'label' => 'Bahasa Sistem',
        ],
        'theme' => [
            'label' => 'Tema Tampilan',
            'options' => [
                'system' => 'Ikuti Sistem (Default)',
                'light' => 'Mode Terang',
                'dark' => 'Mode Gelap',
            ],
        ],
    ],

    'work_schedule' => [
        'title' => 'Pengaturan Jadwal Kerja',

        'start_time' => 'Jam Masuk',
        'end_time' => 'Jam Pulang',

        'work_days' => [
            'label' => 'Hari Kerja Efektif',
            'options' => [
                'monday' => 'Senin',
                'tuesday' => 'Selasa',
                'wednesday' => 'Rabu',
                'thursday' => 'Kamis',
                'friday' => 'Jumat',
                'saturday' => 'Sabtu',
                'sunday' => 'Minggu',
            ],
            'description' => 'Centang hari di mana karyawan diwajibkan untuk melakukan absensi (Check In & Check Out).',
        ],
    ],

    'actions' => [
        'save' => 'Simpan Pengaturan',
    ],
];