let preguntaActual = 1;
const totalPreguntas = 5;
let puntajeTotal = 0; // <- Añadido para acumular puntaje

document.querySelectorAll('.age-option').forEach(option => {
  option.addEventListener('click', () => {
    document.querySelectorAll('.age-option').forEach(opt => {
      opt.classList.remove('active');
      const btn = opt.querySelector('button');
      if (btn) btn.classList.remove('selected');
    });

    option.classList.add('active');
    const selectedBtn = option.querySelector('button');
    if (selectedBtn) selectedBtn.classList.add('selected');

    const startBtn = document.getElementById('startBtn');
    startBtn.disabled = false;
    startBtn.classList.add('active');
  });
});

document.getElementById('startBtn').addEventListener('click', () => {
  document.getElementById('pantallaEdad').classList.add('hidden');
  document.getElementById('contenedor-preguntas').classList.remove('hidden');

  // Cambiar el fondo del contenedor principal
  const contenedorPrincipal = document.querySelector('.back-text');
  contenedorPrincipal.classList.add('fondo-preguntas');

  cargarPregunta(preguntaActual);
  actualizarBarraProgreso(preguntaActual);
});

function cargarPregunta(numero) {
  fetch(`pregunta${numero}.html`)
    .then(res => {
      if (!res.ok) throw new Error('No se pudo cargar la pregunta');
      return res.text();
    })
    .then(html => {
      document.getElementById('contenedor-preguntas').innerHTML = html;
      setTimeout(() => {
        activarRespuestas();
        habilitarClickEnPasos();
        actualizarBarraProgreso(preguntaActual);
      }, 50);
    })
    .catch(err => console.error(err));
}

function avanzarPregunta() {
  marcarPasoComoCompletado(preguntaActual);

  const seleccionada = document.querySelector('.answer.selected');
  if (seleccionada) {
    const valor = parseInt(seleccionada.getAttribute('data-value')) || 0;
    puntajeTotal += valor;
  }

  preguntaActual++;
  if (preguntaActual <= totalPreguntas) {
    cargarPregunta(preguntaActual);
  } else {
    localStorage.setItem('puntajeFinal', puntajeTotal.toString());
    window.location.href = 'resultado.html';
  }
}

function actualizarBarraProgreso(preguntaActual) {
  const pasos = document.querySelectorAll('.step');

  pasos.forEach((paso, index) => {
    paso.classList.remove('active', 'completed');
    paso.innerHTML = '';

    if (index < preguntaActual - 1) {
      paso.classList.add('completed');
      paso.innerHTML = '<i class="fa-solid fa-check"></i>';
    } else if (index === preguntaActual - 1) {
      paso.classList.add('active');
    }
  });
}

function marcarPasoComoCompletado(numero) {
  const paso = document.querySelector(`.step[data-step="${numero}"]`);
  if (paso) paso.classList.add('completed');
}

function habilitarClickEnPasos() {
  const pasos = document.querySelectorAll('.step');
  pasos.forEach(paso => {
    paso.addEventListener('click', () => {
      const stepNum = parseInt(paso.dataset.step);
      if (stepNum < preguntaActual) {
        preguntaActual = stepNum;
        cargarPregunta(preguntaActual);
        actualizarBarraProgreso(preguntaActual);
      }
    });
  });
}

const botonesMovil = document.querySelectorAll('.edad-card .movil');
const startBtn = document.getElementById('startBtn');

botonesMovil.forEach((btn) => {
  btn.addEventListener('click', function () {
    if (window.innerWidth <= 575.98) {
      const card = this.closest('.edad-card');
      iniciarTestDesdeEdad(card);
    }
  });
});


const slider = document.getElementById('edadSlider');
const bullets = document.querySelectorAll('#bullets span');

if (slider) {
  slider.addEventListener('scroll', () => {
    const slideWidth = slider.offsetWidth;
    const scrollLeft = slider.scrollLeft;
    const index = Math.round(scrollLeft / slideWidth);

    bullets.forEach((b, i) => {
      b.classList.toggle('active', i === index);
    });
  });
}

function activarRespuestas() {
  const respuestas = document.querySelectorAll('.answer');
  const btn = document.querySelector('.siguiente-btn');

  if (!btn) return;

  respuestas.forEach(resp => {
    resp.addEventListener('click', () => {
      respuestas.forEach(r => r.classList.remove('selected'));
      resp.classList.add('selected');

      btn.disabled = false;
      btn.style.opacity = '1';

      const valor = parseInt(resp.getAttribute('data-value')) || 0;

      // Esperar 800ms antes de avanzar a la siguiente pregunta
      setTimeout(() => {
        avanzarPregunta(); // usa la lógica ya controlada
      }, 800);
    });
  });

  // Botón para retroceder
  btn.addEventListener('click', () => {
    if (preguntaActual > 1) {
      preguntaActual--;
      cargarPregunta(preguntaActual);
    }
  });
}

function iniciarTestDesdeEdad(card) {
  // Marcar tarjeta seleccionada con efecto visual
  document.querySelectorAll('.edad-card').forEach(c => c.classList.remove('selected'));
  card.classList.add('selected');

  // Espera para mostrar efecto antes de avanzar (300ms = 0.3 segundos)
  setTimeout(() => {
    // Ocultar selección de edad y botón
    document.getElementById('pantallaEdad').classList.add('hidden');

    // Mostrar contenedor de preguntas
    document.getElementById('contenedor-preguntas').classList.remove('hidden');

    // Cambiar fondo
    document.querySelector('.back-text')?.classList.add('fondo-preguntas');

    // Reiniciar pregunta actual y puntaje
    preguntaActual = 1;
    puntajeTotal = 0;

    cargarPregunta(preguntaActual);
    actualizarBarraProgreso(preguntaActual);
  }, 500); // Puedes ajustar a 500 o más si quieres que dure más
}

