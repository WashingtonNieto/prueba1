-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-06-2026 a las 03:39:59
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_evaluacion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id` int(11) NOT NULL,
  `pregunta` text NOT NULL,
  `opcion_a` varchar(255) NOT NULL,
  `opcion_b` varchar(255) NOT NULL,
  `opcion_c` varchar(255) NOT NULL,
  `opcion_d` varchar(255) NOT NULL,
  `respuesta_correcta` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id`, `pregunta`, `opcion_a`, `opcion_b`, `opcion_c`, `opcion_d`, `respuesta_correcta`) VALUES
(1, '¿Cuál es la url de la aplicación de chatbot, empleada para el despliegue?', 'https://botpress.com', 'https://flowchat.com', 'https://chatbot.com', 'Ninguna de las anteriores', 'https://botpress.com'),
(2, '¿Qué función tiene el archivo composer.lock?', 'Registrar versiones instaladas.', 'Listar las sugerencias de paquetes nuevos.', 'Bloquear el acceso a usuarios no autorizados.', 'Guardar las contraseñas de la base de datos.', 'Registrar versiones instaladas.'),
(3, '¿Cuál es el comando para verificar la versión de Composer?', 'composer -v.', 'composer check-version.', 'php composer status.', 'get composer-info.', 'composer -v.'),
(4, '¿Qué es Composer en el ecosistema de PHP?', 'Administrador de dependencias.', 'Un compilador de código fuente a binario.', 'Un servidor web ligero para desarrollo local.', 'Un editor de texto especializado en scripts.', 'Administrador de dependencias.'),
(5, '¿Qué tipo de contenido se guarda físicamente en el hosting?', 'Archivos y bases de datos.', 'Solo el nombre registrado de la marca comercial.', 'Las búsquedas que realizan los usuarios en Google.', 'El contrato legal de registro del dominio web.', 'Archivos y bases de datos.'),
(6, '¿Es posible poseer un dominio sin tener hosting contratado?', 'Sí, pero no habrá web activa.', 'No, el registro exige hosting obligatorio siempre.', 'Solo si el dominio termina en la extensión .org.', 'Sí, y la web funcionará usando la memoria del PC.', 'Sí, pero no habrá web activa.'),
(7, '¿Cuál es la forma más confiable de enviar emails en PHP?', 'Envío directo vía SMTP.', 'Uso de la función nativa mail() sin ajustes.', 'Envío mediante scripts de JavaScript front-end.', 'Copiar y pegar el texto en un gestor externo', 'Envío directo vía SMTP.'),
(8, '¿Cuál es el comando oficial recomendado para realizar la instalación de la librería PHPMailer utilizando el gestor de dependencias de PHP?.', 'composer require phpmailer/phpmailer.', 'composer install phpmailer-lib.', 'php get-package phpmailer.', 'git install phpmailer/phpmailer.', 'composer require phpmailer/phpmailer.'),
(9, 'Al ejecutar el comando composer --version en la terminal, además de mostrarse la versión específica del gestor de dependencias, ¿qué otra versión de entorno de ejecución aparece detallada en la salida del sistema?', 'Php', 'MySQL', 'Apache', 'Laravel', 'Php'),
(10, 'Dentro del flujo de trabajo con el gestor de dependencias de PHP, ¿cuál es la función principal del archivo de texto plano denominado composer.json?', 'Especificar las librerías necesarias y las versiones aceptadas para el proyecto.', 'Registrar las versiones exactas instaladas para asegurar la consistencia entre equipos.', 'Almacenar de forma segura las credenciales y contraseñas de la base de datos.', 'Configurar las reglas de enrutamiento y las vistas del patrón Modelo-Vista-Controlador.', 'Especificar las librerías necesarias y las versiones aceptadas para el proyecto.'),
(11, '¿Qué significa técnicamente que el algoritmo matemático Bcrypt sea \"irreversible\" al procesar datos?', 'No existe una operation matemática inversa para deshacer el proceso.', 'El acceso a los datos originales queda restringido únicamente al desarrollador principal del software.', 'La base de datos deshabilita las funciones de edición para evitar que la clave sea modificada por terceros.', 'El servidor requiere un certificado de seguridad adicional para mostrar el contenido real de la información.', 'No existe una operación matemática inversa para deshacer el proceso.'),
(12, '¿Qué elemento de seguridad se debe generar específicamente para autenticarse ante el servidor de Gmail y permitir que PHPMailer envíe correos electrónicos en nombre del usuario?', 'Una contraseña para aplicaciones.', 'El código de verificación de dos pasos del dispositivo móvil.', 'Una clave de API pública generada en la consola de servicios.', 'El certificado de seguridad SSL emitido por el proveedor de hosting.', 'Una contraseña para aplicaciones.'),
(13, '¿Qué comando se utiliza para iniciar un repositorio local?', 'git init.', 'git start-project.', 'git create-repo.', 'git new-instance.', 'git init.'),
(14, '¿Qué información proporciona el comando \"git status\"?', 'Lista archivos modificados.', 'El nombre de todos los colaboradores del mes.', 'La velocidad de subida a los servidores remotos.', 'El tiempo total dedicado a escribir el código.', 'Lista archivos modificados.'),
(15, '¿Qué acción realiza el comando \"git commit\"?', 'Registra instantáneas de cambios.', 'Borra permanentemente el historial de versiones.', 'Sube los archivos directamente a la nube pública.', 'Comprime el proyecto en un archivo comprimido .zip.', 'Registra instantáneas de cambios.'),
(16, '¿Qué función cumple \"git remote add origin\"?', 'Vincula repositorio y nube.', 'Crea una copia de seguridad en un disco externo.', 'Instala la interfaz gráfica GitHub Desktop.', 'Configura el correo electrónico del programador.', 'Vincula repositorio y nube.'),
(17, '¿Qué comando envía los cambios locales al servidor remoto?', 'git push.', 'git upload-to-cloud.', 'git sync-online-now.', 'git send-commits.', 'git push.'),
(18, '¿Qué representa un objeto en el paradigma de POO?', 'Una instancia de una clase.', 'Una línea de código que contiene una operación.', 'Un archivo de configuración con formato XML.', 'Un dispositivo físico conectado a la computadora.', 'Una instancia de una clase.'),
(19, '¿Qué es el polimorfismo en desarrollo de software?', 'Tomar varias formas según contexto.', 'Traducir el código a varios lenguajes humanos.', 'Usar múltiples bases de datos al mismo tiempo.', 'Que un objeto pueda borrarse a sí mismo siempre.', 'Tomar varias formas según contexto.'),
(20, '¿Qué busca lograr la abstracción?', 'Modelar solo lo relevante.', 'Escribir código que nadie pueda entender.', 'Eliminar todas las variables de un programa.', 'Que el software funcione sin usar memoria RAM.', 'Modelar solo lo relevante.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados`
--

CREATE TABLE `resultados` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `respuestas_json` text NOT NULL,
  `nota_final` decimal(4,2) NOT NULL,
  `intentos_fraude` int(11) DEFAULT 0,
  `fecha_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `documento` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `documento`, `password`) VALUES
(1, 'Alan Ferney Betancourt Briceño', '1025540025', '$2y$10$RRA4sXs0vGrq5LkhNIsPs.bYY8agJ1aMWVONXKcOvMs.2e0hJRFsu'),
(2, 'Angel David Olaya Bedoya', '1001067012', '$2y$10$gyFbn1epYwokT4X69jw/7u6.GEp/ra10a158qtK70YMqOzmRT76o.'),
(3, 'Cristian David Motta Garzon', '1069257598', '$2y$10$zAtg0pUk9LuLr4gI3dH9vehsiZH4jYWu9cnOR.lPUM2LWIxlK//cK'),
(4, 'Daniela Sofia Yara Roberto', '1031651509', '$2y$10$gDaN5CuQ22yxX84HFmVPgu6dbnFCifdMhP//eEcDoYuSXdCM2O1xm'),
(5, 'Diego Esteban Arevalo Lozano', '1033100730', '$2y$10$48LnVstAqor9KpUsdfzpoue.GG4ksKJrkXvXgPDa8jnxck9jsVynu'),
(6, 'Jafet David Pineda Cespedes', '1072746605', '$2y$10$hrKqoPNtSBCkGDDPlGJL7eicF0SVq7NajIu5Y8Ai2Y1GYFfoZxm4.'),
(7, 'Jose David Tapiero Cuastumal', '1150184549', '$2y$10$kq6xiY5Q9ocym6KAk4gdnuHkJ/mPEUvfesZ0xSpF0TQZEJgqQUuhq'),
(8, 'Juan Andrés Rodríguez Pinzón', '1013118911', '$2y$10$dIfnLAMOB8.ZElUgy.HTqOMpOpzOOfPSrUOWhwm28jJ3i8PBozsNu'),
(9, 'Juan David Mulcue Sanza', '1019763830', '$2y$10$qicg8EGbq2kmt/1YRBNOB.aX3xKElBQAnXWLKPSo1BMQFLbpJg7ni'),
(10, 'Juan David Acuña Diaz', '1013609287', '$2y$10$c1V7XvB5M7pA7Q2h8F.Nu.K9zZfO0gE0HjB5qSgE6v7Gg39Wv90gq'),
(11, 'Juan David Tamayo Bahamon', '1077224458', '$2y$10$a5jTejehG6pl/O/c.SxypOzIsnpTbAkdp6JlsMxeQ6hlewDhAeLba'),
(12, 'Juan Felipe Lopez Gaona', '1022958566', '$2y$10$flnWF8vlpTNxgfzRXEV6Tulsy/ml1ZDPrrD.s.azylhak9ZisF8dO'),
(13, 'Juan Jose Montaño Martínez', '1068952619', '$2y$10$Hdog4ocY5jwCPQdxZ0xgA.Zbfs0eEPmufApnNOzl9hhEvFumeSVHC'),
(14, 'Juan Pablo Lesmes Mora', '1014667358', '$2y$10$/kEmFfpwaaMX4Rt1EVrga.VaU9I4iBMq8G1.f9ScyG//tsWgFGv.O'),
(15, 'Julio César Santana De Angel', '1021396059', '$2y$10$FslXRo48wTZrMx5St0x9Xe1t5Y0j/31Jm/vk6UAHzWvFDyb7LVY0e'),
(16, 'Karol Eliana Cortes Lopez', '1071839153', '$2y$10$BysUUNXWbEjpCViHowai4OXBGEopi/u1QJwE9qlMxtP.27iosnDZm'),
(17, 'Kendra Sofia Triana Guevara', '1021676535', '$2y$10$BmoKd5duZQe0r/mVQFm1F.DM5HTGldkLX8ZKzuuQud8yrs4veFfMC'),
(18, 'Laura Sofia Buitrago Olivares', '1049412713', '$2y$10$y3.a.Blf0lHqdkMUUt1/jepI2ixp6XUKc./IK3g3BS.sO3hVWQRZ2'),
(19, 'Luis Armando Sinning Mejia', '1052961513', '$2y$10$JK0zwBi8W/1kGEywby5ro.QCCdT2g4X.WZRUPScmuId5PuyDWfsCK'),
(20, 'María Alejandra Barrios Perez', '1023365209', '$2y$10$mShQy43n3x/swLA4ZyIhwO/LuORHxEg143VpuWFwdK6Q1S/U.MZD6'),
(21, 'Nicolás Santiago Polo Moreno', '1013116345', '$2y$10$q4Clviyu5xKdFaLSvBDu/.qJiPWdn6RS7lJkKxSKgcNu9MSq2Thgu'),
(27, 'Santiago Avellaneda Maldonado', '1025062749', '$2y$10$cDzosSHef3cnJaOjFd39guCL0T5mhiXRqGyVOXV/q/08.31ohaFoe'),
(28, 'Sergio Andrés Navarro Ayala', '1097099204', '$2y$10$P7KjfNO5FY72ytQRfTFiMub8XOuXvyQGZ0UMm7FkYOzT6nNKLXJ4m'),
(29, 'Sofia Ovalle Chocontá', '1013118877', '$2y$10$Xe4iDSyQK4Wi7Gi0vD9h1OjaLytGMw9tD4rXy6.MyeFR4NtLJnNxK'),
(30, 'Yeni Tatiana Bolaños Jurado', '1089907920', '$2y$10$WRrpdkUCTG7I41Bw80/iqemMZjYMvJ78wrrKXvhkwGNui2QA15iGC'),
(31, 'Yenifer Patiño Aguinaga', '1006417107', '$2y$10$gUqa7blzg.dfWYy/02LWC.mB7s8WbLBjR9K5MZsKZliqAve1YlSNi');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `resultados`
--
ALTER TABLE `resultados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `documento` (`documento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `resultados`
--
ALTER TABLE `resultados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `resultados`
--
ALTER TABLE `resultados`
  ADD CONSTRAINT `fk_resultados_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
