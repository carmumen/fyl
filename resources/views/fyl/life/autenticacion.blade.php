<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio de Sesión</title>
  <link rel="icon" href="{{ asset('images/focus5.png') }}" type="image/x-icon">
  <!-- CSS de Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <style>
    .teclado {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    .fila {
        display: flex;
        justify-content: center;
    }
    
    .numero {
        width: 50px;
        height: 50px;
        margin: 5px;
        font-size: 20px;
        border-radius: 50%; /* Hace que los botones sean redondos */
        background-color: #add8e6; /* Establece el tono azul pastel */
        border: none; /* Elimina el borde */
        outline: none; /* Elimina el contorno al hacer clic */
    }
    
    .codigo {
        position: relative; /* Para establecer la posición de los guiones bajos */
        font-family: monospace;
        font-size: 2.3rem;
        width: 160px;
        padding: 0px;
        background-color: transparent; /* Fondo transparente */
        text-align: center; /* Centrar el texto horizontalmente */
        outline: none; /* Quita el contorno al estar enfocado */
        border: none; /* Quita el borde */
        border-bottom: 1px solid #ccc; /* Agrega el borde inferior */
        letter-spacing: .2rem;
    }

    
    .numero:hover {
        background-color: #87ceeb; /* Cambia el color de fondo al pasar el ratón sobre los botones */
    }
    
    #borrar {
        width: 106px; /* Ancho del botón "Borrar" */
        border-radius: 25px;
    }

  </style>
  
  
</head>
<body>

<div class="container">
  <div class="row justify-content-center mt-5">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <img width="30px" class="mr-2" style="margin-rigth:10px" src="{{ url('images/fyl.png') }}" alt="Focus Your Life"/> 
            <span class="flex-grow-1 m-2">Ingresa el Código enviado a tu correo</span>
        </div>
        <div class="card-body">
        <form id="formValidar" action="{{ route('life.validacion') }}" method="POST">
            @csrf
            <div class="teclado" style="margin-bottom: 5px">
                <input type="hidden" id="clave" name="clave" value="{{ $clave }}">
                
                <input type="text" class="codigo" id="codigo" name="codigo" maxlength="6" readonly>
            </div>
        </form>
        <div class="teclado">
            <div class="fila">
                <button class="numero">1</button>
                <button class="numero">2</button>
                <button class="numero">3</button>
            </div>
            <div class="fila">
                <button class="numero">4</button>
                <button class="numero">5</button>
                <button class="numero">6</button>
            </div>
            <div class="fila">
                <button class="numero">7</button>
                <button class="numero">8</button>
                <button class="numero">9</button>
            </div>
            <div class="fila">
                <button class="numero">0</button>
                <button id="borrar" class="numero borde-doble">Borrar</button>
            </div>
        </div>
        <button type="submit" form="formValidar" class="btn btn-primary">Enviar</button>
    
        </div>
      </div>
    </div>
  </div>
</div>




<script>
    
// Función para asignar el número del botón al campo de entrada de texto
document.querySelectorAll('.numero').forEach(button => {
    button.addEventListener('click', () => {
        if (button.id === "borrar") {
            borrarUltimoNumero();
        } else {
            if(document.getElementById('codigo').value.length  < 6)
                document.getElementById('codigo').value += button.textContent;
        }
    });
});

// Función para borrar el último número ingresado
function borrarUltimoNumero() {
    const valorActual = document.getElementById('codigo').value;
    if (valorActual.length > 0) {
        document.getElementById('codigo').value = valorActual.slice(0, -1);
    }
}

// Función para cambiar el texto de los botones
window.addEventListener('load', () => {
    const botonesNumeros = Array.from(document.querySelectorAll('.numero:not(#borrar)'));
    const numerosAleatorios = Array.from({length: 10}, (_, i) => i); // Array con números del 0 al 9
    shuffleArray(numerosAleatorios); // Aleatorizamos los números

    botonesNumeros.forEach((button, index) => {
        button.textContent = numerosAleatorios[index];
    });
});

// Función para aleatorizar un array (algoritmo de Fisher-Yates)
function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
}


// Función para aleatorizar un array (algoritmo de Fisher-Yates)
function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
}
</script>

<!-- JavaScript de Bootstrap (opcional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

</body>
</html>

