<?php if (empty($productos)): ?>
    <li>No se encontraron productos</li>
<?php else: ?>
    <?php foreach ($productos as $producto): ?>
        <li><?= htmlspecialchars($producto->getNombre()) ?> - $<?= htmlspecialchars($producto->getPrecio()) ?></li>
    <?php endforeach; ?>
<?php endif; ?>
