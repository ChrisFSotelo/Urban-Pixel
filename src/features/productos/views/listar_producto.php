<h1>Listado de Productos</h1>

<?php if (empty($productos)): ?>
    <p>No hay productos disponibles.</p>
<?php else: ?>
    <ul>
        <?php foreach ($productos as $producto): ?>
            <li>
                <?= $producto->getNombre() ?> - 
                $<?= $producto->getPrecio() ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
