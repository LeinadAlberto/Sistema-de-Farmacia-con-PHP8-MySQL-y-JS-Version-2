$(document).ready(function() {

    /* Metodo que funciona dentro adm_catalogo.php - Calcula el total de precio de todos
    los productos */
    calcularTotal();

    Contar_productos(); 

    RecuperarLS_carrito();

    /* Funciónes de Administrar Compra */
    RecuperarLS_carrito_compra();
    /* =============================== */

    $(document).on('click', '.agregar-carrito', (e) => {

        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id = $(elemento).attr('prodId');
        const nombre = $(elemento).attr('prodNombre');
        const concentracion = $(elemento).attr('prodConcentracion');
        const adicional = $(elemento).attr('prodAdicional');
        const precio = $(elemento).attr('prodPrecio');
        const laboratorio = $(elemento).attr('prodLaboratorio');     /* id de laboratorio :   FK => prod_lab(producto)*/
        const tipo = $(elemento).attr('prodTipo');                   /* id de tipo_producto : FK => prod_tip_prod(producto)*/
        const presentacion = $(elemento).attr('prodPresentacion');   /* id de presentacion :  FK => prod_present(producto)*/
        const avatar = $(elemento).attr('prodAvatar'); 
        const stock = $(elemento).attr('prodStock');

        const producto = {
            id: id,
            nombre: nombre,
            concentracion: concentracion,
            adicional: adicional,
            precio: precio,
            laboratorio: laboratorio,
            tipo: tipo,
            presentacion: presentacion,
            avatar: avatar,
            stock: stock,
            cantidad: 1
        }; 
        
        /* console.log(producto); */

        let id_producto;

        let productos; 

        /* Retorna un Array de Objetos JS */
        productos = RecuperarLS();

        /*  Verifica si el id del producto que se quiere agregar al carrito es igual a algun id de producto 
            que ya fue agregado al LocalStorage, si se cumple esa condición obtenemos el id de este producto
            que se esta repitiendo.     */
        productos.forEach(prod => {

            if (prod.id === producto.id) {

                id_producto = prod.id;

            }

        });

        /* Si el producto ya fue agregado al carrito mando una alerta */
        if (id_producto === producto.id) {
            Swal.fire({
                icon: 'error',
                title: 'Recuerda...',
                text: 'Ya enviaste al carrito este producto!',
            });
        } else { 
            template = `
                <tr prodId="${producto.id}">
                    <td>${producto.id}</td>
                    <td>${producto.nombre}</td>
                    <td>${producto.concentracion}</td>
                    <td>${producto.adicional}</td>
                    <td>${producto.precio}</td>
                    <td><button class="borrar-producto btn btn-danger"><i class="fas fa-times-circle"></i></button></td>
                </tr>
            `;
            
            /* Agrega el producto al carrito de compras */
            $('#lista').append(template); 

            /* console.log("***** Producto Agregando al Carrito de Compras *****"); */
        
            /* Función que permite agregar un producto al LocalStorage */
            AgregarLS(producto);

            Contar_productos(); 

        }
    });

    $(document).on('click', '.borrar-producto', (e) => {

        const elemento = $(this)[0].activeElement.parentElement.parentElement;

        const id = $(elemento).attr('prodId'); 

        elemento.remove();

        Eliminar_producto_LS(id);

        Contar_productos(); 

        calcularTotal();

    });

    $(document).on('click', '#vaciar-carrito', (e) => {

        $('#lista').empty();

        EliminarLS();

        /* console.log("**** Carrito de Compras y LocalStorage vaciado *****"); */

        Contar_productos(); 

    });

    $(document).on('click', '#procesar-pedido', (e) => {

        Procesar_pedido();

    })

    $(document).on('click', '#procesar-compra', (e) => {

        Procesar_compra();

    });

    /* Método que me recupera la información almacenada en el LocalStorage */
    function RecuperarLS() {

        let productos;

        /*  Si el valor almacenado bajo la clave 'productos' en el local storage 
            es igual a NULL, productos sera un array vacío. */
        if (localStorage.getItem('productos') === null) {
            
            productos = [];
        
        /*  Caso contrario obtiene el valor almacenado bajo la clave 'productos' en el 
            local storage este valor es un string en formato JSON, posteriormente convierte 
            el string JSON en una array de objetos JavaScript */
        } else {
            
            productos = JSON.parse(localStorage.getItem('productos'));
            /* console.log(`Productos desde el Local Storage ${productos}`); */
            
        }

        return productos;
    }

    /* Método que permite almacenar un array de objetos producto en el LocalStorage */
    function AgregarLS(producto) {

        let productos;

        productos = RecuperarLS(); /* Array de objetos JavaScript o un array vacío */

        productos.push(producto); /* Adiciona un objeto producto al Array de objetos */
        
        /* Almacena el string JSON de un array de Objetos llamado productos en el LocalStorage bajo la clave productos */
        localStorage.setItem('productos', JSON.stringify(productos));

        console.log("**** Producto Agregado al LocalStorage *****");
    }

    /* Cuando se refresca la página recupera los datos del Local Storage
    y lo imprime en el carrito */
    function RecuperarLS_carrito() {

        let productos;

        let id_producto;

        productos = RecuperarLS();
        /* console.log("RecuperarLS_carrito");
        console.log(productos);
        console.log(productos[0]); */
        /* const numeroElementos = Object.keys((productos[0])).length; */
        /* console.log("Numero de elementos del Objeto 1 es : " +  numeroElementos);
        console.log("=================="); */
        funcion = 'buscar_id'; 

        productos.forEach(producto => {

            id_producto = producto.id;

            $.post('../controlador/ProductoController.php', {funcion, id_producto}, (response) => {

                /* console.log(response); */

                let template_carrito = '';

                let json = JSON.parse(response); 

                /* console.log(json); */

                template_carrito = `
                    <tr prodId="${json.id}">
                        <td>${json.id}</td>
                        <td>${json.nombre}</td>
                        <td>${json.concentracion}</td>
                        <td>${json.adicional}</td>
                        <td>${json.precio}</td>
                        <td>
                            <button class="borrar-producto btn btn-danger">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </td>
                    </tr>
                `; 

                $('#lista').append(template_carrito);
        
            });  

        });

    }

    function Eliminar_producto_LS(id) {

        let productos;

        productos = RecuperarLS();

        /* En el array de objetos, elimina el objeto cuyo id es igual al id enviado como parametro */
        productos.forEach(function(producto, indice) {

            if (producto.id === id) {

                productos.splice(indice,1);

            }

        });

        localStorage.setItem('productos', JSON.stringify(productos));
    }

    function EliminarLS() {

        localStorage.clear();
        
    }

    function Contar_productos() {

        let productos;

        let contador = 0;

        productos = RecuperarLS();

        productos.forEach(producto => {

            contador = contador + 1;

        });

        $('#contador').html(contador);

    }

    /* Método que te manda a la vista para Administrar Compra cuando se preciona
    sobre el boton Procesar Compra del carrito de compras, si no se tiene productos,
    en el carrito este te manda un mensaje que pide tener agregados productos al 
    carrito de compras.  */
    function Procesar_pedido() {

        let productos;

        productos = RecuperarLS();

        if (productos.length === 0) {

            Swal.fire({
                icon: 'error',
                title: 'Tienes que agregar productos al carrito',
                text: 'El carrito esta vacio!'
            });

        } else {

            location.href = '../vista/adm_compra.php';

        }

    }

    /* ================= Eventos y Funciones para la vista Administrar Compra ======================== */

    /* Método descartado para listar compras */
    function RecuperarLS_carrito_compra1() {

        let productos; 
        /* console.log(productos); */ // Output: undefined

        let id_producto; 

        productos = RecuperarLS();
        /* console.log('==== Array de Productos en formato JSON ===='); 
        console.log(productos);  */

        funcion = 'buscar_id'; 

        productos.forEach(producto => {

            id_producto = producto.id; 

            console.log(id_producto);

            /* console.log(`ID del Objeto Producto : ${id_producto}`); */

            $.post('../controlador/ProductoController.php', { funcion, id_producto }, (response) => {

                let template_compra = '';

                let json = JSON.parse(response);

                console.log('id backend: ' + json.id); 

                /* console.log(json); */
                template_compra = `
                    <tr prodId="${producto.id}" prodPrecio="${json.precio}">
                        <td>${json.nombre}</td>
                        <td>${json.stock}</td>
                        <td class="precio">${json.precio}</td>
                        <td>${json.concentracion}</td>
                        <td>${json.adicional}</td>
                        <td>${json.laboratorio}</td>
                        <td>${json.presentacion}</td>
                        <td>
                            <input type="number" min="1" class="form-control cantidad_producto" value="${producto.cantidad}">
                        </td>
                        <td class="subtotales">
                            <h5>${json.precio * producto.cantidad}</h5>
                        </td>

                        <td><button class="borrar-producto btn btn-danger"><i class="fas fa-times-circle"></i></button></td>
                    </tr>
                `; 
            
                $('#lista-compra').append(template_compra);

            });

        });

    }

    /* Método que recupera del Local Storage todo el array de productos y lo renderiza dentro la vista 
    adm_compra.php, especificamente dentro <tbody id="lista-compra">, que es parte de el elemento
    <table class="compra"> */
    async function RecuperarLS_carrito_compra() {

        let productos; 
    
        productos = RecuperarLS();

        /* console.log('==== Array de Productos en formato JSON ====');  */

        /* console.log(productos);   */

        funcion = 'traer_productos'; 

        const response = await fetch('../controlador/ProductoController.php', {

            method: 'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body: 'funcion=' + funcion + '&&productos=' + JSON.stringify(productos)

        });

        let resultado = await response.text();

        $('#lista-compra').append(resultado);

    }

    $(document).on('click', '#actualizar', (e) => {
        
        let productos, precios;

        precios = document.querySelectorAll('.precio');

        /* console.log(precios); */

        productos = RecuperarLS();

        /* console.log(productos); */

        productos.forEach(function(producto, indice) {

            producto.precio = precios[indice].textContent;

        });

        localStorage.setItem('productos', JSON.stringify(productos)); 

        calcularTotal();

    });

    $('#cp').keyup((e) => {

        let id, cantidad, producto, productos, montos, precio;

        producto = $(this)[0].activeElement.parentElement.parentElement; /* Selecciona el elemento <tr></tr> */
        
        /* console.log(producto); */

        id = $(producto).attr('prodId');

        precio = $(producto).attr('prodPrecio');

        /* console.log(id); */

        cantidad = producto.querySelector('input').value;   /* Obtiene el valor que se ingresa en el input */

        /* console.log(cantidad); */

        montos = document.querySelectorAll('.subtotales');   /* NodeList con todos los subtotales */

        /* console.log(montos); */

        productos = RecuperarLS();  /* Array de Objetos JS */

        /* console.log(productos); */ 

        productos.forEach(function(prod, indice) {

            /* console.log(prod); */

            /* console.log(indice); */

            if (prod.id === id) {

                prod.cantidad = cantidad;

                prod.precio = precio;

                montos[indice].innerHTML = `<h5>${cantidad * precio}</h5>`;
            } 
        });

        localStorage.setItem('productos', JSON.stringify(productos)); 

        calcularTotal();

    });

    function calcularTotal() {
        
        let productos, subtotal, con_igv, total_sin_descuento, pago, vuelto, descuento;

        let total = 0, igv = 0.18;

        productos = RecuperarLS();

        productos.forEach(producto => {

            let subtotal_producto = Number(producto.precio * producto.cantidad);

            total = total + subtotal_producto;

        });

        pago = $('#pago').val();

        descuento = $('#descuento').val();

        total_sin_descuento = total.toFixed(2);

        con_igv = parseFloat(total * igv).toFixed(2); /* Obtiene el 18% del total, considerando que sea un valor decimal. */

        subtotal = parseFloat(total - con_igv).toFixed(2); /* Le resta al total el 18% de IGV */

        total = total - descuento;

        vuelto = pago - total;

        $('#subtotal').html(subtotal);

        $('#con_igv').html(con_igv);

        $('#total_sin_descuento').html(total_sin_descuento);

        $('#total').html(total.toFixed(2));

        $('#vuelto').html(vuelto.toFixed(2));

    }

    function Procesar_compra() {

        let nombre, dni;

        nombre = $('#cliente').val();

        dni = $('#dni').val();

        if (RecuperarLS().length == 0) {

            Swal.fire({
                icon: 'error',
                title: 'Oops',
                text: 'No hay productos, Seleccione algunos!'
            }).then(function() {
                location.href = '../vista/adm_catalogo.php';
            });

        } else if (nombre == '') {

            Swal.fire({
                icon: 'error',
                title: 'Oops',
                text: 'Ingrese un nombre de Cliente'
            });

        } else {

            Verificar_stock().then(error => {

                if (error == 0) {

                    Registrar_compra(nombre, dni);

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Se realizo la compra con exito',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {

                        EliminarLS();

                        location.href = '../vista/adm_catalogo.php';

                    });

                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Stock insuficiente',
                        text: 'Uno de los productos no cuenta con el stock necesario para la compra'
                    });

                }
            });

        }

    }
    
    /* async: false |  Para que se maneje de forma sincronica. */

    /* function Verificar_stock() {

        let productos, id, cantidad;

        let error = 0;

        funcion = 'verificar_stock';

        productos = RecuperarLS();

        productos.forEach(producto => {
            
            id = producto.id;

            cantidad = producto.cantidad;

            $.ajax({

                url: '../controlador/ProductoController.php',
                data: {funcion, id, cantidad},
                type: 'POST',
                async: false, 
                success: function(response) {

                    error = error + Number(response);

                }

            });

        });

        return error; 

    } */

    async function Verificar_stock() {

        let productos;

        funcion = 'verificar_stock';

        productos = RecuperarLS();

        const response = await fetch('../controlador/ProductoController.php', {

            method: 'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body: 'funcion=' + funcion + '&&productos=' + JSON.stringify(productos)

        })

        let error = await response.text();

        return error;

    }

    function Registrar_compra(nombre, dni) {

        funcion = 'registrar_compra';

        let total = $('#total').get(0).textContent;

        let productos = RecuperarLS();

        let json = JSON.stringify(productos);

        $.post('../controlador/CompraController.php', {funcion, total, nombre, dni, json}, (response) => {

            /* console.log(response); */

        });

    }
});