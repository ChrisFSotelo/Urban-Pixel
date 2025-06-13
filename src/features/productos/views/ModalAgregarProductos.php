
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="tituloModalProducto">Agregar Producto</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <form id="formAgregarProducto" autocomplete="off">
          <div class="fields d-flex mb-3 gap-4">
            <input 
              type="hidden" 
              id="id" 
              name="id"
            >

            <input 
              type="text" 
              class="form-control" 
              id="nombre" 
              name="nombre" 
              placeholder="Nombre del producto"
              maxlength="100" 
              required
            >

            <input 
              type="number" 
              class="form-control" 
              id="cantidad" 
              name="cantidad" 
              placeholder="Cantidad"
              min="0"
              required
            >
          </div>

          <div class="fields d-flex mb-3 gap-4">
            <input 
              type="number" 
              class="form-control" 
              id="precio" 
              name="precio" 
              placeholder="Precio"
              min="0"
              step="0.01"
              required
            >

            <select 
              class="form-select" 
              id="idCategoria" 
              name="idCategoria" 
              required
            >
              <option value="">Seleccione categoría</option>
              <!-- Opciones dinámicas -->
            </select>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="submitBtn btn btn-primary" id="submitForm">Guardar</button>
      </div>
    </div>
  </div>


