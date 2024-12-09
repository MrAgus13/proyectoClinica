# **Sistema de Registro de Tickets - Clínica Médica**

## **Descripción del Proyecto**
Este sistema es una plataforma web que permite a una clínica médica registrar y gestionar tickets relacionados con eventos adversos. Incluye funcionalidades de autenticación, creación y visualización de tickets, y gestión de datos sensibles. Además, proporciona vistas separadas para usuarios y administradores.

---
## **Tecnologías Utilizadas**
- **Backend**: PHP
- **Base de datos**: MySQL
- **Servidor web**: Apache
- **Frontend**: HTML, CSS, Bootstrap, JavaScript
- **Control de versiones**: GitHub

---

## **Estructura del Proyecto**

### **Carpetas Principales**
1. **`css`**:
   - Archivos personalizados de estilos CSS que complementan la interfaz.

2. **`img`**:
   - Recursos gráficos utilizados en el proyecto, como logotipos e iconos.

3. **`js`**:
   - **`form.js`**: Maneja la validación de formularios.
   - **`home.js`**: Funciones generales de la página principal.
   - **`tickPruebas.js` y `tickPruebasGenerar.js`**: Scripts específicos para la vista de tickets por parte del usuario.
   - **`visuCelia.js`**: Script asociado a la vista específica del admin.

4. **`php`**:
   - **`autenticacion.php`**: Inicio de sesión.
   - **`cerrar_tiquet.php`**: Cerrar los tiquets.
   - **`cerrar-sesion.php`**: Cerrar la sesión del usuario.
   - **`enviar-comentarios.php`**: Creación y envio del comentario hecho por el Admin.
   - **`enviar-comentariosUsuario.php`**:  Creación y envio del comentario hecho por el Usuario del tiquet.
   - **`enviar-datosAnom.php`**: Generar el tiquet de forma anonima.
   - **`enviar-datosConf.php`**: Generar el tiquet de forma Confidencial (indicando nombre y correo).

5. **`uploads`**:
   - Carpeta para subir archivos relacionados con los tickets (si aplica).

---

### **Archivos Clave**
1. **`.htaccess`**:
   - Configuración del servidor para manejo de rutas amigables y seguridad.

2. **`codTicket.php`**:
   - Genera códigos únicos para cada ticket.

3. **`formulario.html`**:
   - Formulario básico para registrar eventos adversos.

4. **`index.php`**:
   - Página principal del sistema.

5. **`login.php`**:
   - Página de inicio de sesión.

6. **`pPpalCelia.php`**:
   - Vista principal personalizada para los admins.

7. **`resueltas.php`**:
   - Muestra tickets que ya han sido resueltos.

8. **`ticket.php`**:
   - Página principal de creación y gestión de tickets.

9. **`visuCelia.php`**:
   - Vista específica para Celia.

---

### **Pasos para un funcionamiento correcto**
1. **Para acceder a la vista de usuario**:
   - Copiar la siguiente URL y acceder : http://83.50.193.71:8080

2. **Para acceder a la vista de admin**:
   - Copiar la siguiente URL y acceder : http://83.50.193.71:8080/login
   - Las credenciales son
        - Usuario/Correo : celia@gmail.com
        - Contraseña : 123
---