# Indaluz 🌱

**Marketplace digital de productos agrícolas de proximidad** que conecta de forma directa a productores locales (agricultores) con consumidores finales, eliminando intermediarios.

Indaluz funciona como un e-commerce especializado en frutas y verduras frescas y de temporada: los agricultores publican y gestionan su catálogo, controlan su inventario y atienden pedidos, mientras los clientes compran online, eligen recogida o entrega a domicilio y valoran el servicio mediante reseñas. La plataforma busca dar mejores márgenes al agricultor, precios competitivos al consumidor y contribuir a reducir el desperdicio alimentario fomentando el consumo local.

> Proyecto Final de Ciclo — Anthony Ramos de León · I.E.S. Al-Ándalus · Curso 2024/2025

---

## ✨ Funcionalidades principales

La aplicación se organiza en torno a tres roles de usuario:

### 👤 Cliente
- Registro con verificación de correo electrónico.
- Catálogo de productos con búsqueda y filtrado por categoría.
- Ficha de producto con detalle, agricultor vendedor y selección de cantidad.
- Carrito de compras con validación de stock en tiempo real.
- Proceso de checkout: datos de envío, método de pago (tarjeta/efectivo) y método de entrega (recogida/domicilio).
- Historial de pedidos y seguimiento de estados.
- Reseñas y valoraciones de agricultores sobre pedidos entregados.
- Gestión del perfil personal (datos, avatar y contraseña).

### 🚜 Agricultor
- Dashboard con resumen de actividad.
- Gestión completa de productos (CRUD, reactivar y actualizar stock).
- Gestión de pedidos: ver detalle, actualizar estado, marcar como preparado y exportar.
- Módulo de ventas con métricas y exportación.
- Visualización de reseñas recibidas de los clientes.
- Perfil público de empresa (descripción, experiencia, certificaciones, métodos de cultivo, horario, foto de perfil y portada) con vista previa.

### 🛠️ Administrador
- Rol contemplado en el sistema (dashboard en desarrollo) para supervisión de usuarios, moderación de contenido y gestión de reportes/disputas.

### 🌐 Páginas públicas
- Inicio, Nosotros, Sostenibilidad, Agricultores y Contacto (con formulario de envío a soporte).

---

## 🧱 Stack tecnológico

