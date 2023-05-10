<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('main',function (BreadcrumbTrail $trail){
    $trail->push('Home',route('main'));
});

//region User Management
Breadcrumbs::for('user-management',function (BreadcrumbTrail $trail){
    $trail->parent('main');
    $trail->push('User Management');
});
//region Role
Breadcrumbs::for('role',function (BreadcrumbTrail $trail){
    $trail->parent('user-management');
    $trail->push('Role',route('role.index'));
});
//endregion
//region Role
Breadcrumbs::for('permission',function (BreadcrumbTrail $trail){
    $trail->parent('user-management');
    $trail->push('Permission',route('permission.index'));
});
//endregion
//endregion

//region Master RM
Breadcrumbs::for('master-rm',function (BreadcrumbTrail $trail){
    $trail->parent('main');
    $trail->push('Master RM');
});
//region Fabric
Breadcrumbs::for('fabric',function (BreadcrumbTrail $trail){
    $trail->parent('master-rm');
    $trail->push('Jenis Fabric',route('master-rm.fabric.index'));
});
//endregion
//region Komposisi
Breadcrumbs::for('komposisi',function (BreadcrumbTrail $trail){
    $trail->parent('master-rm');
    $trail->push('Komposisi',route('master-rm.komposisi.index'));
});
//endregion
//region material
Breadcrumbs::for('material',function (BreadcrumbTrail $trail){
    $trail->parent('master-rm');
    $trail->push('Raw Material',route('master-rm.raw-material.index'));
});
Breadcrumbs::for('material.create',function (BreadcrumbTrail $trail){
    $trail->parent('material');
    $trail->push('New',route('master-rm.raw-material.index'));
});
Breadcrumbs::for('material.view',function (BreadcrumbTrail $trail){
    $trail->parent('material');
    $trail->push('View Data',route('master-rm.raw-material.index'));
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
    $trail->push('warna',route('master-warna.warna.index'));
});
//endregion
//region Warna Pantone
Breadcrumbs::for('pantone',function (BreadcrumbTrail $trail){
    $trail->parent('master-warna');
    $trail->push('Warna Pantone',route('master-warna.pantone.index'));
});
//endregion
//region Warna Aksesoris
Breadcrumbs::for('warna-aks',function (BreadcrumbTrail $trail){
    $trail->parent('master-warna');
    $trail->push('Warna Aksesoris',route('master-warna.warna-aksesoris.index'));
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
//region Article
Breadcrumbs::for('article',function (BreadcrumbTrail $trail){
    $trail->parent('master-data');
    $trail->push('Article');
});
Breadcrumbs::for('article.create',function (BreadcrumbTrail $trail){
    $trail->parent('article');
    $trail->push('New');
});
//endregion
//region Article Size
Breadcrumbs::for('size',function (BreadcrumbTrail $trail){
    $trail->parent('master-data');
    $trail->push('Article Size');
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
    $trail->push('Product Group',route('master-aks.product-group.index'));
});
//endregion
Breadcrumbs::for('aksesoris',function (BreadcrumbTrail $trail){
    $trail->parent('master-aks');
    $trail->push('Aksesoris',route('master-aks.aksesoris.index'));
});
Breadcrumbs::for('aksesoris.create',function (BreadcrumbTrail $trail){
    $trail->parent('aksesoris');
    $trail->push('New',route('master-aks.aksesoris.index'));
});
Breadcrumbs::for('aksesoris.view',function (BreadcrumbTrail $trail){
    $trail->parent('aksesoris');
    $trail->push('View Data',route('master-aks.aksesoris.index'));
});
//endregion

//region BOM
Breadcrumbs::for('bom',function (BreadcrumbTrail $trail){
    $trail->parent('main');
    $trail->push('Bill of Material');
});
Breadcrumbs::for('bom.create',function (BreadcrumbTrail $trail){
    $trail->parent('bom');
    $trail->push('New Bill of Material');
});
//endregion
