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
   - Muestra el codigo del ticket creado.

3. **`formulario.html`**:
   - Formulario básico para registrar eventos adversos.

4. **`index.php`**:
   - Página principal.

5. **`login.php`**:
   - Página de inicio de sesión.

6. **`pPpalCelia.php`**:
   - Vista principal personalizada para los admins.

7. **`resueltas.php`**:
   - Muestra tickets que ya han sido resueltos.

8. **`ticket.php`**:
   - Vista de los tickets por parte de los usuarios.

9. **`visuCelia.php`**:
   - Vista específica para el admin de un ticket.

---

## **Pasos para un funcionamiento con nuestro servidor funcionando**
1. **Para acceder a la vista de usuario**:
   - Copiar la siguiente URL y acceder : http://83.50.193.71:8080

2. **Para acceder a la vista de admin**:
   - Copiar la siguiente URL y acceder : http://83.50.193.71:8080/login
   - Las credenciales son
        - Usuario/Correo : celia@gmail.com
        - Contraseña : 123
---

## **Pasos en caso de servidor caido**
Para que nuestro prototipo funcione correctamente, debe estar la web ejecutandose en un servidor y tener una base de datos en ese mismo servidor (puede ser en localhost con XAMPP).

### **Requisitos de instalacion**
- **Programas externos**: XAMPP
- **Extension de VSCode**: LivePreview

1. **Abrir XAMPP**

2. **Iniciar los servicios de Apache y MySQL**

3. **Una vez iniciados, agregaremos nuestro proyecto al directorio de Apache**
    - Le damos a Explorer y buscamos la carpeta `htdocs`
    - Entramos al directorio y borramos todo lo que se encuentra dentro
    - Descomprimimos el zip del proyecto y dejamos todos los ficheros aqui

4. **Ahora que ya tenemos nuestra web en el servidor Apache toca la parte de la BBDD MySQL**:
    - Le damos a Shell.
    - Ejecutamos el comando (por defecto no hace falta contraseña)
        ```bash
        mysql -u root
        ```
    - Copiamos todo lo que esta en el `esquema.sql` que esta en nuestro proyecto y lo pegamos
    - Cuando termine ya tendremos el servidor web y la base de datos completamente funcional

### **Funcionamiento**

 **Para acceder a la vista de usuario**:
   - Copiar la siguiente URL y acceder : http://localhost
5. **Para acceder a la vista de admin**:
   - Copiar la siguiente URL y acceder : http://localhost/login
   - Las credenciales son
        - Usuario/Correo : celia@gmail.com
        - Contraseña : 123
---