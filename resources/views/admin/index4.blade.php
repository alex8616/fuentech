@extends('layouts.my-dashboard-layout')

@section('content')
    <div class="row">
        <div class="col-12 col-sm-8">
            <div class="card">
                <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                    <a href="#tabs-productos" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">Productos</a>
                    </li>
                    <li class="nav-item" role="presentation">
                    <a href="#tabs-ingredientes" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Ingredientes</a>
                    </li>
                    <li class="nav-item" role="presentation">
                    <a href="#tabs-modificadores" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Modificadores</a>
                    </li>
                    <li class="nav-item" role="presentation">
                    <a href="#tabs-cantegoriaproductos" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Categoria Productos</a>
                    </li>
                    <li class="nav-item" role="presentation">
                    <a href="#tabs-cantegoriaingredientes" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Categoria Ingredientes</a>
                    </li>
                    <li class="nav-item" role="presentation">
                    <a href="#tabs-controlstock" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Control Stock</a>
                    </li>
                    <li class="nav-item" role="presentation">
                    <a href="#tabs-movimientossotck" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Movimiento Stock</a>
                    </li>
                    <li class="nav-item" role="presentation">
                    <a href="#tabs-listaprecios" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Lista Precios</a>
                    </li>
                </ul>
                </div>
                <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active show" id="tabs-productos" role="tabpanel">
                        <div class="card">
                            <div class="card-header" style="width: 100%; background-color: #1d2736">
                                <div class="row" style="width: 100%;">
                                    <div class="col-12 col-sm-8">
                                        <h3 class="card-title" style="color: white; font-weight: bold;">PRODUCTOS</h3>
                                    </div>
                                    <div class="col-12 col-sm-4" style="text-align: right;">
                                        <a class="btn" id="addproductos">+ PRODUCTOS</a>
                                        <a class="btn" id="exportproductos" style="padding-left: 25px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-folder-share" width="24" height="64" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 19h-8a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2h4l3 3h7a2 2 0 0 1 2 2v4" /><path d="M16 22l5 -5" /><path d="M21 21.5v-4.5h-4.5" /></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="background-color: #303847">
                                <div class="datagrid">
                                    <div class="datagrid-item">
                                        <div class="row">
                                            <div class="col-12 col-sm-4" id="all_productos" style="padding: 25px;">
                                                <div class="list-group list-group-transparent mb-3" id="listarcategorias">
                                                   
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-8" id="listarproductos" style="background: white; padding-top: 10px; padding-bottom: 10px">
                                                <div id="lista_productos">
                                                    <div class="mb-3 row">
                                                        <label class="col-4 col-form-label"> 
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M12 21h-5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v4.5" /><path d="M16.5 17.5m-2.5 0a2.5 2.5 0 1 0 5 0a2.5 2.5 0 1 0 -5 0" /><path d="M18.5 19.5l2.5 2.5" /></svg>    
                                                            Filtrar por producto: </label>
                                                        <div class="col-7">
                                                        <input type="text" class="form-control" id="SearchProduct" name="SearchProduct">
                                                        </div>
                                                        <div class="col-1" style="padding-top: 10px;">
                                                            <label class="form-check form-switch">
                                                            <input class="form-check-input" id="checkMostrar" type="checkbox">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="card">
                                                        <div class="table-responsive" id="tabla-productos">
                                                            <table class="table table-vcenter card-table">
                                                            <thead>
                                                                <tr>
                                                                <th>Codigo</th>
                                                                <th>Producto</th>
                                                                <th>Costo</th>
                                                                <th>Margen</th>
                                                                <th>Precio</th>
                                                                <th class="w-1"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                
                                                            </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-ingredientes" role="tabpanel">
                        <div class="card">
                            <div class="card-header" style="width: 100%; background-color: #1d2736">
                                <div class="row" style="width: 100%;">
                                    <div class="col-12 col-sm-8">
                                        <h3 class="card-title" style="color: white; font-weight: bold;">INGREDIENTES</h3>
                                    </div>
                                    <div class="col-12 col-sm-4" style="text-align: right;">
                                        <a class="btn" id="addingredientes">+ INGREDIENTE</a>
                                        <a class="btn" id="exportproductos" style="padding-left: 25px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-folder-share" width="24" height="64" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 19h-8a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2h4l3 3h7a2 2 0 0 1 2 2v4" /><path d="M16 22l5 -5" /><path d="M21 21.5v-4.5h-4.5" /></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="background-color: #303847">
                                <div class="datagrid">
                                    <div class="datagrid-item">
                                        <div class="row">
                                            <div class="col-12 col-sm-4" id="all_productos" style="padding: 25px;">
                                                <div class="list-group list-group-transparent mb-3" id="listaringredientes">
                                                   
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-8" id="listarproductos" style="background: white; padding-top: 10px; padding-bottom: 10px">
                                                <div id="lista_productos">
                                                    <div class="mb-3 row">
                                                        <label class="col-4 col-form-label"> 
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M12 21h-5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v4.5" /><path d="M16.5 17.5m-2.5 0a2.5 2.5 0 1 0 5 0a2.5 2.5 0 1 0 -5 0" /><path d="M18.5 19.5l2.5 2.5" /></svg>    
                                                            Filtrar por ingrediente: </label>
                                                        <div class="col-7">
                                                        <input type="text" class="form-control" id="SearchProduct" name="SearchProduct">
                                                        </div>
                                                    </div>
                                                    <div class="card">
                                                        <div class="table-responsive" id="tabla-ingredientes">
                                                            <table class="table table-vcenter card-table">
                                                            <thead>
                                                                <tr>
                                                                <th>Nombre</th>
                                                                <th>Unidad</th>
                                                                <th>Merma</th>
                                                                <th>Costo</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                
                                                            </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-modificadores" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Base info</h3>
                            </div>
                            <div class="card-body">
                                <div class="datagrid">
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Registrar</div>
                                        <div class="datagrid-content">Third Party</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-cantegoriaproductos" role="tabpanel">
                        <div class="card">
                            <div class="card-header" style="width: 100%; background-color: #1d2736">
                                <div class="row" style="width: 100%;">
                                    <div class="col-12 col-sm-8">
                                        <h3 class="card-title" style="color: white; font-weight: bold;">CATEGORIAS</h3>
                                    </div>
                                    <div class="col-12 col-sm-4" style="text-align: right;">
                                        <a class="btn" id="addpcategorias">+ CATEGORIA</a>
                                        <a class="btn" id="exportproductos" style="padding-left: 25px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-folder-share" width="24" height="64" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 19h-8a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2h4l3 3h7a2 2 0 0 1 2 2v4" /><path d="M16 22l5 -5" /><path d="M21 21.5v-4.5h-4.5" /></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="background-color: #303847">
                                <div class="datagrid">
                                    <div class="datagrid-item">
                                        <div class="row">
                                            <div class="col-12 col-sm-12" style="background: white; padding-top: 10px; padding-bottom: 10px">
                                                <div id="lista_categorias">
                                                    <div class="card">
                                                        <div class="table-responsive" id="tabla-categorias">
                                                            <table class="table table-vcenter card-table">
                                                            <thead>
                                                                <tr>
                                                                <th>Nombre</th>
                                                                <th>Cocina</th>
                                                                <th>Productos</th>
                                                                <th class="w-1"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                
                                                            </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-cantegoriaingredientes" role="tabpanel">
                        <div class="card">
                            <div class="card-header" style="width: 100%; background-color: #1d2736">
                                <div class="row" style="width: 100%;">
                                    <div class="col-12 col-sm-8">
                                        <h3 class="card-title" style="color: white; font-weight: bold;">CATEGORIA INGREDIENTES</h3>
                                    </div>
                                    <div class="col-12 col-sm-4" style="text-align: right;">
                                        <a class="btn" id="addpcategoriaingredientes">+ CATEGORIA</a>
                                        <a class="btn" id="exportproductos" style="padding-left: 25px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-folder-share" width="24" height="64" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 19h-8a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2h4l3 3h7a2 2 0 0 1 2 2v4" /><path d="M16 22l5 -5" /><path d="M21 21.5v-4.5h-4.5" /></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="datagrid">
                                    <div class="datagrid-item">
                                        <div class="row">
                                            <div class="col-12 col-sm-12" style="background: white; padding-top: 10px; padding-bottom: 10px">
                                                <div id="lista_categorias">
                                                    <div class="card">
                                                        <div class="table-responsive" id="tabla-categoria-ingredientes">
                                                            <table class="table table-vcenter card-table">
                                                            <thead>
                                                                <tr>
                                                                <th>Nombre</th>
                                                                <th>Ingrediente</th>
                                                                <th class="w-1"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                
                                                            </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                    
                    </div>
                    <div class="tab-pane" id="tabs-controlstock" role="tabpanel">                        
                        <div class="card">
                            <div class="card-header" style="width: 100%; background-color: #1d2736">
                                <div class="row" style="width: 100%;">
                                    <div class="col-12 col-sm-8">
                                        <h3 class="card-title" style="color: white; font-weight: bold;">CONTROL DE STOCK</h3>
                                    </div>
                                    <div class="col-12 col-sm-4" style="text-align: right;">
                                        <a class="btn" id="addproductos">+ PRODUCTOS</a>
                                        <a class="btn" id="exportproductos" style="padding-left: 25px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-folder-share" width="24" height="64" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 19h-8a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2h4l3 3h7a2 2 0 0 1 2 2v4" /><path d="M16 22l5 -5" /><path d="M21 21.5v-4.5h-4.5" /></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="datagrid">
                                    <div class="datagrid-item">
                                        <div class="row">
                                            <div class="col-12 col-sm-12" style="width: 100%; background: #F5F7F8; padding-top: 10px; padding-bottom: 10px">
                                                <div class="row" style="background: #F5F7F8;">
                                                    <div class="col-2 col-md-1" style="border-right: 2px solid #E6E6E6;">
                                                        <center>
                                                            <div class="icon-container">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-filter">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                    <path d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v7l-6 2v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227z" />
                                                                </svg>
                                                            </div>
                                                        </center>
                                                    </div>
                                                    <div class="col-10 col-md-11" style="padding-bottom: 12px;">
                                                        <div class="row" style="background: #F5F7F8;">
                                                            <div class="col-md-4">
                                                                <select name="" id="" class="form-control">
                                                                    <option value="">Proveedor</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" placeholder="Producto o Ingrediente" class="form-control"/>
                                                            </div>                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-2 col-md-1" style="border-top: 2px solid #E6E6E6; border-right: 2px solid #E6E6E6;">
                                                        <center>
                                                            <div class="icon-container">
                                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                                            </div>
                                                        </center>
                                                    </div>
                                                    <div class="col-10 col-md-11" style="border-top: 2px solid #E6E6E6;">
                                                        <div class="row" style="padding-top: 8px;">
                                                            <div class="col-10 col-md-3">
                                                                <label class="form-check" style="margin-right: 20px;">
                                                                    <input class="form-check-input" type="checkbox" style="width: 25px; height: 25px;">
                                                                    <span class="form-check-label" style="padding: 5px;">Disponibles</span>
                                                                </label>
                                                            </div>
                                                            <div class="col-10 col-md-3">
                                                                <label class="form-check" style="margin-right: 20px;">
                                                                    <input class="form-check-input" type="checkbox" style="width: 25px; height: 25px;">
                                                                    <span class="form-check-label" style="padding: 5px;">Poco Stock</span>
                                                                </label>
                                                            </div>
                                                            <div class="col-10 col-md-3">
                                                                <label class="form-check" style="margin-right: 20px;">
                                                                    <input class="form-check-input" type="checkbox" style="width: 25px; height: 25px;">
                                                                    <span class="form-check-label" style="padding: 5px;">Agotados</span>
                                                                </label>
                                                            </div>
                                                            <div class="col-10 col-md-3">
                                                                <label class="form-check">
                                                                    <input class="form-check-input" type="checkbox" style="width: 25px; height: 25px;">
                                                                    <span class="form-check-label" style="padding: 5px;">Sin Stock Definido</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12" style="width: 100%; padding-top: 15px; margin: 0px;">
                                                <div class="row">
                                                    <div class="col-12 col-sm-6">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <span>PRODUCTOS</span>
                                                            </div>
                                                            <div class="table-responsive" id="tabla-stockproducto">
                                                                <table class="table table-vcenter card-table">
                                                                    <thead>
                                                                        <tr>
                                                                        <th>Producto</th>
                                                                        <th>Stock</th>
                                                                        <th>Disponibles</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-6">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <span>INGREDIENTES</span>
                                                            </div>
                                                            <div class="table-responsive" id="tabla-stockingredientes">
                                                                <table class="table table-vcenter card-table">
                                                                    <thead>
                                                                        <tr>
                                                                        <th>Ingrediente</th>
                                                                        <th>Stock</th>
                                                                        <th>Disponibles</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                    
                    </div>
                    <div class="tab-pane" id="tabs-movimientossotck" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Base info</h3>
                            </div>
                            <div class="card-body">
                                <div class="datagrid">
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Registrar</div>
                                        <div class="datagrid-content">Third Party</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-listaprecios" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Base info</h3>
                            </div>
                            <div class="card-body">
                                <div class="datagrid">
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Registrar</div>
                                        <div class="datagrid-content">Third Party</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="card" id="form_tabs">
                <div class="card-header">
                    <h3 class="card-title">. . .</h3>
                </div>
                <div class="card-body">
                    <div class="datagrid">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal modal-blur fade" id="modal-image" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="file" class="form-control" id="ProductoImagenUpdate" name="ProductoImagenUpdate">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btn-cambiar-img" data-producto-id="1">Cambiar Imagen</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="modal-ingredientes" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Receta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-icon">
                    <input type="text" value="" class="form-control form-control" id="BuscarReceta" placeholder="Buscar Ingrediente" >
                    <span class="input-icon-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path><path d="M21 21l-6 -6"></path></svg>
                    </span>
                </div>
                
                <div class="row">
                    <div class="col-12 col-sm-12" id="contenedor-ingrediente">
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="BtnRegistrarReceta">Registrar</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
<div class="modal fade" id="modal-editar-receta" tabindex="-1" aria-labelledby="modal-editar-receta-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-editar-receta-label">Editar Receta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="hot-container"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <!-- Puedes agregar otros botones aquí si es necesario -->
      </div>
    </div>
  </div>
