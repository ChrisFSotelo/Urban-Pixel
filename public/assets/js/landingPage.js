document.addEventListener("DOMContentLoaded", async () => {
  const contenedor = document.querySelector("#carrusel-productos");

  try {
    const response = await fetch("src/features/productos/controller/ProductoControlador.php?accion=listarPublico");
    const productos = await response.json();

    if(Array.isArray(productos)) {
      // Render original
      productos.forEach(producto => {
        const card = crearTarjetaProducto(producto);
        contenedor.appendChild(card);
      });

      // Clonar para infinito
      productos.forEach(producto => {
        const card = crearTarjetaProducto(producto);
        contenedor.appendChild(card.cloneNode(true)); // duplica exactamente
      });
    }
    else
      contenedor.innerHTML = "<p>No hay productos disponibles.</p>";
  } 
  catch (error) {
    console.error("Error al cargar los productos:", error);
    contenedor.innerHTML = "<p>Ocurrió un error al cargar los productos.</p>";
  }
});

function crearTarjetaProducto(producto) {
  const div = document.createElement("div");
  div.className = "product";
  div.innerHTML = `
    <span class="product__price">$${parseInt(producto.precio).toLocaleString()}</span>
    <img class="product__image" src="https://via.placeholder.com/300x150?text=${encodeURIComponent(producto.nombre)}" alt="${producto.nombre}">
    <h3 class="product__title">${producto.nombre}</h3>
    <hr />
    <p>${producto.descripcion}</p>
    <a href="src/features/productos/views/productoDetalle.php"/${producto.id}" class="product__btn">Ver detalle</a>

  `;
  return div;
}
