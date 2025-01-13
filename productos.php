<?php
// Incluir conexión a la base de datos
require_once 'PHP/conexion.php';

// Directorio donde están almacenadas las imágenes
$directorioImagenes = "IMG/productos/";

// Función para normalizar nombres de archivos
function normalizarNombreArchivo($nombre) {
    $nombre = strtolower($nombre);
    $nombre = preg_replace('/[^a-z0-9]+/', '_', $nombre);
    $nombre = trim($nombre, '_');
    return $nombre;
}

// Obtener parámetros de búsqueda y orden
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';
$orden = isset($_GET['orden']) ? $_GET['orden'] : 'asc';
$ordenSQL = ($orden === 'desc') ? 'DESC' : 'ASC';

// Consulta con búsqueda y ordenamiento
$sql = "SELECT id, nombre, descripcion, precio 
        FROM productos 
        WHERE nombre LIKE ? OR descripcion LIKE ? 
        ORDER BY precio $ordenSQL";

$stmt = $conn->prepare($sql);
$param = "%$busqueda%";
$stmt->bind_param("ss", $param, $param);
$stmt->execute();
$result = $stmt->get_result();

// Generar resultados dinámicos para AJAX
if (isset($_GET['ajax'])) {
    $productos = [];
    while ($row = $result->fetch_assoc()) {
        $nombreNormalizado = normalizarNombreArchivo($row['nombre']);
        $imagenPath = file_exists($directorioImagenes . $nombreNormalizado . ".jpg")
            ? $directorioImagenes . $nombreNormalizado . ".jpg"
            : $directorioImagenes . "default.jpg";
        $productos[] = [
            'id' => $row['id'],
            'nombre' => $row['nombre'],
            'descripcion' => $row['descripcion'],
            'precio' => number_format($row['precio'], 0, ',', '.'),
            'imagen' => $imagenPath,
        ];
    }
    echo json_encode($productos);
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Red Metro</title>
    <link rel="stylesheet" href="CSS/index.css">
    <link rel="stylesheet" href="CSS/productos.css">
</head>
<body>
    <!-- Navegación -->
    <nav class="navbar">
        <div class="logo-container">
            <img src="IMG/logo.png" alt="Company Logo" class="logo">
        </div>
        <div class="nav-container">
            <ul class="nav-links">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="#">Nosotros</a></li>
                <li><a href="productos.php">Catálogo</a></li>
                <li><a href="#">Ofertas</a></li>
                <li><a href="#">Contacto</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="PHP/dashboard.php">Mi Perfil</a></li>
                <?php else: ?>
                    <li><a href="login.html">Iniciar Sesión</a></li>
                    <li><a href="registro.html">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="main-content">
        <h1>Nuestros Productos</h1>
        
        <!-- Formulario de búsqueda y orden -->
        <div class="formulario-busqueda">
            <input type="text" id="busqueda" placeholder="Buscar productos..." value="">
            <select id="orden">
                <option value="asc">Precio: Menor a Mayor</option>
                <option value="desc">Precio: Mayor a Menor</option>
            </select>
        </div>

        <div class="productos-container" id="productos-container">
            <!-- Resultados cargados dinámicamente -->
        </div>
    </div>

    <script>
        // Script para el header transparente
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        const busquedaInput = document.getElementById('busqueda');
        const ordenSelect = document.getElementById('orden');
        const productosContainer = document.getElementById('productos-container');

        function cargarProductos() {
            const busqueda = busquedaInput.value;
            const orden = ordenSelect.value;

            fetch(`productos.php?ajax=1&busqueda=${encodeURIComponent(busqueda)}&orden=${orden}`)
                .then(response => response.json())
                .then(data => {
                    productosContainer.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(producto => {
                            productosContainer.innerHTML += `
                                <div class="producto" onclick="window.location.href='detalle-producto.php?id=${producto.id}'">
                                    <h3>${producto.nombre}</h3>
                                    <div class="imagen-container">
                                        <img src="${producto.imagen}" alt="${producto.nombre}">
                                    </div>
                                    <p class="precio">$${producto.precio}</p>
                                </div>
                            `;
                        });
                    } else {
                        productosContainer.innerHTML = '<p>No se encontraron productos.</p>';
                    }
                })
                .catch(error => console.error('Error al cargar los productos:', error));
        }

        busquedaInput.addEventListener('input', () => {
            clearTimeout(busquedaInput.timer);
            busquedaInput.timer = setTimeout(cargarProductos, 300);
        });

        ordenSelect.addEventListener('change', cargarProductos);

        cargarProductos();
    </script>
</body>
</html>