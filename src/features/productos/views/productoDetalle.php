<?php
include("../../../../components/navBar.php")
?>
<?php
// Obtener el ID desde la URL
if (!isset($_GET['id'])) {
    echo "ID del producto no proporcionado.";
    exit;
}
$id = intval($_GET['id']);
?>

<link rel="stylesheet" href="../../../../public/assets/css/products_styles.css" />
<link rel="stylesheet" href="../../../../public/assets/css/general_styles.css" />

<style>
    .catalogo {
        padding: 4em 2em;
        background: #f9f9f9;
    }

    .catalogo__titulo {
        text-align: center;
        font-size: 2em;
        margin-bottom: 2em;
        color: #333;
    }

    .catalogo__grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 2em;
        max-width: 1200px;
        margin: auto;
    }

    .catalogo__item {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        transition: transform 0.2s ease;
    }

    .catalogo__item:hover {
        transform: translateY(-5px);
    }

    .catalogo__imagen {
        position: relative;
    }

    .catalogo__imagen img {
        width: 100%;
        height: auto;
        display: block;
    }

    .catalogo__etiqueta {
        position: absolute;
        bottom: 10px;
        left: 10px;
        background: #111;
        color: white;
        font-size: 0.75em;
        padding: 0.3em 0.6em;
        border-radius: 5px;
        text-transform: uppercase;
    }

    .catalogo__info {
        padding: 1em;
        display: flex;
        flex-direction: column;
        gap: 0.5em;
    }

    .catalogo__info h3 {
        font-size: 1.1em;
        margin: 0;
        color: #222;
    }

    .catalogo__info p {
        font-size: 0.9em;
        color: #666;
        margin: 0;
    }

    .catalogo__precio {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1em;
    }

    .catalogo__precio span {
        font-weight: bold;
        color: #000;
        font-size: 1em;
    }

    .catalogo__btn {
        background: #4ddb34;
        border: none;
        border-radius: 50%;
        padding: 0.5em;
        color: white;
        cursor: pointer;
        font-size: 1.2em;
        transition: background 0.3s ease;
    }

    .catalogo__btn:hover {
        background: #e32b2c;
    }

    //
    .detalle-cantidad {
        margin: 1.5em 0;
        font-size: 0.9em;
        color: #444;
    }

    .detalle-cantidad label {
        font-weight: 600;
        margin-right: 0.5em;
    }

    .detalle-cantidad__controls {
        display: inline-flex;
        align-items: center;
        gap: 0.5em;
        margin-top: 0.5em;
    }

    .detalle-cantidad__controls button {
        background: #ddd;
        border: none;
        padding: 0.5em 0.8em;
        font-size: 1em;
        cursor: pointer;
        border-radius: 5px;
        font-weight: bold;
        transition: background 0.3s ease;
    }

    .detalle-cantidad__controls button:hover {
        background: #ccc;
    }

    .detalle-cantidad__controls input {
        width: 50px;
        text-align: center;
        border: 1px solid #ccc;
        padding: 0.4em;
        border-radius: 5px;
        background: #f9f9f9;
        font-weight: bold;
    }

</style>

<main>
    <div class="producto-detalle-container">
        <section class="detalle-product">
            <div class="detalle-product__photo">
                <div class="detalle-photo-container">
                    <div class="detalle-photo-main">
                        <img id="producto-imagen" src="" alt="producto">
                    </div>
                    <div class="detalle-photo-album">
                        <ul>
                            <li><img src="https://placehold.co/100x100" alt="1"></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="detalle-product__info">
                <div class="detalle-title">
                    <h1 id="producto-nombre">Cargando...</h1>
                    <span id="producto-id">CODIGO DEL PRODUCTO: --</span>
                </div>
                <div class="detalle-price">$ <span id="producto-precio">--</span></div>

                <div class="detalle-description">
                    <p id="producto-descripcion">...</p>
                </div>
                <div class="detalle-cantidad">
                    <label for="cantidad">Cantidad:</label>
                    <div class="detalle-cantidad__controls">
                        <button type="button" onclick="cambiarCantidad(-1)">-</button>
                        <input type="number" id="cantidad" name="cantidad" value="1" min="1" readonly />
                        <button type="button" onclick="cambiarCantidad(1)">+</button>
                    </div>
                </div>
                <button class="product__btn">AGREGAR AL CARRITO</button>
            </div>
        </section>
    </div>
    <section class="catalogo">
        <h2 class="catalogo__titulo">Catálogo de Productos</h2>
        <div id="catalogo-productos" class="catalogo__grid"></div>
    </section>