</div>

@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable@9.0.0/dist/handsontable.full.min.css">

<script src="https://cdn.jsdelivr.net/npm/handsontable@9.0.0/dist/handsontable.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
<script src="{{ asset('utilidades/js/productos.js') }}" defer></script>
<script src="{{ asset('utilidades/js/categorias.js') }}" defer></script>
<script src="{{ asset('utilidades/js/categoriasingredientes.js') }}" defer></script>
<script src="{{ asset('utilidades/js/ingredientes.js') }}" defer></script>

<style>
    .ui-autocomplete {
        max-height: 200px;
        overflow-y: auto;
        margin: 0px;
        padding: 0px;
        border: 1px solid black;
        background-color: white;
        color: #333;
    }

    .ui-autocomplete .ui-menu-item {
        padding: 8px 12px;
        cursor: pointer;
    }

    .ui-autocomplete .ui-menu-item-wrapper.ui-state-active {
        background-color: #fd7;
        border: 1px solid #fd7;
        color: black
    }

    .ui-autocomplete {
        font-family: Arial, sans-serif;
        font-size: 14px;
        border-radius: 4px;
    }

    .ui-autocomplete .ui-menu-item-wrapper {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }



    .icon-container {
        width: 40px;
        height: 40px;
    }

    .icon-container svg {
        width: 100%;
        height: 100%;
    }

    #tabla-productos .categoria-fila:hover {
        background-color: #FE8F8F;
    }
    #tabla-productos .categoria-fila.selected {
        background-color: #FE8F8F;
    }
    .selected {
        background-color: #FF0303;
    }
    .hovered{
        background-color: #fd7;
    }
    .tableproducseleccionado{
        background-color: #fd7;
    }
    .star-label {
        cursor: pointer;
    }
    #checkbox-1:checked + .star-label .icon-1 {
        color: gold;
    }

    .boton-registrar-favorito-sip {
        color: #007bff;
    }

    .fila-tachada td {
        text-decoration: line-through;
        color: #7077A1;
    }
    .seleccionado {
        background-color: #ffc0c8;
    }

    .seleccionadosub {
        background-color: #ffe9ec;
    }

    .selectedlist {
        background-color: red;
    }

    /* Estilos para la lista de subcategorías */
    .subcategorias-lista {
        list-style: none;
        padding-left: 0;
    }

    /* Estilos para los elementos de subcategoría */
    .subcategoria-item {
        padding: 10px 10px;
        background-color: #f9f9f9;
        color: #333;
        cursor: pointer;
    }

    /* Estilos para los elementos de subcategoría al pasar el ratón */
    .subcategoria-item:hover {
        background-color: #ffc0c8;
    }
