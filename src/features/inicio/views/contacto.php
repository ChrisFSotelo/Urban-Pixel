<link rel="stylesheet" href="../../../../public/assets/css/nosotrosYContacto.css">

<section class="contacto-section">
    <div class="contacto-container">
        <h2>Contáctanos</h2>
        <p>¿Tienes dudas, sugerencias o necesitas soporte? Completa el siguiente formulario y nos pondremos en contacto contigo lo antes posible.</p>

        <form class="contacto-form" method="POST" autocomplete="off">
            <input type="text" name="nombre" placeholder="Tu nombre completo" required>
            <input type="email" name="email" placeholder="Tu correo electrónico" required>
            <input type="text" name="asunto" placeholder="Asunto" required>
            <textarea name="mensaje" placeholder="Escribe tu mensaje aquí..." rows="6" required></textarea>
            <button type="button">Enviar mensaje</button>
        </form>

        <div class="info-contacto-extra">
            <div>
                <i class="fas fa-map-marker-alt"></i>
                <p>Calle 123 #45-67, Bogotá, Colombia</p>
            </div>
            <div>
                <i class="fas fa-phone"></i>
                <p>+57 300 000 0000</p>
            </div>
            <div>
                <i class="fas fa-envelope"></i>
                <p>pixel.tornado.pt@gmail.com</p>
            </div>
            <div>
                <i class="fas fa-clock"></i>
                <p>Lunes a Viernes: 8:00 am - 6:00 pm</p>
            </div>
        </div>

        <div class="mapa">
            <iframe
                src="https://maps.google.com/maps?q=Bogotá%20Colombia&t=&z=13&ie=UTF8&iwloc=&output=embed"
                width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen="" loading="lazy">
            </iframe>
        </div>
    </div>
</section>