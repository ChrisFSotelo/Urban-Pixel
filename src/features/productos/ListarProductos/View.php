<h1>Listado de Productos</h1>

<input type="text" id="busqueda" placeholder="Buscar producto...">
<ul id="lista-productos">
    <!-- Aquí se cargará el contenido con JS, incluso al cargar la vista -->
</ul>

<script>
    function cargarProductos(query = '') {
        fetch(`ProductController.php?a=buscar&query=${encodeURIComponent(query)}`)
            .then(res => res.text())
            .then(html => {
                document.getElementById('lista-productos').innerHTML = html;
            });
    }

    document.getElementById('busqueda').addEventListener('input', function() {
        cargarProductos(this.value);
    });

    // Cargar todos los productos al inicio
    document.addEventListener('DOMContentLoaded', () => {
        cargarProductos();
    });
</script>