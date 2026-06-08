# Test de Conocimiento

**Test de Conocimiento** es una aplicación web diseñada para la gestión, realización y control de evaluaciones en línea. El sistema cuenta con un banco de preguntas precargadas, un estricto módulo de seguridad antifraude en tiempo real y herramientas de reportería para los administradores.

---

## 🚀 Características Principales

* **Autenticación Segura:** Acceso restringido para los evaluados mediante contraseñas cifradas con el algoritmo Bcrypt.
* **Sistema Antifraude Estricto:** Monitoreo activo durante la prueba. El sistema detecta y penaliza si el usuario:
    * Cambia de pestaña en el navegador.
    * Sale del modo pantalla completa.
    * Cambia de aplicación en el sistema operativo.
    * *Nota:* Si el sistema registra **más de 3 intentos de fraude**, la evaluación se cerrará automáticamente y se mostrará un mensaje de advertencia.
* **Módulo de Reportes:** Panel dedicado para la visualización, filtrado y ordenamiento de las respuestas y notas finales obtenidas.
* **Generador de Credenciales:** Herramienta integrada para la creación de contraseñas seguras.

---

## 🛠️ Stack Tecnológico

* **Backend:** PHP (con soporte para Composer y PHPMailer).
* **Frontend:** HTML5, CSS3, JavaScript (para el control de eventos del sistema antifraude).
* **Base de Datos:** MySQL / MariaDB.
* **Entorno de Desarrollo Recomendado:** XAMPP.

---

## 📋 Requisitos Previos

Antes de comenzar, asegúrate de tener instalado en tu equipo:
* [XAMPP](https://www.apachefriends.org/) (con PHP 8.x o superior).
* Gestor de dependencias [Composer](https://getcomposer.org/) (opcional, para la gestión de librerías de envío de correo).

---

## 🔧 Instalación y Configuración

Sigue estos pasos para desplegar el proyecto localmente:

### 1. Clonar o copiar el proyecto
Ubica la carpeta del proyecto dentro del directorio raíz de tu servidor local. Si utilizas XAMPP, la ruta por defecto es:
`C:\xampp\htdocs\prueba\`

### 2. Levantar los servicios
Abre el **XAMPP Control Panel** e inicia los siguientes servicios:
* **Apache**
* **MySQL**

### 3. Importar la Base de Datos
1. Dirígete a tu navegador e ingresa a `http://localhost/phpmyadmin/`.
2. Crea una nueva base de datos llamada `sistema_evaluacion`.
3. Selecciona la base de datos recién creada, ve a la pestaña **Importar**, selecciona el archivo `sistema_evaluacion.sql` incluido en el proyecto y haz clic en **Continuar/Importar**.

---

## 🖥️ Uso de la Aplicación

### Acceso de Usuarios (Evaluados)
Para ingresar a realizar la prueba, los usuarios deben utilizar su documento de identidad y una **contraseña previamente asignada y facilitada por el administrador**.

### Rutas de Administración y Herramientas

* **Generador de Contraseñas:** Para crear contraseñas seguras hasheadas con Bcrypt válidas para la base de datos, accede a:
    ```text
    http://servidor/prueba/generar.php
    ```
* **Panel de Reportes:**
    Para visualizar el resumen de las respuestas de los estudiantes, analizar las notas y ordenarlas utilizando los filtros disponibles, ingresa a:
    ```text
    http://servidor/prueba/reporte
    ```

---

## 📄 Licencia

Este proyecto se encuentra bajo la Licencia **MIT**. Siéntete libre de usar, modificar y distribuir el código.

---

## 👤 Autor

* **Ingeniero Luis Enrique Arias Chavarro** - *Desarrollo y Diseño del Sistema*