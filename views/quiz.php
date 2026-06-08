<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuestionario de Evaluación</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Pantalla de bloqueo inicial para obligar la pantalla completa */
        .start-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-color: #111827;
            display: flex; justify-content: center; align-items: center;
            z-index: 9999;
            color: white; text-align: center;
        }
        .start-box {
            background-color: #1f2937;
            padding: 3rem; border-radius: 8px; max-width: 500px; width: 90%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        .btn-start-quiz {
            background-color: #10b981; color: white; border: none;
            padding: 1rem 2rem; font-size: 1.2rem; font-weight: bold;
            border-radius: 6px; cursor: pointer; margin-top: 1.5rem;
            transition: background-color 0.2s; width: 100%;
        }
        .btn-start-quiz:hover { background-color: #059669; }

        /* Estilos para la navegación paso a paso */
        .question-step { display: none; }
        .question-step.active { display: block; }
        
        .quiz-navigation-buttons {
            display: flex; justify-content: space-between;
            margin-top: 30px; gap: 15px;
        }
        .btn-nav {
            background-color: #4b5563; color: white; border: none;
            padding: 0.75rem 1.5rem; font-size: 1rem; font-weight: 600;
            border-radius: 6px; cursor: pointer; transition: background-color 0.2s;
        }
        .btn-nav:hover { background-color: #374151; }
        .btn-nav.hidden { visibility: hidden; }

        /* Estilos del modal de advertencia por salida (Fraude) */
        .modal-warning-box {
            background-color: #ffffff; border-radius: 8px; padding: 2rem;
            max-width: 500px; width: 90%; text-align: center;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            border-top: 8px solid #dc2626;
        }
        .modal-warning-box.invalidated {
            border-top: 8px solid #000000;
            background-color: #fef2f2;
        }
        .modal-warning-box h3 { color: #dc2626; font-size: 1.5rem; margin-top: 0; margin-bottom: 1rem; }
        .modal-warning-box p { color: #374151; font-size: 1.05rem; line-height: 1.5; margin-bottom: 1.5rem; }
        
        .btn-warning-understand {
            background-color: #dc2626; color: white; border: none;
            padding: 0.75rem 2rem; font-size: 1rem; font-weight: bold;
            border-radius: 6px; cursor: pointer; width: 100%; transition: background-color 0.2s;
        }
        .btn-warning-understand:hover { background-color: #b91c1c; }
        .fraud-counter-badge {
            background-color: #fee2e2; color: #b91c1c; padding: 4px 10px;
            border-radius: 4px; font-weight: bold; border: 1px solid #fca5a5;
        }
        .countdown-invalidation {
            font-size: 2rem; font-weight: 900; color: #dc2626; margin-top: 10px; display: block;
        }

        /* 🆕 NUEVOS ESTILOS PARA EL MODAL DE VALIDACIÓN DE PREGUNTAS EN BLANCO 🆕 */
        .modal-incomplete-box {
            background-color: #ffffff; border-radius: 8px; padding: 2rem;
            max-width: 550px; width: 90%; text-align: center;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.25);
            border-top: 8px solid #df2020;
        }
        .modal-incomplete-box h3 { color: #df2020; font-size: 1.6rem; margin-top: 0; margin-bottom: 1rem; }
        .modal-incomplete-box p { color: #2d3748; font-size: 1.1rem; line-height: 1.6; margin-bottom: 1.5rem; }
        .badge-pending-list {
            display: inline-block; background-color: #fff5f5; color: #c53030; 
            padding: 10px 15px; border-radius: 6px; font-weight: bold; 
            border: 1px dashed #feb2b2; font-size: 1.2rem; letter-spacing: 1px;
        }
        .btn-incomplete-close {
            background-color: #2d3748; color: white; border: none;
            padding: 0.75rem 2rem; font-size: 1rem; font-weight: bold;
            border-radius: 6px; cursor: pointer; width: 100%; transition: background-color 0.2s;
        }
        .btn-incomplete-close:hover { background-color: #1a202c; }
    </style>
</head>
<body class="quiz-page">

    <div id="startOverlay" class="start-overlay">
        <div class="start-box">
            <h2>¡Bienvenido(a) al Test!</h2>
            <p style="color: #d1d5db; margin-top: 10px;">Aprendiz: <strong><?php echo htmlspecialchars($student_name ?? 'Estudiante', ENT_QUOTES, 'UTF-8'); ?></strong></p>
            <p style="color: #9ca3af; font-size: 0.95rem; margin-top: 15px; line-height: 1.6; text-align: center;">
                Para responder este cuestionario es obligatorio activar el modo de pantalla completa. No intente salir de él hasta finalizar.<br><br>Cada vez que se minimice la pantalla, se cree una nueva pestaña o se intente buscar información en internet... contará como un intento de fraude.<br><br> A los 3 intentos de fraude, el test se cerrará automáticamente y no podrá volver a presentar el Test.<br><br>Los intentos de fraude se almacenan en la Base de Datos y se mostrarán en el reporte final.
            </p>
            <button type="button" id="btnStartQuizAction" class="btn-start-quiz">
                INICIAR TEST
            </button>
        </div>
    </div>

    <div class="timer-banner">
        <div>Aprendiz: <strong><?php echo htmlspecialchars($student_name ?? 'Aprendiz', ENT_QUOTES, 'UTF-8'); ?></strong></div>
        <div>Tiempo restante: <span id="countdown" class="timer-box">00:00:00</span></div>
    </div>

    <div class="quiz-container">
        <h2>Cuestionario de Evaluación</h2>
        <p class="quiz-instruction">Pregunta <span id="current-index-txt">1</span> de <span id="total-questions-txt">20</span></p>
        
        <form id="quizForm" action="index.php?action=quiz" method="POST" onsubmit="return interceptarEnvio(event);">
            
            <input type="hidden" name="intentos_fraude" id="intentosFraudeInput" value="0">

            <?php if (isset($questions) && count($questions) > 0): ?>
                <?php foreach ($questions as $index => $q): ?>
                    
                    <div class="question-block question-step <?php echo $index === 0 ? 'active' : ''; ?>" id="step-<?php echo $index; ?>" style="border-bottom: 1px solid #f3f4f6; padding-bottom: 20px;">
                        <p style="margin-bottom: 12px; font-size: 1.15rem;">
                            <strong>Pregunta <?php echo ($index + 1); ?>:</strong> 
                            <?php echo htmlspecialchars($q['pregunta'], ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                        
                        <?php 
                        $opciones = [$q['opcion_a'], $q['opcion_b'], $q['opcion_c'], $q['opcion_d']];
                        shuffle($opciones); 
                        $letras = ['A', 'B', 'C', 'D'];
                        ?>

                        <?php foreach ($opciones as $i => $opcion_texto): ?>
                            <label style="display: block; margin-bottom: 10px; font-size: 1.05rem; cursor: pointer;">
                                <input type="radio" name="q_<?php echo $q['id']; ?>" value="<?php echo htmlspecialchars($opcion_texto, ENT_QUOTES, 'UTF-8'); ?>" style="margin-right: 8px;"> 
                                <?php echo $letras[$i] . '. ' . htmlspecialchars($opcion_texto, ENT_QUOTES, 'UTF-8'); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>

                <?php endforeach; ?>
            <?php else: ?>
                <p>No se encontraron preguntas registradas en el sistema para esta evaluación.</p>
            <?php endif; ?>

            <div class="quiz-navigation-buttons">
                <button type="button" id="btnPrev" class="btn-nav">&larr; Anterior</button>
                <button type="button" id="btnNext" class="btn-nav">Siguiente &rarr;</button>
                
                <button type="submit" id="btnSubmitQuiz" class="btn-submit-quiz" style="display: none; margin-top: 0; width: auto; padding: 0.75rem 2rem;">
                    Enviar Cuestionario
                </button>
            </div>
        </form>

        <footer style="margin-top: 3rem; text-align: center; color: #6b7280; font-size: 0.85rem; border-top: 1px solid #e5e7eb; padding-top: 1.5rem;">
            Ingeniero Luis Enrique Arias (C) 2026
        </footer>
    </div>

    <div id="confirmModal" class="modal-overlay">
        <div class="modal-box">
            <h3>¿Está seguro(a)?</h3>
            <p>El cuestionario se enviará y no tendrá opción de repetirlo nuevamente.</p>
            <div class="modal-buttons">
                <button type="button" id="btnConfirmSend" class="btn-modal-confirm">SI, ENVIAR</button>
                <button type="button" id="btnCancelSend" class="btn-modal-cancel">No, volver al examen</button>
            </div>
        </div>
    </div>

    <div id="incompleteModal" class="modal-overlay">
        <div class="modal-incomplete-box">
            <h3>❌ NO SE PUEDE ENVIAR EL TEST ❌</h3>
            <p>
                Aún tienes preguntas sin responder en tu hoja de examen.<br>
                Por favor, completa las siguientes preguntas antes de finalizar de forma definitiva:
            </p>
            <p>
                <span class="badge-pending-list">Preguntas pendientes: [ <span id="incompleteQuestionsList"></span> ]</span>
            </p>
            <button type="button" id="btnIncompleteClose" class="btn-incomplete-close">ENTENDIDO, COMPLETAR PREGUNTAS</button>
        </div>
    </div>

    <div id="fraudWarningModal" class="modal-overlay">
        <div class="modal-warning-box" id="warningBoxWrapper">
            <h3 id="warningTitle">WARNING / ADVERTENCIA</h3>
            <p id="warningBody">
                <strong>No puede abrir más ventanas, pestañas del navegador, ni minimizar esta prueba.</strong><br><br>
                Los intentos de fraude serán contados de forma automática en el sistema e invalidarán su prueba de manera definitiva.<br><br>
                <span style="font-size: 0.95rem;">Infracciones registradas en esta sesión:</span><br><br>
                <span class="fraud-counter-badge">Advertencia #<span id="fraud-count-txt">0</span></span>
            </p>
            <button type="button" id="btnUnderstandWarning" class="btn-warning-understand">ENTENDIDO, VOLVER AL EXAMEN</button>
            <span id="invalidationCountdownTxt" class="countdown-invalidation" style="display: none;">10</span>
        </div>
    </div>

    <script>
        let tiempoExpirado = false;
        let formularioConfirmado = false;
        let pruebaInvalidadaPorCompleto = false; 
        let examenIniciado = false; 
        let validadorInternoActivo = false; // Nueva bandera de control para omitir falsos fraudes

        // Variables del Carrusel
        let currentStep = 0;
        const steps = document.querySelectorAll('.question-step');
        const totalSteps = steps.length;

        const btnPrev = document.getElementById('btnPrev');
        const btnNext = document.getElementById('btnNext');
        const btnSubmitQuiz = document.getElementById('btnSubmitQuiz');
        const currentIndexTxt = document.getElementById('current-index-txt');
        const totalQuestionsTxt = document.getElementById('total-questions-txt');

        if(totalQuestionsTxt) totalQuestionsTxt.innerText = totalSteps;

        // --- MANEJO LOGICO DE PANTALLA COMPLETA ---
        const startOverlay = document.getElementById('startOverlay');
        const btnStartQuizAction = document.getElementById('btnStartQuizAction');

        btnStartQuizAction.addEventListener('click', function() {
            const docElm = document.documentElement;
            if (docElm.requestFullscreen) docElm.requestFullscreen();
            else if (docElm.mozRequestFullScreen) docElm.mozRequestFullScreen();
            else if (docElm.webkitRequestFullscreen) docElm.webkitRequestFullscreen();
            else if (docElm.msRequestFullscreen) docElm.msRequestFullscreen();
            
            startOverlay.style.display = 'none';
            examenIniciado = true;
        });

        // Actualización visual del carrusel pregunta por pregunta
        function updateNavigation() {
            steps.forEach((step, idx) => {
                if(idx === currentStep) {
                    step.classList.add('active');
                } else {
                    step.classList.remove('active');
                }
            });

            if(currentIndexTxt) currentIndexTxt.innerText = currentStep + 1;

            if (currentStep === 0) {
                btnPrev.classList.add('hidden');
                btnNext.style.display = 'inline-block';
                btnSubmitQuiz.style.display = 'none';
            } 
            else if (currentStep === totalSteps - 1) {
                btnPrev.classList.remove('hidden');
                btnNext.style.display = 'none';
                btnSubmitQuiz.style.display = 'inline-block';
            } 
            else {
                btnPrev.classList.remove('hidden');
                btnNext.style.display = 'inline-block';
                btnSubmitQuiz.style.display = 'none';
            }
        }

        btnNext.addEventListener('click', () => {
            if (currentStep < totalSteps - 1) {
                currentStep++;
                updateNavigation();
            }
        });

        btnPrev.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                updateNavigation();
            }
        });

        updateNavigation();

        // Congelar botón atrás del navegador
        window.history.pushState(null, "", window.location.href);
        window.onpopstate = function () {
            window.history.pushState(null, "", window.location.href);
        };

        // Referencias de los Modales
        const quizForm = document.getElementById('quizForm');
        const confirmModal = document.getElementById('confirmModal');
        const btnConfirmSend = document.getElementById('btnConfirmSend');
        const btnCancelSend = document.getElementById('btnCancelSend');
        const countdownElement = document.getElementById('countdown');

        const incompleteModal = document.getElementById('incompleteModal');
        const incompleteQuestionsList = document.getElementById('incompleteQuestionsList');
        const btnIncompleteClose = document.getElementById('btnIncompleteClose');

        const fraudWarningModal = document.getElementById('fraudWarningModal');
        const warningBoxWrapper = document.getElementById('warningBoxWrapper');
        const warningTitle = document.getElementById('warningTitle');
        const warningBody = document.getElementById('warningBody');
        const btnUnderstandWarning = document.getElementById('btnUnderstandWarning');
        const invalidationCountdownTxt = document.getElementById('invalidationCountdownTxt');
        const fraudCountTxt = document.getElementById('fraud-count-txt');
        const intentosFraudeInput = document.getElementById('intentosFraudeInput');

        let contadorFraudes = 0;

        // Intercepta el clic en "Enviar Cuestionario" y abre el modal confirmatorio
        function interceptarEnvio(event) {
            if (tiempoExpirado || formularioConfirmado || pruebaInvalidadaPorCompleto) {
                return true;
            }
            event.preventDefault();
            confirmModal.classList.add('active');
            return false;
        }

        // =========================================================================
        // VALIDACIÓN DE PREGUNTAS EN BLANCO INTEGRADA EN MODAL INTERNO (NO APAGA FULLSCREEN)
        // =========================================================================
        btnConfirmSend.addEventListener('click', function() {
            if (pruebaInvalidadaPorCompleto) {
                formularioConfirmado = true;
                confirmModal.classList.remove('active');
                if (quizForm) quizForm.submit();
                return;
            }

            // Identificar los grupos únicos de preguntas dinámicamente
            let preguntasNombres = [];
            const inputsRadio = quizForm.querySelectorAll("input[type='radio']");
            inputsRadio.forEach(radio => {
                if (!preguntasNombres.includes(radio.name)) {
                    preguntasNombres.push(radio.name);
                }
            });

            let preguntasFaltantesNum = [];

            // Comprobar cuáles se quedaron sin marcar
            preguntasNombres.forEach((nombre, indice) => {
                let marcado = quizForm.querySelector(`input[name='${nombre}']:checked`);
                if (!marcado) {
                    preguntasFaltantesNum.push(indice + 1);
                }
            });

            // Si hay preguntas sin responder, abrimos el modal interno propio en vez de alert()
            if (preguntasFaltantesNum.length > 0) {
                confirmModal.classList.remove('active'); 
                
                // Agregamos los números faltantes al contenedor del DOM
                incompleteQuestionsList.innerText = preguntasFaltantesNum.join(", ");
                
                // Activamos bandera para blindar la pérdida de foco del modal y mostramos
                validadorInternoActivo = true;
                incompleteModal.classList.add('active');
                
                return false;
            }

            // Si pasó la validación, procedemos formalmente
            formularioConfirmado = true;
            confirmModal.classList.remove('active');
            if (quizForm) quizForm.submit();
        });

        // Botón para cerrar el modal interno de incompletas
        btnIncompleteClose.addEventListener('click', function() {
            incompleteModal.classList.remove('active');
            validadorInternoActivo = false;
        });

        btnCancelSend.addEventListener('click', function() {
            confirmModal.classList.remove('active');
        });

        btnUnderstandWarning.addEventListener('click', function() {
            if (!pruebaInvalidadaPorCompleto) {
                fraudWarningModal.classList.remove('active');
                if (!document.fullscreenElement) {
                    const docElm = document.documentElement;
                    if (docElm.requestFullscreen) docElm.requestFullscreen();
                }
            }
        });

        // --- SISTEMA ANTIFRAUDE DE 3 ADVERTENCIAS MÁXIMO ---
        function activarAlertaFraude() {
            // Si el modal de incompletas está activo, blindamos falsas alarmas de pérdida de foco
            if (validadorInternoActivo) return;
            if (!examenIniciado || tiempoExpirado || formularioConfirmado || pruebaInvalidadaPorCompleto) return;

            if (!fraudWarningModal.classList.contains('active')) {
                contadorFraudes++;
                
                if(fraudCountTxt) fraudCountTxt.innerText = contadorFraudes;
                if(intentosFraudeInput) intentosFraudeInput.value = contadorFraudes;
                
                fraudWarningModal.classList.add('active');

                if (contadorFraudes >= 3) {
                    pruebaInvalidadaPorCompleto = true;
                    confirmModal.classList.remove('active');
                    incompleteModal.classList.remove('active');

                    warningBoxWrapper.classList.add('invalidated');
                    warningTitle.innerText = "PRUEBA INVALIDADA";
                    warningBody.innerHTML = "<span style='color:#b91c1c; font-weight:bold;'>La evaluación ya no es válida debido a reiteradas salidas del entorno seguro (3 infracciones).</span><br><br>El sistema guardará su progreso actual y cerrará la sesión en:";
                    
                    btnUnderstandWarning.style.display = 'none';
                    invalidationCountdownTxt.style.display = 'block';

                    let segundosCierre = 10;
                    const intervaloInfraccion = setInterval(() => {
                        segundosCierre--;
                        invalidationCountdownTxt.innerText = segundosCierre;
                        
                        if (segundosCierre <= 0) {
                            clearInterval(intervaloInfraccion);
                            formularioConfirmado = true; 
                            if (quizForm) quizForm.submit(); 
                        }
                    }, 1000);
                }
            }
        }

        // Detectores de salida de entorno seguro
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) activarAlertaFraude();
        });

        window.addEventListener('blur', function() {
            setTimeout(() => {
                if (!document.hasFocus()) activarAlertaFraude();
            }, 250);
        });

        document.addEventListener("fullscreenchange", function() {
            if (!document.fullscreenElement && examenIniciado) {
                activarAlertaFraude();
            }
        });

        window.addEventListener("keydown", function(e) {
            if (e.keyCode === 122 || e.key === "F11" || e.keyCode === 27 || e.key === "Escape") {
                e.preventDefault();
                activarAlertaFraude();
            }
        }, true);

        // --- RELOJ CONTINUO VINCULADO AL SERVIDOR ---
        let totalSeconds = <?php echo (int)($segundos_restantes ?? 4860); ?>;

        function updateTimer() {
            if (totalSeconds <= 0) {
                countdownElement.innerHTML = "00:00:00";
                clearInterval(timerInterval);
                tiempoExpirado = true;
                confirmModal.classList.remove('active');
                incompleteModal.classList.remove('active');
                fraudWarningModal.classList.remove('active');
                alert("El tiempo ha terminado. Tu cuestionario se enviará automáticamente.");
                if (quizForm) quizForm.submit();
                return;
            }

            let hours = Math.floor(totalSeconds / 3600);
            let minutes = Math.floor((totalSeconds % 3600) / 60);
            let seconds = totalSeconds % 60;

            hours = hours < 10 ? '0' + hours : hours;
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;

            if (countdownElement) countdownElement.innerHTML = hours + ":" + minutes + ":" + seconds;
            totalSeconds--;
        }

        updateTimer();
        const timerInterval = setInterval(updateTimer, 1000);
    </script>

</body>
</html>