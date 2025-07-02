<div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="adminModalLabel">Agregar Administrador</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <form name="formulario" id="formulario" autocomplete="off">
                <div class="fields d-flex mb-3 gap-4">
                    <input 
                        type="hidden" 
                        id="id" 
                        name="id"
                    >

                    <input 
                        type="text" 
                        class="form-control" 
                        id="nombre-registro" 
                        name="nombre" 
                        placeholder="Nombre"
                        maxlength="30" 
                        required
                    >
                    <input 
                        type="text" 
                        class="form-control" 
                        id="apellido-registro" 
                        name="apellido" 
                        placeholder="Apellido"
                        maxlength="30" 
                        required
                    >
                </div>

                <div class="fields d-flex mb-3 gap-4">
                    <input 
                        type="email" 
                        class="form-control" 
                        id="correo-registro" 
                        name="correo" 
                        placeholder="Correo"
                        maxlength="50" 
                        required
                    >
                    <input 
                        type="password" 
                        class="form-control" 
                        id="clave-registro" 
                        name="clave" 
                        placeholder="Contraseña" 
                        maxlength="25"
                        required
                    >
                </div>
            </form>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="submitBtn btn btn-primary" id="submitForm">Guardar</button>
        </div>
    </div>
</div>