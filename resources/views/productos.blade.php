@extends('layout.app')
@section('content')
    <div class="container">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <a href="/"
                class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                <sv class="bi me-2" width="40" height="32">
                    <use xlink:href="#bootstrap" />
                    </sv}g>
                    <span class="fs-4">Gestión Productos</span>
            </a>

            <ul class="nav nav-pills">
                <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link">Cerrar Sesión</a></li>
            </ul>
        </header>
    </div>
    <div class="container">
        <div class="d-flex justify-content-end my-3">

            <button id="modal-registro" type="button" class="btn btn-primary mr-2 mt-2">Nuevo
                Producto</button>
        </div>
        <div class="table-responsive small">
            <table class="table table-striped table-sm" id="table-products">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th class="text-end">Precio</th>
                        <th class="text-end">Cantidad</th>
                        <th class="text-end">Categorias</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>


    <div class="modal fade" id="modalimagen" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header ml-auto">
                </div>
                <div class="modal-body p-2">
                    <div class="card card-custom">
                        <img src="" class="img-thumbnail" id="imgCategoria">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalcantidad" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModal">Actualizar Cantidad</h5>
                </div>
                <div class="modal-body p-2">
                    <div class="card card-custom">
                        <div class="row justify-content-center">
                            <div class="col-md-6 my-4">
                                <div class="form-group form-group-last">
                                    <div class="form-group">
                                        <input type="hidden" id="id_producto_cantidad" />
                                        <label class="form-label fw-bold">Cantidad</label>
                                        <input type="number" name="cantidad" id="cantidad_edit"
                                            class="form-control form-control-solid" required />
                                        <div class="invalid-feedback d-none" id="error_cantidad_edit"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="actualizarCantidad()" class="btn btn-primary font-weight-bold"
                        id="">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="crearproducto" tabindex="-1" role="dialog" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModal">Crear Producto</h5>
                </div>
                <div class="modal-body p-0">

                    <div class="card card-custom">
                        <!--begin::Form-->
                        <form class="form" id="formGuardarProducto" action="{{ route('productos.store') }}">
                            @csrf
                            <input type="hidden" id="id_producto" />
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-md-8 my-auto">

                                        <div class="row">

                                            <div class="col-md-6 my-auto">
                                                <div class="form-group form-group-last">
                                                    <div class="form-group">
                                                        <label class="form-label fw-bold">Código</label>
                                                        <input type="text" name="codigo" id="codigo"
                                                            class="form-control form-control-solid" required />
                                                        <div class="invalid-feedback d-none" id="error_codigo"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group form-group-last">
                                                    <div class="form-group">
                                                        <label class="form-label fw-bold">Nombre</label>
                                                        <input type="text" name="nombre" id="nombre"
                                                            class="form-control form-control-solid" required />
                                                        <div class="invalid-feedback d-none" id="error_nombre"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-4">
                                                <div class="form-group form-group-last">
                                                    <div class="form-group">
                                                        <label for="categorias" class="form-label fw-bold">Agregar
                                                            categorías (separadas por
                                                            comas)</label>
                                                        <input type="text" name="categorias" id="categorias"
                                                            class="form-control form-control-solid"
                                                            placeholder="Ej: Alimentos, Bebidas, Tecnología" required />
                                                        <div class="invalid-feedback d-none" id="error_categorias"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mt-4">
                                                <div class="form-group form-group-last">
                                                    <div class="form-group">
                                                        <label class="form-label fw-bold">Precio</label>
                                                        <input type="text" name="precio" id="precio"
                                                            class="form-control form-control-solid" required />
                                                        <div class="invalid-feedback d-none" id="error_precio"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mt-4">
                                                <div class="form-group form-group-last">
                                                    <div class="form-group">
                                                        <label class="form-label fw-bold">Cantidad</label>
                                                        <input type="number" name="cantidad" id="cantidad"
                                                            class="form-control form-control-solid" required />
                                                        <div class="invalid-feedback d-none" id="error_cantidad"></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-4 my-auto mt-3">
                                        <div class="col-md-12">
                                            <img id="imagen-actual" src="/images/logos_productos/default.webp"
                                                alt="Imagen actual" width="150px">
                                            <div class="form-group form-group-last">
                                                <div class="form-group">
                                                    <label for="imagen" class="form-label fw-bold">Imagen del
                                                        Producto</label>
                                                    <input type="file" class="form-control" id="imagen"
                                                        name="imagen">
                                                    <div class="invalid-feedback d-none" id="error_imagen"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </form>
                        <!--end::Form-->
                    </div>

                    <div class="modal-footer">
                        <button type="button" onclick="guardarProducto()" class="btn btn-primary font-weight-bold"
                            id="btnGuardar">Guardar</button>
                        <button type="button" onclick="actualizarProducto()"
                            class="btn btn-primary font-weight-bold d-none" id="btnActualizar">Actualizar</button>
                        <button type="button" class="btn btn-secundary font-weight-bold" id="cerrarModal"
                            data-dismiss="modal">Cerrar</button>
                    </div>

                </div> <!-- cierre del modal body -->
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/productos.js?v=1.0') }}"></script>
@endsection