| Capa | Tecnología |
|------|------------|
| Backend | [Laravel 12](https://laravel.com) (PHP ^8.2) — patrón MVC |
| ORM | Eloquent |
| Base de datos | MySQL / MariaDB |
| Motor de plantillas | Blade |
| Frontend | HTML5, CSS3, JavaScript vanilla |
| Estilos | [Tailwind CSS 4](https://tailwindcss.com) |
| Build / assets | [Vite 6](https://vitejs.dev) |
| Gestor de dependencias PHP | Composer |
| Entorno local | XAMPP (Apache + MySQL + PHP) |

---

## 🗂️ Arquitectura

La lógica de negocio se organiza por módulos en namespaces específicos para cada rol:

```
app/Http/Controllers/
├── Auth/          → Registro, login y verificación de correo
├── Cliente/       → Catálogo, carrito, checkout, pedidos, reseñas y perfil
├── Agricultor/    → Productos, pedidos, ventas, reseñas y perfil
└── HomeController → Páginas públicas y formulario de contacto
```

- **Capa de presentación:** Blade + Tailwind CSS, con un *layout* maestro propio por cada rol (`resources/views/layouts/`).
- **Capa de lógica de negocio:** controladores agrupados por rol.
- **Capa de datos:** modelos Eloquent (`Usuario`, `Producto`, `Pedido`, `DetallePedido`, `Reseña`, `Verificacion`).
- **Control de acceso:** middleware personalizado `CheckRole` que protege las rutas según el rol (`role:cliente`, `role:agricultor`, `role:administrador`).

### 🔐 Seguridad
- Verificación de correo obligatoria antes del primer acceso.
- Tokens CSRF en todos los formularios.
- Contraseñas hasheadas con bcrypt; campos sensibles ocultos en el modelo (`$hidden`).
- Validación y sanitización de inputs en servidor; consultas preparadas vía Eloquent (prevención de inyección SQL).
- Validación de tipo MIME y límites de tamaño en la subida de imágenes.
- Validación de stock en tiempo real y uso de transacciones en operaciones críticas (creación de pedidos).
- Simulación del procesamiento de pagos sin almacenar datos de tarjeta.

---

## 🗄️ Base de datos

Base de datos `indaluz` (MySQL/MariaDB), normalizada hasta 3FN. El esquema completo está en [`database/indaluz.sql`](database/indaluz.sql).

| Tabla | Descripción |
|-------|-------------|
| `usuarios` | Tabla polimórfica de todos los usuarios diferenciados por el campo `rol` (administrador, cliente, agricultor). Incluye campos específicos de agricultor (empresa, certificaciones, métodos de cultivo, etc.). |
| `productos` | Catálogo vinculado al agricultor (`id_agricultor`). Categoría (fruta/verdura), unidad de medida, inventario y tiempo de cosecha. |
| `pedidos` | Pedidos de los clientes con estado, método de pago/entrega y datos de envío. |
| `detalle_pedido` | Líneas de pedido (*Order-LineItem*); guarda el precio histórico unitario. |
| `reseñas` | Valoraciones cliente–agricultor–pedido (solo sobre transacciones completadas). |
| `reportes` | Reportes de clientes/agricultores sobre productos o pedidos para moderación del administrador. |
| `verificaciones` | Tokens de verificación de correo electrónico. |
| `password_resets` | Tokens de recuperación de contraseña. |

> Nota: el esquema de tablas vive en el dump SQL (las migraciones de Laravel del repositorio son stubs). Importa `database/indaluz.sql` para crear la estructura.

---

## 🚀 Instalación y puesta en marcha

### Requisitos previos
- PHP ≥ 8.2
- Composer
- Node.js y npm
- MySQL / MariaDB (p. ej. mediante **XAMPP**)

### Pasos

1. **Clonar el repositorio**
   ```bash
   git clone git@github.com:Anthony0827/Indaluz-Proyecto-Final.git
   cd Indaluz-Proyecto-Final
   ```

2. **Instalar dependencias**
   ```bash
   composer install
   npm install
   ```

3. **Configurar el entorno**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Crear e importar la base de datos**

   Crea una base de datos llamada `indaluz` (por ejemplo desde phpMyAdmin) e importa el esquema:
   ```bash
   mysql -u root indaluz < database/indaluz.sql
   ```

5. **Configurar la conexión en `.env`**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=indaluz
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Enlazar el almacenamiento público** (para las imágenes subidas)
   ```bash
   php artisan storage:link
   ```

7. **Compilar assets y arrancar**
   ```bash
   npm run dev          # compila assets (Vite) en modo desarrollo
   php artisan serve    # servidor de desarrollo en http://localhost:8000
   ```

   > Alternativamente, sirve el proyecto directamente con Apache de XAMPP apuntando a la carpeta `public/`.

---

## 📁 Estructura del proyecto

```
Indaluz-Proyecto-Final/
├── app/
│   ├── Http/Controllers/   # Controladores por rol (Auth, Cliente, Agricultor)
│   ├── Http/Middleware/     # CheckRole
│   ├── Mail/                # Correos (verificación, confirmación de pedido)
│   └── Models/              # Modelos Eloquent
├── database/
│   ├── indaluz.sql          # Esquema completo de la base de datos
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── resources/views/         # Vistas Blade (públicas, cliente, agricultor, auth, emails)
├── routes/web.php           # Definición de rutas
├── public/                  # Punto de entrada y assets compilados
└── ...
```

---

## 👤 Autor

**Anthony Ramos de León** — Proyecto Final de Ciclo, I.E.S. Al-Ándalus (Curso 2024/2025).

---

## 📄 Licencia

Proyecto desarrollado sobre el framework Laravel, software de código abierto bajo licencia [MIT](https://opensource.org/licenses/MIT).
