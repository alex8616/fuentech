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
                </ul>
                </div>
                <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active show" id="tabs-productos" role="tabpanel">
                        <div class="card">
                            <div class="card-header" style="width: 100%; background-color: #1d2736">
                                <div class="row" style="width: 100%;">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content align-items-center">
                                            <h3 class="card-title" style="color: white; font-weight: bold;">PRODUCTOS</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end align-items-center">
                                            <a class="btn me-2" id="addproductos">+ PRODUCTOS</a>
                                            <a class="btn me-2" id="exportproductos" data-bs-toggle="modal" data-bs-target="#ModalImportProduct">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-folder-share" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 19h-8a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2h4l3 3h7a2 2 0 0 1 2 2v4" /><path d="M16 22l5 -5" /><path d="M21 21.5v-4.5h-4.5" /></svg>
                                            </a>
                                            <select class="form-select" style="width: auto;">
                                                <option value="TODOS">TODOS</option>
                                                <option value="FAVOTIROS">FAVOTIROS</option>
                                            </select>
                                        </div>
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
                                        <a class="btn" id="exportproductos" style="padding-left: 25px;" data-bs-toggle="modal" data-bs-target="#ModalImportIngrediente">
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
                                                        <input type="text" class="form-control" id="SearchIngrediente" name="SearchIngrediente">
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
                            <div class="card-header" style="width: 100%; background-color: #1d2736">
                                <div class="row" style="width: 100%;">
                                    <div class="col-12 col-sm-8">
                                        <h3 class="card-title" style="color: white; font-weight: bold;">GRUPO DE MODIFICADORES</h3>
                                    </div>
                                    <div class="col-12 col-sm-4" style="text-align: right;">
                                        <a class="btn" id="addModificador">+ Nuevo Grupo Modificador</a>
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
                                                        <div class="table-responsive" id="tabla-modificadores">
                                                            <table class="table table-vcenter card-table">
                                                            <thead>
                                                                <tr>
                                                                <th>Nombre</th>
                                                                <th>Cantidad De Productos</th>
                                                                <th>Cant. Minima</th>
                                                                <th>Cant. Maxima</th>
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

    <div class="modal modal-blur fade" id="modal-grupos" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Grupos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-icon">
                    <input type="text" value="" class="form-control form-control" id="BuscarModificador" placeholder="Buscar Modificador" >
                    <span class="input-icon-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path><path d="M21 21l-6 -6"></path></svg>
                    </span>
                </div>
                
                <div class="row">
                    <div class="col-12 col-sm-12" id="contenedor-modificador">
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="BtnRegistrarModificador">Registrar</button>
            </div>
            </div>
        </div>
    </div>
    
    <div class="modal modal-blur fade" id="modal-editar-receta" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Receta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="recetaTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Ingrediente</th>
                            <th>Cant. Neta</th>
                            <th>Merma</th>
                            <th>Cant. Bruta</th>
                            <th>Unid.</th>
                            <th>Costo Ingre.</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="recetaTableBody">
                        
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="ModalImportProduct" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-status bg-success"></div>
          <div class="modal-body text-center py-4">
            <div class="container mt-5">
                <h2>Importar Productos</h2>
                @if (session('success'))
                    <div class="alert alert-success">
                    {{ session('success') }}
                    </div>
                @endif
                <form id="importForm" action="{{ route('productos.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                    <label for="file">Selecciona un archivo Excel</label>
                    <input type="file" name="file" id="fileInput" class="form-control" required>
                    </div>
                </form>
            </div>
          </div>
          <div class="modal-footer">
            <div class="w-100">
              <div class="row">
                <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                    Cancelar
                  </a></div>
                <div class="col"><a href="#" class="btn btn-success w-100" data-bs-dismiss="modal" id="importButton">
                    Importar Productos
                  </a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal modal-blur fade" id="ModalImportIngrediente" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-status bg-success"></div>
          <div class="modal-body text-center py-4">
            <div class="container mt-5">
                <h2>Importar Ingredientes</h2>
                <form id="importFormIngrediente" action="{{ route('ingredientes.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                    <label for="file">Selecciona un archivo Excel</label>
                    <input type="file" name="file" id="fileInput" class="form-control" required>
                    </div>
                </form>
            </div>
          </div>
          <div class="modal-footer">
            <div class="w-100">
              <div class="row">
                <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                    Cancelar
                  </a></div>
                <div class="col"><a href="#" class="btn btn-success w-100" data-bs-dismiss="modal" id="importButtonIngredientes">
                    Importar Ingredientes
                  </a></div>
              </div>
            </div>
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
<script src="{{ asset('utilidades/js/modificador.js') }}" defer></script>

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
    .tableingredienteseleccionado{
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

    #CardOcupado{
        background-color: #ffffff;
        opacity: 0.6;
        background-size: 9px 9px;
        background-image: repeating-linear-gradient(45deg, #ff0000 0, #ff0000 0.8px, #ffffff 0, #ffffff 50%);
    }


    #sugerencias-nombre {
        max-height: 200px;
        overflow-y: auto;
        border-radius: 5px;
        background-color: white;
        width: calc(100% - 30px);
        z-index: 1000;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: none; 
    }

    .sugerencia-item {
        padding: 8px 12px;
    }

    .sugerencia-item:hover {
        background-color: #f1f1f1;
    }

    .sugerencia-item strong {
        font-weight: bold;
        color: #333;
    }

    .sugerencia-item + .sugerencia-item {
        border-top: 1px solid #eee; 
    }


</style>
@livewireStyles
<script>
    //importar datos del excel
    $(document).ready(function() {
        cargarProveedores()
        
        $('#importButton').click(function() {
            var formData = new FormData($('#importForm')[0]);
            $.ajax({
            url: '{{ route('productos.import') }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                MostrarMensaje("Se Importo Los Productos Exitosamente", "success");
                $('#importForm').trigger('reset');
            },
            error: function(error) {
                MostrarMensaje("Algo Fallo !!", "error");
                console.error(error);
            }
            });
        });

        $('#importButtonIngredientes').click(function() {
            var formData = new FormData($('#importFormIngrediente')[0]);
            $.ajax({
            url: '{{ route('ingredientes.import') }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                MostrarMensaje("Se Importo Los Productos Exitosamente", "success");
                $('#importFormIngrediente').trigger('reset');
            },
            error: function(error) {
                MostrarMensaje("Algo Fallo !!", "error");
                console.error(error);
            }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        function getBaseUrl() {
            var url = window.location.href;
            var baseUrl = url.split('#')[0];
            return baseUrl;
        }

        function updateUrl(tabId) {
            var newUrl = getBaseUrl() + tabId;
            window.history.replaceState(null, null, newUrl);
        }

        $(window).on('load', function() {
            updateUrl('#tabs-productos');
        });

        $('.nav-tabs .nav-link').on('click', function(e) {
            e.preventDefault();
            var tabId = $(this).attr('href');
            updateUrl(tabId);
        });
    });
</script>
<script>
    function cargarProveedores(){
        $.ajax({
            url: '/api/get-proveedor',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                const proveedorSelect = $('#ProveedorKardex');
                proveedorSelect.empty();
                proveedorSelect.append('<option value="">Seleccionar Proveedor</option>');
                $.each(data, function(index, proveedor) {
                    proveedorSelect.append('<option value="' + proveedor.id + '">' + proveedor.name + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar los proveedores:', error);
                alert('Ocurrió un error al cargar los proveedores');
            }
        });
    }
</script>
@livewireScripts
