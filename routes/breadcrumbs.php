<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('main',function (BreadcrumbTrail $trail){
    $trail->push('Home',route('main'));
});

//region Master RM
Breadcrumbs::for('master-rm',function (BreadcrumbTrail $trail){
    $trail->parent('main');
    $trail->push('Master RM');
});
//region Fabric
Breadcrumbs::for('fabric',function (BreadcrumbTrail $trail){
    $trail->parent('master-rm');
    $trail->push('Jenis Fabric',route('fabric.index'));
});
//endregion
//region Komposisi
Breadcrumbs::for('komposisi',function (BreadcrumbTrail $trail){
    $trail->parent('master-rm');
    $trail->push('Komposisi',route('komposisi.index'));
});
//endregion
//endregion

//region Master Warna
Breadcrumbs::for('master-warna',function (BreadcrumbTrail $trail){
    $trail->parent('main');
    $trail->push('Master Warna');
});
//region Warna MD
Breadcrumbs::for('warna',function (BreadcrumbTrail $trail){
    $trail->parent('master-warna');
    $trail->push('warna',route('warna.index'));
});
//endregion
//endregion

//region Master Data
Breadcrumbs::for('master-data',function (BreadcrumbTrail $trail){
    $trail->parent('main');
    $trail->push('Master Data');
});
//region Brands
Breadcrumbs::for('brands',function (BreadcrumbTrail $trail){
    $trail->parent('master-data');
    $trail->push('Brands',route('brands.index'));
});
//endregion
//endregion
