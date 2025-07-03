<div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content" id="recibo-compra">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="tituloModalDetalleVenta">Detalles de la compra</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body" >
            <input type="hidden" id="idCompra" name="idCompra" >
            <div class="venta-info">
                <p><strong>Cliente:</strong> <span id="clienteVenta"></span></p>
                <p><strong>Ciudad:</strong> <span id="ciudadVenta"></span></p>
                <p><strong>Dirección:</strong> <span id="direccionVenta"></span></p>
                <p><strong>Fecha y Hora:</strong> <span id="fechaVenta"></span></p>
                <p><strong>Estado:</strong> <span id="estadoVenta" class="estado-tag en-espera"></span></p>
            </div>

            <table class="venta-productos table table-striped mt-3">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody id="productosVenta">
                </tbody>
            </table>

            <div class="venta-resumen mt-3">
                <p><strong>Subtotal:</strong> <span id="subtotalVenta"></span></p>
                <p><strong id="ivaVentaPorcentaje">IVA (): </strong> <span id="ivaVenta"></span></p>
                <p><strong>Total:</strong> <span id="totalVenta"></span></p>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" id="imprimir-recibo-compra" onclick="imprimirReciboCompra()">Imprimir</button>
        </div>
    </div>
</div>