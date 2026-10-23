# ReservasBarX - Sistema de Gestión de Habitaciones 🏨

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-B73BFE?style=for-the-badge&logo=vite&logoColor=FFD62E)
![MySQL/SQLite](https://img.shields.io/badge/Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

Aplicación web full-stack desarrollada en **Laravel** diseñada para administrar de forma integral las reservas de habitaciones. Proporciona una interfaz intuitiva para el control de disponibilidad, registro de usuarios y generación automatizada de comprobantes.

---

## 🚀 Características Principales y Explicación del Código

* **Gestión de Habitaciones (`ReservaController.php` & `Reserva.php`):** Contiene la lógica para la creación, lectura, actualización y eliminación (CRUD) de las reservas asociadas a las habitaciones, controlando las fechas de entrada y salida.
* **Autenticación Segura (`AuthController.php` & `User.php`):** Sistema de login y registro de usuarios para proteger el panel de administración y garantizar que las reservas estén vinculadas a clientes reales.
* **Generación Dinámica de PDFs (`pdf/reservas.blade.php`):** Exportación de comprobantes, tickets o listados de reservas de habitaciones en formato PDF directamente desde el panel.
* **Interfaz Optimizada (Blade & Vite):** Frontend renderizado con el motor de plantillas **Blade** (`index.blade.php`, `welcome.blade.php`) y empaquetado con **Vite** para una carga rápida y eficiente de CSS/JS.
* **Estructura de Base de Datos Escalar:** Migraciones de Laravel preparadas para desplegar automáticamente las tablas necesarias (usuarios, reservas, tokens) de forma estructurada.

---

## 🛠️ Tecnologías Utilizadas

* **Backend:** PHP, Laravel
* **Frontend:** Blade, CSS, JavaScript (Vite)
* **Base de Datos:** MySQL / SQLite
* **Control de Versiones:** Git, GitHub

---

## ⚙️ Inicialización del Proyecto (Desarrollo Local)

Para ejecutar este proyecto en tu entorno local, necesitas tener instalados **PHP**, **Composer** y **Node.js**. Abre tu terminal y sigue estos pasos:

1. **Clonar el repositorio:**
   ```bash
   git clone [https://github.com/fgilgal0208/reservasbarx.git](https://github.com/fgilgal0208/reservasbarx.git)
   cd reservasbarx
