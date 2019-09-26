<?php

// Dashboard
Breadcrumbs::register('dashboard', function($breadcrumbs){
    $breadcrumbs->push('Dashboard', route('backend::dashboard'), ['icon' => 'fa fa-dashboard']);
});

// Home > About
Breadcrumbs::register('about', function($breadcrumbs){
    // $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('About', route('backend::about'));
});

// Home > About
Breadcrumbs::register('permitsControl', function($breadcrumbs){
    $breadcrumbs->push('Permits Control B3', route('backend::permitsControl'));
});
Breadcrumbs::register('permitsControl_add', function($breadcrumbs){
    // $breadcrumbs->parent('penyimpananLimbahB3');
    $breadcrumbs->push('Tambah Data', route('backend::permitsControl_add'));
});
Breadcrumbs::register('permitsControl_tabelData', function($breadcrumbs){
    // $breadcrumbs->parent('penyimpananLimbahB3');
    $breadcrumbs->push('Table Data', route('backend::permitsControl'));
});

Breadcrumbs::register('mouControl', function($breadcrumbs){
    // $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('MOU Control', route('backend::mouControl'));
});

Breadcrumbs::register('truckPermits_add', function($breadcrumbs){
    // $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Tambah Truck Permits', route('backend::truckPermits_add'));
});

Breadcrumbs::register('truckPermits', function($breadcrumbs){
    // $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('List Truck Permits', route('backend::truckPermits'));
});

Breadcrumbs::register('manifestControl', function($breadcrumbs){
    $breadcrumbs->push('Manifest Control', route('backend::manifestControl'));
});

Breadcrumbs::register('penyimpananLimbahB3', function($breadcrumbs){
    $breadcrumbs->push('Penyimpanan Limbah B3', route('backend::penyimpananLimbahB3'));
});

Breadcrumbs::register('penyimpananLimbahB3_add', function($breadcrumbs){
    // $breadcrumbs->parent('penyimpananLimbahB3');
    $breadcrumbs->push('Tambah Data', route('backend::penyimpananLimbahB3_add'));
});

Breadcrumbs::register('penyimpananLimbahB3_tabelData', function($breadcrumbs){
    // $breadcrumbs->parent('penyimpananLimbahB3');
    $breadcrumbs->push('Table Data', route('backend::penyimpananLimbahB3'));
});

Breadcrumbs::register('pengangkutanLimbahB3', function($breadcrumbs){
    $breadcrumbs->push('Pengangkutan Limbah B3', route('backend::pengangkutanLimbahB3'));
});

Breadcrumbs::register('pengangkutanLimbahB3_add', function($breadcrumbs){
    $breadcrumbs->parent('pengangkutanLimbahB3');
    $breadcrumbs->push('Tambah Data', route('backend::pengangkutanLimbahB3_add'));
});

Breadcrumbs::register('pengangkutanLimbahB3_tabelData', function($breadcrumbs){
    $breadcrumbs->parent('pengangkutanLimbahB3');
    $breadcrumbs->push('Table Data', route('backend::pengangkutanLimbahB3'));
});


// Breadcrumbs::register('pengangkutanLimbah', function($breadcrumbs){
//     $breadcrumbs->parent('LogbookLimbahB3');
//     $breadcrumbs->push('Tabel Data Limbah B3', route('backend::logbookLimbahB3'));
// });
