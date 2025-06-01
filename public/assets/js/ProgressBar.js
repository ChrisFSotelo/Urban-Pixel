function initProgressBar(formSelector, barraSelector) {
    const form = document.querySelector(formSelector);
    if (!form) return;

    const inputs = form.querySelectorAll("input, select, textarea");
    const barraProgreso = document.querySelector(barraSelector);

    if (!barraProgreso || inputs.length === 0) return;

    function actualizarBarra() {
        let completados = 0;
        inputs.forEach(input => {
            if (input.value.trim() !== "") completados++;
        });

        const porcentaje = (completados / inputs.length) * 100;
        barraProgreso.style.width = `${porcentaje}%`;
    }

    inputs.forEach(input => {
        input.addEventListener("input", actualizarBarra);
    });

    // Actualiza al cargar si hay campos llenos
    actualizarBarra();
}

// Inicializar al cargar la página
document.addEventListener("DOMContentLoaded", () => {
    initProgressBar("#formulario-registro", "#barra-progreso");
});
