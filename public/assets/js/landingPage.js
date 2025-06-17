 document.addEventListener("DOMContentLoaded", function () {
    const contenedor = document.querySelector(".products");

    fetch("http://localhost/Urban-Pixel/src/features/productos/controller/ProductoControlador.php?accion=listarPublico") // Ajusta la ruta
    .then(response => response.json())
    .then(productos => {
    if (Array.isArray(productos)) {
    productos.forEach(producto => {
    const template = `
            <div class="product">
              <span class="product__price">$${parseInt(producto.precio).toLocaleString()}</span>
              <img class="product__image" src="https://via.placeholder.com/300x150?text=${encodeURIComponent(producto.nombre)}" alt="${producto.nombre}">
              <h1 class="product__title">${producto.nombre}</h1>
              <hr />
              <p>Este producto es ideal para ti. ¡No te lo pierdas!</p>
              <a href="#" class="product__btn btn">Buy Now</a>
            </div>
          `;
    contenedor.insertAdjacentHTML("beforeend", template);
});
} else {
    contenedor.innerHTML = "<p>No hay productos disponibles.</p>";
}
})
    .catch(error => {
    console.error("Error al cargar los productos:", error);
    contenedor.innerHTML = "<p>Ocurrió un error al cargar los productos.</p>";
});
});

