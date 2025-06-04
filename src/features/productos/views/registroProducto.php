<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="public/assets/css/formulario_producto.css" />
</head>
<body>
    <div class="formulario-producto">
          <h2>Agregar Producto</h2>
          <form action="../../controller/ProductoControlador.php?accion=agregar" method="POST">
            <div class="form-group">
            <label for="nombre">Nombre del producto</label>
             <input type="text" id="nombre" name="nombre" required>
    </div>
      <div class="form-group">
      <label for="cantidad">Cantidad</label>
      <input type="number" id="cantidad" name="cantidad" required>
    </div>

    <div class="form-group">
      <label for="precio">Precio</label>
      <input type="number" id="precio" name="precio" required>
    </div>
    
    <div class="form-group">
      <label for="categoria">Categoría</label>
      <select id="categoria" name="categoria_id" required>
        <option value="">Seleccione una categoría</option>
        
      </select>
    </div>

    <div class="form-group">
      <label for="administrador">Administrador</label>
      <select id="administrador" name="administrador_id" required>
        <option value="">Seleccione un administrador</option>
        <
      </select>
    </div>
    <button type="submit">Agregar Producto</button>
</form>
</div>
</body>
</html>