<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Menú Horizontal y Vertical Responsivo</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" >
<style>
    /* Estilo para el menú horizontal */
    .menu-horizontal {
        display: flex;
        list-style-type: none;
    }
    .menu-horizontal li {
        margin-right: 20px;
    }

    /* Estilo para el menú vertical */
    .menu-vertical {
        display: none;
    }
    .menu-vertical.show {
        display: block;
    }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Mi Sitio</a>
        <!-- Botón hamburguesa -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Menú horizontal -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 menu-horizontal">
                <li class="nav-item">
                    <a class="nav-link" href="#">Mi Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Mi Entrenamiento</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Enrolamiento</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Actividades</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Asignaciones</a>
                </li>
            </ul>
            <!-- Menú vertical (oculto inicialmente) -->
            <ul class="navbar-nav mb-2 mb-lg-0 menu-vertical" id="menuVertical">
                <li class="nav-item">
                    <a class="nav-link" href="#">Mi Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Mi Entrenamiento</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Enrolamiento</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Actividades</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Asignaciones</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

hola

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" ></script>
<script>
   $(document).ready(function(){
    // Al hacer clic en el botón hamburguesa, alternar la visibilidad y posición del menú vertical
    $('.navbar-toggler').click(function(){
        $('#menuVertical').toggleClass('show');
        if ($('#menuVertical').hasClass('show')) {
            $('#menuVertical').css('left', '0'); // Si se muestra el menú, ajusta su posición a la izquierda
        } else {
            $('#menuVertical').css('left', '-80%'); // Si se oculta el menú, ajusta su posición fuera de la pantalla
        }
    });
});

</script>

</body>
</html>
