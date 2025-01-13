<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario está logueado
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Red Metro - Estilo y Comodidad en Cada Paso. Descubre nuestra colección exclusiva de zapatillas.">
    <title>Red Metro</title>
    <link rel="stylesheet" href="CSS/index.css">
</head>
<body>
    <!-- Navegación -->
    <nav class="navbar">
        <div class="logo-container">
            <img src="IMG/logo.png" alt="Company Logo" class="logo">
        </div>
        <div class="nav-container">
            <ul class="nav-links">
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Nosotros</a></li>
                <li><a href="productos.php">Catálogo</a></li>
                <li><a href="#">Ofertas</a></li>
                <li><a href="#">Contacto</a></li>

                <?php if ($isLoggedIn): ?>
                    <!-- Opciones para usuarios logueados -->
                    <li><a href="PHP/dashboard.php">Mi Perfil</a></li>
                <?php else: ?>
                    <!-- Opciones para usuarios no logueados -->
                    <li><a href="login.html">Iniciar Sesión</a></li>
                    <li><a href="registro.html">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero">
        <div class="hero-content">
            <h2>Estilo y Comodidad en Cada Paso</h2>
            <p>Descubre nuestra colección exclusiva de zapatillas</p>
            <button class="cta-button">Ver Catálogo</button>
        </div>
    </header>

    <!-- About Section -->
    <section class="about">
        <div class="about-container">
            <div class="about-content">
                <h2>Sobre Red Metro</h2>
                <p>En Red Metro, nos apasiona ofrecer el mejor calzado deportivo que combine estilo, comodidad y rendimiento. Con años de experiencia en el mercado, nos hemos convertido en el destino preferido para los amantes del deporte y la moda.</p>
                <p>Nuestra misión es simple: proporcionar zapatillas de alta calidad que se adapten a tu estilo de vida activo.</p>
                
                <div class="features">
                    <div class="feature">
                        <span class="feature-icon">🌟</span>
                        <div class="feature-content">
                            <h4>Calidad Premium</h4>
                            <p>Seleccionamos cuidadosamente cada modelo para garantizar la mejor calidad.</p>
                        </div>
                    </div>
                    <div class="feature">
                        <span class="feature-icon">🚚</span>
                        <div class="feature-content">
                            <h4>Envío Rápido</h4>
                            <p>Entrega a todo el país en tiempo récord.</p>
                        </div>
                    </div>
                    <div class="feature">
                        <span class="feature-icon">💯</span>
                        <div class="feature-content">
                            <h4>Garantía Total</h4>
                            <p>30 días de garantía en todos nuestros productos.</p>
                        </div>
                    </div>
                    <div class="feature">
                        <span class="feature-icon">💬</span>
                        <div class="feature-content">
                            <h4>Atención 24/7</h4>
                            <p>Soporte personalizado cuando lo necesites.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="about-image">
                <img src="https://images.unsplash.com/photo-1556906781-9a412961c28c" alt="Nuestra tienda">
            </div>
        </div>
    </section>
    <!-- Productos Destacados -->
<section class="featured-products">
    <div class="container">
        <h2>Productos Destacados</h2>
        <div class="products-grid">
            <div class="product-card">
                <div class="product-badge">Nuevo</div>
                <div class="product-image">
                    <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff" alt="Air Max Supreme">
                    <div class="product-actions">
                        <button class="action-btn">🛒</button>
                        <button class="action-btn">❤️</button>
                    </div>
                </div>
                <div class="product-info">
                    <h3>Air Max Supreme</h3>
                    <div class="product-rating">⭐⭐⭐⭐⭐</div>
                    <p>Zapatillas deportivas con tecnología de última generación</p>
                    <div class="product-price">
                        <span class="price">$129.99</span>
                        <button class="buy-btn">Comprar</button>
                    </div>
                </div>
            </div>

            <div class="product-card">
                <div class="product-badge">Oferta</div>
                <div class="product-image">
                    <img src="https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2" alt="Runner Elite">
                    <div class="product-actions">
                        <button class="action-btn">🛒</button>
                        <button class="action-btn">❤️</button>
                    </div>
                </div>
                <div class="product-info">
                    <h3>Runner Elite</h3>
                    <div class="product-rating">⭐⭐⭐⭐</div>
                    <p>Perfectas para corredores profesionales</p>
                    <div class="product-price">
                        <span class="price">$99.99</span>
                        <button class="buy-btn">Comprar</button>
                    </div>
                </div>
            </div>

            <div class="product-card">
                <div class="product-image">
                    <img src="https://images.unsplash.com/photo-1556906781-9a412961c28c" alt="Urban Style">
                    <div class="product-actions">
                        <button class="action-btn">🛒</button>
                        <button class="action-btn">❤️</button>
                    </div>
                </div>
                <div class="product-info">
                    <h3>Urban Style</h3>
                    <div class="product-rating">⭐⭐⭐⭐</div>
                    <p>Diseño urbano para el día a día</p>
                    <div class="product-price">
                        <span class="price">$89.99</span>
                        <button class="buy-btn">Comprar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories -->
<section class="categories">
    <div class="container">
        <h2>Categorías</h2>
        <div class="categories-grid">
            <div class="category-card">
                <img src="https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a" alt="Running">
                <div class="category-content">
                    <h3>Running</h3>
                    <p>Encuentra tu ritmo perfecto</p>
                    <a href="#" class="category-link">Ver Colección →</a>
                </div>
            </div>

            <div class="category-card">
                <img src="https://images.unsplash.com/photo-1549298916-b41d501d3772" alt="Lifestyle">
                <div class="category-content">
                    <h3>Lifestyle</h3>
                    <p>Estilo para tu día a día</p>
                    <a href="#" class="category-link">Ver Colección →</a>
                </div>
            </div>

            <div class="category-card">
                <img src="https://images.unsplash.com/photo-1579338559194-a162d19bf842" alt="Basketball">
                <div class="category-content">
                    <h3>Basketball</h3>
                    <p>Domina la cancha</p>
                    <a href="#" class="category-link">Ver Colección →</a>
                </div>
            </div>

            <div class="category-card">
                <img src="https://images.unsplash.com/photo-1605348532760-6753d2c43329" alt="Training">
                <div class="category-content">
                    <h3>Training</h3>
                    <p>Supera tus límites</p>
                    <a href="#" class="category-link">Ver Colección →</a>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h5>Red Metro</h5>
                <p>Tu tienda de confianza para el mejor calzado deportivo.</p>
            </div>
            <div class="footer-section">
                <h5>Enlaces Rápidos</h5>
                <ul>
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#">Catálogo</a></li>
                    <li><a href="#">Ofertas</a></li>
                    <li><a href="#">Contacto</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h5>Contacto</h5>
                <ul>
                    <li>Email: info@redmetro.com</li>
                    <li>Teléfono: (123) 456-7890</li>
                    <li>Dirección: Calle Principal 123</li>
                </ul>
            </div>
            <div class="footer-section">
                <h5>Newsletter</h5>
                <p>Suscríbete para recibir nuestras ofertas</p>
                <div class="newsletter">
                    <input type="email" placeholder="Tu email">
                    <button>Suscribir</button>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Red Metro. Todos los derechos reservados.</p>
        </div>
    </footer>
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
    </script>
</body>
</html>