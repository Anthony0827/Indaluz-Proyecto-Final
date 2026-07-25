-- ══════════════════════════════════════════════════════════════════
-- Indaluz — dataset DEMO (idempotente).
-- Se ejecuta al inicializar la BD y en cada `php artisan demo:reset`.
-- Restaura las cuentas demo, los productos de prueba y limpia lo demás,
-- de modo que el visitante puede trastear y todo vuelve a su sitio.
-- Contraseña de ambas cuentas: "password"
-- ══════════════════════════════════════════════════════════════════
SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE detalle_pedido;
TRUNCATE TABLE pedidos;
TRUNCATE TABLE `reseñas`;
TRUNCATE TABLE reportes;
TRUNCATE TABLE verificaciones;
TRUNCATE TABLE password_resets;
TRUNCATE TABLE productos;
TRUNCATE TABLE usuarios;

-- ── Cuentas demo ──────────────────────────────────────────────────
INSERT INTO usuarios
  (id_usuario, nombre, apellido, correo, `contraseña`, direccion, codigo_postal,
   municipio, provincia, rol, telefono, nombre_empresa, descripcion_publica,
   anos_experiencia, certificaciones, metodos_cultivo, horario_atencion,
   foto_perfil, foto_portada, verificado)
VALUES
  (1, 'Huerta', 'del Sol', 'agricultor@indaluz.com',
   '$2y$10$NnmhTcBfDWaWV.xPHZ4nI.wqopkahJaOw1.XWIYlD8c6v5qHj7qQW',
   'Paraje Las Norias', '04710', 'El Ejido', 'Almería', 'agricultor',
   '650123456', 'Huerta del Sol',
   'Explotación familiar en El Ejido especializada en hortalizas de invernadero y fruta de temporada. Cultivo responsable y producto de proximidad.',
   12, 'Producción Integrada · GlobalG.A.P.', 'Invernadero y aire libre · riego por goteo',
   'Lun a Vie 8:00-18:00', NULL, NULL, 1),
  (2, 'Cliente', 'Demo', 'cliente@indaluz.com',
   '$2y$10$NnmhTcBfDWaWV.xPHZ4nI.wqopkahJaOw1.XWIYlD8c6v5qHj7qQW',
   'Calle Real 12', '04001', 'Almería', 'Almería', 'cliente',
   '650987654', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- ── Catálogo de prueba (del agricultor demo) ─────────────────────
INSERT INTO productos
  (id_producto, id_agricultor, nombre, descripcion, precio, imagen,
   tiempo_de_cosecha, cantidad_inventario, categoria, unidad_medida, estado)
VALUES
  (1, 1, 'Tomate Raf', 'Tomate Raf de Almería, sabor intenso y textura firme. Recolectado en su punto óptimo.', 3.20, 'productos/tomate.jpg', 'Todo el año', 120.00, 'verdura', 'kilogramo', 'activo'),
  (2, 1, 'Pimiento California', 'Pimiento rojo California de invernadero, carnoso y dulce. Ideal para asar o ensaladas.', 2.50, 'productos/pimiento.jpg', 'Todo el año', 90.00, 'verdura', 'kilogramo', 'activo'),
  (3, 1, 'Pepino', 'Pepino fresco de piel fina, crujiente y refrescante. Perfecto para gazpachos y ensaladas.', 1.80, 'productos/pepino.jpg', 'Todo el año', 75.00, 'verdura', 'kilogramo', 'activo'),
  (4, 1, 'Calabacín', 'Calabacín verde tierno, recolectado joven para máxima suavidad.', 1.60, 'productos/calabacin.jpg', 'Todo el año', 80.00, 'verdura', 'kilogramo', 'activo'),
  (5, 1, 'Berenjena', 'Berenjena morada brillante, firme y sin amargor. Excelente a la plancha o en pisto.', 2.10, 'productos/berenjena.jpg', 'Primavera-Otoño', 60.00, 'verdura', 'kilogramo', 'activo'),
  (6, 1, 'Lechuga Romana', 'Lechuga romana crujiente cultivada al aire libre. Hoja fresca y sabrosa.', 0.90, 'productos/lechuga.jpg', 'Todo el año', 50.00, 'verdura', 'unidad', 'activo'),
  (7, 1, 'Sandía', 'Sandía dulce y jugosa de temporada, de pulpa roja y pocas pepitas.', 4.50, 'productos/sandia.jpg', 'Verano', 40.00, 'fruta', 'unidad', 'activo'),
  (8, 1, 'Melón Piel de Sapo', 'Melón piel de sapo aromático y muy dulce, cultivado en secano.', 3.80, 'productos/melon.jpg', 'Verano', 45.00, 'fruta', 'unidad', 'activo'),
  (9, 1, 'Naranja de Mesa', 'Naranja de mesa jugosa, equilibrio perfecto entre dulzor y acidez.', 1.40, 'productos/naranja.jpg', 'Invierno', 150.00, 'fruta', 'kilogramo', 'activo'),
  (10, 1, 'Fresas', 'Fresas de temporada, rojas y aromáticas, recolectadas a mano.', 3.50, 'productos/fresa.jpg', 'Primavera', 30.00, 'fruta', 'caja', 'activo');

SET FOREIGN_KEY_CHECKS = 1;