</main>
<?php
include("../../../../components/carrito.php")
?>
<?php
include("../../../../components/footer.php")
?>

<script>
    document.addEventListener("DOMContentLoaded", async () => {
        const id = <?= $id ?>;

        // === 1. Cargar detalle del producto ===
        try {
            const res = await fetch(`../../../features/productos/controller/ProductoControlador.php?accion=obtenerPorId&id=${id}`);
            const data = await res.json();

            if (data.error) {
                alert(data.error);
                return;
            }

            // Asignar datos al HTML
            document.getElementById("producto-nombre").textContent = data.nombre;
            document.getElementById("producto-id").textContent = `CODIGO DEL PRODUCTO: ${data.id}`;
            document.getElementById("producto-precio").textContent = parseFloat(data.precio).toLocaleString("es-CO", { minimumFractionDigits: 0 });
            document.getElementById("producto-descripcion").textContent = data.descripcion;

            const imgURL = `https://placehold.co/300x150?text=${encodeURIComponent(data.nombre)}`;
            document.getElementById("producto-imagen").src = imgURL;
            document.getElementById("producto-imagen").alt = data.nombre;

            // Agregar al carrito
            document.querySelector(".detalle-buy--btn").addEventListener("click", () => {
                const nombre = data.nombre;
                const precio = parseInt(data.precio);
                const cantidad = parseInt(document.getElementById("cantidad").value);

                const producto = {
                    idProducto: data.id,
                    nombre,
                    precio,
                    cantidad
                };

                agregarAlCarrito(producto);
            });
          } catch (err) {
            console.error("Error al cargar el producto:", err);
            alert("No se pudo cargar la información del producto.");
        }

        // === 2. Cargar productos para el catálogo ===
        try {
            const contenedor = document.querySelector("#catalogo-productos");
            const response = await fetch("../../productos/controller/ProductoControlador.php?accion=listarPublico");
            const productos = await response.json();

            if (Array.isArray(productos)) {
                productos.forEach(producto => {
                    const card = crearTarjetaProducto(producto);
                    contenedor.appendChild(card);
                });
            } else {
                contenedor.innerHTML = "<p>No hay productos disponibles.</p>";
            }
        } catch (error) {
            console.error("Error al cargar los productos:", error);
            document.querySelector("#catalogo-productos").innerHTML = "<p>Ocurrió un error al cargar los productos.</p>";
        }

        // === 3. Crear y mostrar el carrito ===
        const carritoSidebar = document.createElement("div");
        carritoSidebar.id = "carrito-sidebar";
        carritoSidebar.className = "position-fixed top-0 end-0 bg-white shadow p-3 border h-100 overflow-auto";
        carritoSidebar.style.width = "350px";
        carritoSidebar.style.display = "none";
        carritoSidebar.style.zIndex = "9999";
        carritoSidebar.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5>🛒 Tu carrito</h5>
                <button class="btn btn-sm btn-outline-secondary" onclick="toggleCarrito()">✕</button>
            </div>
            <div id="carrito-items"></div>
            <hr>
            <button id="finalizar-compra" class="btn btn-success w-100 mt-2">Finalizar compra</button>
        `;
        document.body.appendChild(carritoSidebar);

        document.getElementById("abrir-carrito")?.addEventListener("click", toggleCarrito);

        if (getCarrito().length > 0) {
            renderizarCarrito();
            mostrarCarrito();
        }

        // === 4. Finalizar compra ===
        document.getElementById("finalizar-compra").addEventListener("click", async () => {
            const carrito = getCarrito();
            if (carrito.length === 0) {
                alert("Tu carrito está vacío.");
                return;
            }

            const idCliente = 1; // reemplaza por sesión real si aplica
            const ciudad = "Bogotá";
            const direccion = "KR 9";

            const formData = new FormData();
            formData.append("idCliente", idCliente);
            formData.append("ciudad", ciudad);
            formData.append("direccion", direccion);
            carrito.forEach(item => {
                formData.append("idsProductos[]", item.idProducto);
                formData.append("cantidades[]", item.cantidad);
            });

            try {
                const response = await fetch(
                    "../../../features/factura/controller/FacturaControlador.php?accion=agregar",
                    {
                        method: "POST",
                        body: formData
                    }
                );

                const data = await response.json();

                if (data.error) {
                    alert("❌ Error: " + data.error);
                } else {
                    alert("✅ Compra finalizada. Factura #" + data.factura.id);
                    localStorage.removeItem("carrito");
                    renderizarCarrito();
                    toggleCarrito();
                }
            } catch (err) {
                console.error(err);
                alert("❌ Ocurrió un error al procesar la compra.");
            }
        });
    });

    // === Funciones auxiliares ===
    function crearTarjetaProducto(producto) {
        const div = document.createElement("div");
        div.className = "catalogo__item";
        div.innerHTML = `
            <div class="catalogo__imagen">
                <img src="https://placehold.co/300x400?text=${encodeURIComponent(producto.nombre)}" alt="${producto.nombre}">
                <span class="catalogo__etiqueta">General</span>
            </div>
            <div class="catalogo__info">
                <h3>${producto.nombre}</h3>
                <p>${producto.descripcion}</p>
                <div class="catalogo__precio">
                    <span>$${parseInt(producto.precio).toLocaleString("es-CO")}</span>
                    <a class="catalogo__btn" href="../views/productoDetalle.php?id=${producto.id}">
                        <i class="material-icons">add_shopping_cart</i>
                    </a>
                </div>
            </div>
        `;
        return div;
    }

    function cambiarCantidad(valor) {
        const input = document.getElementById("cantidad");
        let nuevaCantidad = parseInt(input.value) + valor;
        if (nuevaCantidad < 1) nuevaCantidad = 1;
        input.value = nuevaCantidad;
    }

    function getCarrito() {
        return JSON.parse(localStorage.getItem("carrito")) || [];
    }

    function guardarCarrito(carrito) {
        localStorage.setItem("carrito", JSON.stringify(carrito));
    }

    function agregarAlCarrito(producto) {
        const carrito = getCarrito();
        const index = carrito.findIndex(p => p.idProducto == producto.idProducto);
        if (index >= 0) {
            carrito[index].cantidad += producto.cantidad;
        } else {
            carrito.push(producto);
        }
        guardarCarrito(carrito);
        renderizarCarrito();
        mostrarCarrito();
    }

    function eliminarDelCarrito(idProducto) {
        const nuevoCarrito = getCarrito().filter(p => p.idProducto != idProducto);
        guardarCarrito(nuevoCarrito);
        renderizarCarrito();
    }

    function renderizarCarrito() {
        const items = getCarrito();
        const contenedor = document.getElementById("carrito-items");
        contenedor.innerHTML = "";

        if (items.length === 0) {
            contenedor.innerHTML = "<p>No hay productos en el carrito.</p>";
            return;
        }

        items.forEach(item => {
            const div = document.createElement("div");
            div.className = "d-flex justify-content-between align-items-center mb-2";
            div.innerHTML = `
                <div>
                    <strong>${item.nombre}</strong><br>
                    $${item.precio.toLocaleString()} x ${item.cantidad}
                </div>
                <button class="btn btn-sm btn-outline-danger" onclick="eliminarDelCarrito(${item.idProducto})">✕</button>
            `;
            contenedor.appendChild(div);
        });
    }

    function mostrarCarrito() {
        document.getElementById("carrito-sidebar").style.display = "block";
    }

    function toggleCarrito() {
        const el = document.getElementById("carrito-sidebar");
        el.style.display = el.style.display === "none" ? "block" : "none";
    }
</script>