</style>
@livewireStyles
<script>
    function MostrarTablaProductStock(){
        $.ajax({
            url: 'api/get-productos-stock',
            type: 'GET',
            success: function(data) {
                $('#tabla-stockproducto tbody').empty();
                $.each(data, function(index, producto) {
                    var borderStyle = (producto.MinimoStock > 0) ? 'border-left: 4px solid green;' : 'border-left: 4px solid red;';
                    var row = '<tr style="' + borderStyle + '">' +
                        '<td hidden>' + producto.id + '</td>' +
                        '<td>' + producto.NombreProducto + '</td>' +
                        '<td>' + (producto.CantidadStock ? producto.CantidadStock : '-') + '</td>' +
                        '<td>' + (producto.CantidadStock ? producto.CantidadStock : '-') + '</td>' +
                        '</tr>';
                    $('#tabla-stockproducto tbody').append(row);
                });

                agregarEventosTabla();

                $('#tabla-stockproducto tbody').on('click', 'tr', function() {
                    var id = $(this).find('td:first').text();
                    $.ajax({
                        url: '/api/get-productos-seleccionado/' + id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            console.log(data)
                            InformacionProductoStock(data);
                        },
                        error: function(error) {
                            console.error('Error al recuperar datos de producto:', error);
                        }
                    });
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function agregarEventosTabla() {
        $('#tabla-stockproducto tbody tr').hover(function() {
            $(this).addClass('hovered');
        }, function() {
            $(this).removeClass('hovered');
        });
        $('#tabla-stockproducto tbody tr').click(function() {
            $('#tabla-stockproducto tbody tr').removeClass('tableproducseleccionado');
            $(this).addClass('tableproducseleccionado').siblings().removeClass('tableproducseleccionado');
        });
    }


    function InformacionProductoStock(data){
        var TotalProduct = document.getElementById('form_tabs');
        TotalProduct.innerHTML = `
            <div class="col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">${data.NombreProducto}</h3>
                        <div class="card-actions">
                        <a href="#" class="btn" data-producto-id="${data.id}" id="AddProductoStock">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil-minus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /><path d="M16 19h6" /></svg>
                        </a>
                        </div>
                    </div>
                    <div class="card-body p-12" style="height: 100%">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Disponibles</label>
                                    <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.CantidadStock} unid. (En Stock)</label>                                                    
                                    </div>
                                </div>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Stock</label>
                                    <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.CantidadStock}</label>                                                    
                                    </div>
                                </div>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Stock Minimo</label>
                                    <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.CantidadStock}</label>                                                    
                                    </div>
                                </div>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Proveedor</label>
                                    <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.proveedor ? data.proveedor.name : 'Sin proveedor'}</label>
                                    </div>
                                </div>
                            </div>
                        </div>                                                                                                
                    </div>
                </div>
            </div>
        `;

        $('#AddProductoStock').on('click', function() {
            TotalProduct.innerHTML = ``;
            TotalProduct.innerHTML = `
            <div class="col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> EDITANDO ${data.NombreProducto}</h3>
                        <div class="card-actions">
                        </div>
                    </div>
                    <div class="card-body p-12" style="height: 100%">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Disponibles</label>
                                    <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.CantidadStock} unid. (En Stock)</label>                                                    
                                    </div>
                                </div><br>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Stock</label>
                                    <div class="col">
                                        <input type="text" class="form-control" id="UpdateCantidadStock" name="UpdateCantidadStock" value="${data.CantidadStock}">
                                    </div>
                                </div><br>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Stock Minimo</label>
                                    <div class="col">
                                        <input type="text" class="form-control" id="UpdateCantidadStockMinimo" name="UpdateCantidadStockMinimo" value="${data.CantidadStock}">
                                    </div>
                                </div><br>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Comentario</label>
                                    <div class="col">
                                        <textarea class="form-control" rows="5" id="UpdateComentarioStock" name="UpdateComentarioStock" value="${data.ComentarioStock}"></textarea>
                                    </div>
                                </div><br>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary me-2" id="EditBtnGuardarStock">Guardar</button>
                                    <button class="btn btn-danger" id="EditBtnCancelarStock">Cancelar</button>
                                </div>
                            </div>
                        </div>                                                                                                
                    </div>
                </div>
            </div>`;   
             
            $('#EditBtnGuardarStock').off('click').on('click', function(event) {
                var IdUpdate = `${data.id}`;
                var CantidadStock = $("#UpdateCantidadStock").val();
                var CantidadStockMinimo = $("#UpdateCantidadStockMinimo").val();
                var ComentariodStock = $("#UpdateComentarioStock").val();

                var datosRecogidos = {
                    id: IdUpdate,
                    cantidad: CantidadStock,
                    minimo: CantidadStockMinimo,
                    comentario: ComentariodStock
                };

                $.ajax({
                    url: '/api/actualizar-producto-stock',
                    type: 'POST',
                    data: datosRecogidos,
                    success: function (producto) {
                        MostrarTablaProductStock()
                        CanvasTime();
                        MostrarMensaje("Se Actualizo El Producto Exitosamente", "success");
                    },
                    error: function (error) {
                        console.error('Error al registrar:', error);
                    }
                });
            });

        });
    }
    

    $(document).ready(function() {  
        MostrarTablaProductStock();
    });
</script>
@livewireScripts
