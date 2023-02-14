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
//region Warna Pantone
Breadcrumbs::for('pantone',function (BreadcrumbTrail $trail){
    $trail->parent('master-warna');
    $trail->push('Warna Pantone',route('pantone.index'));
});
//endregion
//region Warna Aksesoris
Breadcrumbs::for('warna-aks',function (BreadcrumbTrail $trail){
    $trail->parent('master-warna');
    $trail->push('Warna Aksesoris',route('warna-aksesoris.index'));
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
//region Unit of Measure
Breadcrumbs::for('uom',function (BreadcrumbTrail $trail){
    $trail->parent('master-data');
    $trail->push('Unit of Measure',route('measure.index'));
});
//endregion
//region Supplier
Breadcrumbs::for('supplier',function (BreadcrumbTrail $trail){
    $trail->parent('master-data');
    $trail->push('Supplier',route('supplier.index'));
});
Breadcrumbs::for('supplier.create',function (BreadcrumbTrail $trail){
    $trail->parent('supplier');
    $trail->push('New',route('supplier.create'));
});
//endregion
//endregion

//region Master Aksesoris
Breadcrumbs::for('master-aks',function (BreadcrumbTrail $trail){
    $trail->parent('main');
    $trail->push('Master Aksesoris');
});
//region Product Group
Breadcrumbs::for('product-group',function (BreadcrumbTrail $trail){
    $trail->parent('master-aks');
    $trail->push('Product Group',route('product-group.index'));
});
//endregion
//endregion
