var arrayProductos = [];
$(document).ready(function () {
    $("#modal-registro").click(function () {
        $("#titleModal").text("Crear PRoducto");
        $("#formGuardarProducto")[0].reset();
        $("#btnGuardar").removeClass("d-none");
        $("#btnActualizar").addClass("d-none");
        $("#imagen-actual").attr("src", "/images/logos_productos/default.webp");
        $("#codigo").prop("readonly", false);
        $(".invalid-feedback").removeClass("d-flex");
        $("#crearproducto").modal("show");
    });

    $("#cerrarModal").click(function () {
        $("#crearproducto").modal("hide");
    });

    $("#table-products").DataTable();

    consultarProductos();

    document
        .getElementById("imagen")
        .addEventListener("change", function (event) {
            var reader = new FileReader();

            reader.onload = function (e) {
                // Actualizar la imagen previsualizada con la nueva
                document.getElementById("imagen-actual").src = e.target.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        });
});

function consultarProductos() {
    swal.showLoading();
    axios.get("/api/get-productos").then((res) => {
        let tabla = $("#table-products").DataTable();
        tabla.clear().draw();
        for (registro of res.data) {
            arrayProductos = res.data;
            let categorias = "";
            for (categoria of registro.categorias) {
                categorias += `<p class="text-end">${categoria.nombre_categoria} <i class="fas fa-trash c-pointer ml-2" onclick="eliminarCategoria(${categoria.id},${registro.id})"></i></p>`;
            }

            tabla.row
                .add([
                    `<a onclick=varImagen('${registro.imagen}') title="Ver imagen" class="btn btn-sm btn-clean btn-icon"><img src="/images/logos_productos/${registro.imagen}" class="img-thumbnail" width="40" height="40"</a>`,
                    registro.codigo,
                    registro.nombre,
                    `<p class="text-end">$${registro.precio}</p>`,
                    `<p class="text-end">${registro.cantidad}</p>`,
                    categorias,
                    `<div class="text-center"><a class="c-pointer" onclick="editarProducto(${registro.id})">Editar</a><br><br><a class="c-pointer" onclick="editarCantidad(${registro.id},${registro.cantidad})">Cantidad</a><br><br><a class="c-pointer" onclick="eliminarProducto(${registro.id})">Eliminar</a></div>`,
                ])
                .draw();
        }
        swal.close();
    });
}

function varImagen(img) {
    $("#imgCategoria").attr("src", "/images/logos_productos/" + img);
    $("#modalimagen").modal("show");
}

function guardarProducto() {
    let form = $("#formGuardarProducto")[0];
    let datos = new FormData(form);
    swal.showLoading();
    axios.post(form.action, datos).then(
        (res) => {
            $(".invalid-feedback").removeClass("d-flex");
            if (!res.ErrorStatus) {
                $("#formGuardarProducto")[0].reset();
                $("#crearproducto").modal("hide");
                consultarProductos();
                swal.fire({
                    icon: "success",
                    title: "Se ha creado el producto",
                    showConfirmButton: false,
                    timer: 1500,
                });
            } else {
                swal.fire({
                    icon: "error",
                    title: "Ocurrió un error",
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        },
        (err) => {
            swal.close();
            $(".invalid-feedback").removeClass("d-flex");
            let arrErrors = err.response.data.errors;
            if (arrErrors.codigo) {
                $("#error_codigo").text(arrErrors.codigo[0]);
                $("#error_codigo").addClass("d-flex");
            }
            if (arrErrors.nombre) {
                $("#error_nombre").text(arrErrors.nombre[0]);
                $("#error_nombre").addClass("d-flex");
            }
            if (arrErrors.categorias) {
                $("#error_categorias").text(arrErrors.categorias[0]);
                $("#error_categorias").addClass("d-flex");
            }
            if (arrErrors.precio) {
                $("#error_precio").text(arrErrors.precio[0]);
                $("#error_precio").addClass("d-flex");
            }
            if (arrErrors.cantidad) {
                $("#error_cantidad").text(arrErrors.cantidad[0]);
                $("#error_cantidad").addClass("d-flex");
            }
            if (arrErrors.imagen) {
                $("#error_imagen").text(arrErrors.imagen[0]);
                $("#error_imagen").addClass("d-flex");
            }
        }
    );
}

function actualizarProducto() {
    let form = $("#formGuardarProducto")[0];
    let datos = new FormData(form);
    swal.showLoading();
    axios.post(`/productos/${$("#id_producto").val()}`, datos).then(
        (res) => {
            $(".invalid-feedback").removeClass("d-flex");
            if (!res.ErrorStatus) {
                $("#formGuardarProducto")[0].reset();
                $("#crearproducto").modal("hide");
                consultarProductos();
                swal.fire({
                    icon: "success",
                    title: "Se ha creado el producto",
                    showConfirmButton: false,
                    timer: 1500,
                });
            } else {
                swal.fire({
                    icon: "error",
                    title: "Ocurrió un error",
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        },
        (err) => {
            swal.close();
            $(".invalid-feedback").removeClass("d-flex");
            let arrErrors = err.response.data.errors;
            if (arrErrors.codigo) {
                $("#error_codigo").text(arrErrors.codigo[0]);
                $("#error_codigo").addClass("d-flex");
            }
            if (arrErrors.nombre) {
                $("#error_nombre").text(arrErrors.nombre[0]);
                $("#error_nombre").addClass("d-flex");
            }
            if (arrErrors.categorias) {
                $("#error_categorias").text(arrErrors.categorias[0]);
                $("#error_categorias").addClass("d-flex");
            }
            if (arrErrors.precio) {
                $("#error_precio").text(arrErrors.precio[0]);
                $("#error_precio").addClass("d-flex");
            }
            if (arrErrors.cantidad) {
                $("#error_cantidad").text(arrErrors.cantidad[0]);
                $("#error_cantidad").addClass("d-flex");
            }
            if (arrErrors.imagen) {
                $("#error_imagen").text(arrErrors.imagen[0]);
                $("#error_imagen").addClass("d-flex");
            }
        }
    );
}

function eliminarProducto(idProducto) {
    swal.showLoading();
    axios.delete(`/productos/${idProducto}`).then(
        (res) => {
            consultarProductos();
        },
        (err) => {
            swal.close();
            swal.fire({
                icon: "error",
                title: "Ocurrió un error",
                showConfirmButton: false,
                timer: 1500,
            });
        }
    );
}

function eliminarCategoria(idCategoria, idProducto) {
    swal.showLoading();
    axios.delete(`/eliminarCategoria/${idCategoria}/${idProducto}`).then(
        (res) => {
            consultarProductos();
        },
        (err) => {
            swal.close();
            swal.fire({
                icon: "error",
                title: "Ocurrió un error",
                showConfirmButton: false,
                timer: 1500,
            });
        }
    );
}

function editarProducto(id) {
    let datos = arrayProductos.filter((res) => res.id == id);

    datos = datos[0];

    let categorias = "";
    for (cat of datos.categorias) {
        categorias += cat.nombre_categoria + ",";
    }
    if (categorias != "") {
        categorias = categorias.slice(0, -1);
    }

    $("#id_producto").val(id);
    $("#codigo").val(datos.codigo);
    $("#nombre").val(datos.nombre);
    $("#precio").val(datos.precio);
    $("#cantidad").val(datos.cantidad);
    $("#categorias").val(categorias);
    $("#imagen-actual").attr("src", `/images/logos_productos/${datos.imagen}`);
    $("#titleModal").text("Actualizar Producto");
    $("#btnActualizar").removeClass("d-none");
    $("#btnGuardar").addClass("d-none");
    $("#codigo").prop("readonly", true);
    $(".invalid-feedback").removeClass("d-flex");
    $("#crearproducto").modal("show");
}

function editarCantidad(idPRoducto, cantidad) {
    $("#cantidad_edit").val(cantidad);
    $("#id_producto_cantidad").val(idPRoducto);
    $("#modalcantidad").modal("show");
}

function actualizarCantidad() {
    const idProducto = $("#id_producto_cantidad").val();
    const cantidad = $("#cantidad_edit").val();
    if (cantidad == "" || cantidad < 0) {
        swal.fire({
            icon: "warning",
            title: "Digita una cantidad valida",
            showConfirmButton: false,
            timer: 1500,
        });
        return;
    }
    swal.showLoading();
    axios.get(`/updateCantidad/${cantidad}/${idProducto}`).then(
        (res) => {
            consultarProductos();
            $("#modalcantidad").modal("hide");
        },
        (err) => {
            swal.close();
            swal.fire({
                icon: "error",
                title: "Ocurrió un error",
                showConfirmButton: false,
                timer: 1500,
            });
        }
    );
}
