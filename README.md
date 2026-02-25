# ERP Dashboard Comercial 2026

Sistema de seguimiento comercial con funcionalidades avanzadas para analistas.

## ✅ Características Implementadas

- **PHP** - Backend robusto y seguro
- **Sesión Real** - Autenticación segura con sesiones PHP
- **Filtro por Analista** - Cada usuario ve solo sus datos
- **Filtro por Mes** - Selector dinámico de meses
- **Comparativo vs Mes Anterior** - Análisis de tendencias
- **KPIs Dinámicos** - Métricas actualizadas en tiempo real
- **Gráfica Empresarial** - Visualización con Chart.js
- **Meta con Barra de Progreso** - Seguimiento de objetivos
- **Estilo ERP 2026** - Diseño moderno y profesional

## 🚀 Instalación y Uso

1. **Configurar Base de Datos:**
   - El sistema usa PDO para conexión a MySQL
   - Configura tus credenciales en `conexion.php`

2. **Iniciar Sesión:**
   - Ve a `login.php`
   - Ingresa nombre y apellido del analista

3. **Cargar Datos:**
   - En el dashboard, selecciona un archivo Excel
   - El archivo debe tener las columnas: `Nombre`, `Apellido`, `Fecha`, `Estado`

4. **Estados Soportados:**
   - `Oportunidad` - Lead convertido en oportunidad
   - `Cierre` - Oportunidad cerrada exitosamente
   - Otros valores se cuentan como leads básicos

## 📊 Funcionalidades

### Dashboard Interactivo
- **KPIs en Tiempo Real:** Leads, Oportunidades, Cierres, Conversión
- **Tendencias:** Comparación con mes anterior
- **Gráficas:** Barras animadas con Chart.js
- **Metas:** Barra de progreso con colores dinámicos

### Filtros Avanzados
- **Por Analista:** Automático según sesión activa
- **Por Mes:** Selector dinámico de meses
- **Por Año:** Soporte multi-anual

### Seguridad
- Sesiones PHP seguras
- Validación de archivos Excel
- Filtrado de datos por usuario

## 🎨 Diseño ERP 2026

- **Gradientes Modernos:** Colores vibrantes y profesionales
- **Animaciones Suaves:** Transiciones CSS fluidas
- **Responsive:** Adaptable a móviles y tablets
- **Iconos Emojis:** Interfaz intuitiva y moderna

## 📁 Estructura de Archivos

```
├── dashboard.php      # Dashboard principal
├── login.php          # Inicio de sesión
├── logout.php         # Cierre de sesión
├── register.php       # Registro de usuarios
├── conexion.php       # Configuración BD
├── index.html         # Página de bienvenida
├── script.js          # Lógica adicional
├── data.js           # Datos de ejemplo
└── style.css         # Estilos adicionales
```

## 🔧 Tecnologías Usadas

- **Backend:** PHP 7.4+
- **Frontend:** HTML5, CSS3, JavaScript ES6+
- **Base de Datos:** MySQL/MariaDB
- **Librerías:** Chart.js, XLSX (SheetJS)
- **Estilos:** CSS Grid, Flexbox, Gradientes

## 📈 Próximas Mejoras

- [ ] Exportar reportes PDF
- [ ] Notificaciones push
- [ ] Dashboard administrador
- [ ] API REST para integraciones
- [ ] Análisis predictivo con IA