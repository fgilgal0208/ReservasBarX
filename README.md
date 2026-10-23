# ReservasBarX - Sistema de Gestión de Habitaciones 🏨

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-B73BFE?style=for-the-badge&logo=vite&logoColor=FFD62E)
![MySQL/SQLite](https://img.shields.io/badge/Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

Aplicación web full-stack desarrollada en **Laravel** diseñada para administrar de forma integral las reservas de habitaciones. Proporciona una interfaz intuitiva para el control de disponibilidad, registro de usuarios, generación automatizada de comprobantes y una API RESTful.

---

## 🚀 Características Principales y Explicación del Proyecto

* **Gestión de Habitaciones (`ReservaController.php` & `Reserva.php`):** Lógica para la creación, lectura, actualización y eliminación (CRUD) de las reservas asociadas a las habitaciones, controlando rigurosamente las fechas de entrada y salida.
* **Autenticación y API REST (`AuthController.php` & `Sanctum`):** Sistema de login y registro de usuarios. Implementa **Laravel Sanctum** para la emisión de tokens, permitiendo que el sistema funcione tanto de forma monolítica (vistas Blade) como proveedor de una API RESTful segura (`routes/api.php`).
* **Generación Dinámica de PDFs (`pdf/reservas.blade.php`):** Exportación de comprobantes, tickets o listados de reservas en formato PDF directamente desde el panel de administración.
* **Interfaz Optimizada (Blade & Vite):** Frontend renderizado con el motor de plantillas **Blade** (`index.blade.php`, `welcome.blade.php`) y empaquetado con **Vite** para una carga rápida y eficiente de recursos estáticos.

---

## 🛠️ Stack Tecnológico

* **Backend:** PHP, Laravel, Laravel Sanctum
* **Frontend:** Blade, CSS, JavaScript (Vite)
* **Base de Datos:** MySQL / SQLite
* **Testing & API:** PHPUnit, Postman
* **Control de Versiones:** Git, GitHub

---

## ⚙️ Inicialización e Instalación de Dependencias

Para desplegar este proyecto en un entorno local, es necesario contar con **PHP**, **Composer** y **Node.js** instalados en el sistema.

1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/fgilgal0208/reservasbarx.git
   cd reservasbarx
   ```

2. **Instalar dependencias de PHP (Backend):**
   ```bash
   composer install
   ```

3. **Instalar y compilar dependencias de Node.js (Frontend):**
   ```bash
   npm install
   npm run build
   ```

4. **Configurar las variables de entorno:**
   Copia el archivo de ejemplo para generar tu configuración local.
   ```bash
   cp .env.example .env
   ```

5. **Generar la clave criptográfica de la aplicación:**
   ```bash
   php artisan key:generate
   ```

6. **Configurar la base de datos y ejecutar migraciones:**
   Abre el archivo `.env` y define los parámetros de conexión. Para pruebas rápidas en local, puedes usar SQLite cambiando `DB_CONNECTION=sqlite` y creando un archivo vacío llamado `database.sqlite` en la carpeta `database/`.
   Una vez configurado, crea las tablas ejecutando:
   ```bash
   php artisan migrate
   ```

7. **Levantar el servidor de desarrollo:**
   ```bash
   php artisan serve
   ```
   *El acceso estará disponible en `http://localhost:8000`.*

---

## 🧪 Testing y Pruebas de API

### Pruebas Automatizadas con PHPUnit
El proyecto incluye una suite de pruebas (Unitarias y Feature Tests) ubicada en la carpeta `tests/` para garantizar la estabilidad del código. Para ejecutarlas:
```bash
php artisan test
```

### Consumo de API con Postman
El sistema expone endpoints documentados en `routes/api.php`. Para interactuar con ellos desde Postman:
1. Realiza una petición `POST` al endpoint de autenticación (login) con credenciales válidas.
2. Copia el token de acceso devuelto en la respuesta (generado por Sanctum).
3. En tus siguientes peticiones a rutas protegidas, ve a la pestaña **Authorization** en Postman, selecciona **Bearer Token** y pega el token copiado.

---

## 📄 Licencia y Copyright

&copy; 2026 Francisco Gilarte Galán. Todos los derechos reservados.

Este repositorio y su contenido se proporcionan exclusivamente con fines de exhibición y evaluación profesional (portafolio). No se otorga permiso para utilizar, copiar, modificar o distribuir este código con fines comerciales o derivados sin autorización expresa del autor.
