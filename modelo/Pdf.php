<?php 

include_once "Venta.php";

include_once "VentaProducto.php";

function getHTML($id_venta) {

    $venta = new Venta();

    $venta_producto = new VentaProducto();

    $venta -> buscar_id($id_venta);

    $venta_producto -> ver($id_venta);

    $plantilla = '
        <body>
            <header class="clearfix">
                <div id="logo">
                    <img src="../img/logo.png" width="60" height="60">
                </div>
                <h1>COMPROBANTE DE PAGO</h1>
                <div id="company" class="clearfix">
                    <div id="negocio">Farmacia LokyWeb</div>
                    <div>Dirección Número 2342, <br /> La Paz, Miraflores</div>
                    <div>+591 69904553</div>
                    <div><a href="mailto:lokyweb@gmail.com">lokyweb@gmail.com</a></div>
                </div>';

                foreach ($venta -> objetos as $objeto) {

                    $plantilla .= '
                    
                    <div id="project">
                        <div><span>Código de Venta: </span>' . $objeto->id_venta . '</div>
                        <div><span>Cliente: </span>' . $objeto->cliente . '</div>
                        <div><span>DNI: </span>' . $objeto->dni . '</div>
                        <div><span>Fecha y Hora: </span>' . $objeto->fecha . '</div>
                        <div><span>Vendedor: </span>' . $objeto->vendedor . '</div>
                    </div>';

                }

            $plantilla .= '
            </header>
            <main>
                <table>
                    <thead>
                        <tr>
                            <th class="service">Producto</th>
                            <th class="service">Concentración</th>
                            <th class="service">Adicional</th>
                            <th class="service">Laboratorio</th>
                            <th class="service">Presentación</th>
                            <th class="service">Tipo</th>
                            <th class="service">Cantidad</th>
                            <th class="service">Precio</th>
                            <th class="service">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>';

                    foreach ($venta_producto -> objetos as $objeto) {

                        $plantilla .= '
                            <tr>
                                <td class="servic">' . $objeto->producto. '</td>    
                                <td class="servic">' . $objeto->concentracion. '</td>    
                                <td class="servic">' . $objeto->adicional. '</td>    
                                <td class="servic">' . $objeto->laboratorio. '</td>    
                                <td class="servic">' . $objeto->presentacion. '</td>    
                                <td class="servic">' . $objeto->tipo. '</td>    
                                <td class="servic">' . $objeto->cantidad. '</td>    
                                <td class="servic">' . $objeto->precio. '</td>    
                                <td class="servic">' . $objeto->subtotal. '</td>    
                            </tr>';
            
                    }

                    $calculos = new Venta();

                    $calculos -> buscar_id($id_venta);

                    foreach ($calculos -> objetos as $objeto) {

                        $igv = $objeto -> total * 0.18;

                        $sub = $objeto -> total - $igv;

                        $plantilla .= '
                        <tr>
                            <td colspan="8" class="grand total">SUBTOTAL</td>
                            <td class="grand total">S/.' . $sub . '</td>
                        </tr>
                        <tr>
                            <td colspan="8" class="grand total">IGV(18%)</td>
                            <td class="grand total">S/.' . $igv . '</td>
                        </tr>
                        <tr>
                            <td colspan="8" class="grand total">TOTAL</td>
                            <td class="grand total">S/.' . $objeto->total . '</td>
                        </tr>';

                    }

                    $plantilla .= '
                    </tbody>
                </table>
                <div id="notices">
                    <div>NOTICE:</div>
                    <div class="notice">*Presentar este comprobante de pago para cualquier reclamo o devolución.</div>
                    <div class="notice">*El reclamo procedera dentro las 24 horas de haber hecho la compra.</div>
                    <div class="notice">*Si el producto esta dañado o abierto, la devolución no procedera.</div>
                    <div class="notice">*Revise su cambio antes de salir del establecimiento.</div>
                </div>
            </main>
            <footer>
                    Creado por (Loky Web) Ingeniero de Sistemas.
            </footer>
        </body>';

    return $plantilla;

}