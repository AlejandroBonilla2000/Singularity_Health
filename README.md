Singularity Health
Descripción
Singularity Health es una aplicación de registro de usuarios desarrollada en PHP, utilizando GraphQL como API para manejar la persistencia de datos. El sistema permite registrar usuarios, gestionar información de contacto, documentos de identidad y realizar validaciones para evitar duplicados en el sistema.

Características
API GraphQL para gestionar usuarios.

Validación de usuarios duplicados por correo, nombre de usuario y documento de identidad.

Formulario de registro para ingresar detalles como nombre, dirección, teléfono, etc.

Gestión de documentos de identidad, con validación de tipo y lugar de expedición.

Persistencia de datos en base de datos MySQL.

Funcionamiento
Registro de Usuario
El usuario se registra proporcionando los siguientes detalles:

Nombre: Nombre completo del usuario.

Apellido: Apellido del usuario.

Nombre de usuario: Identificador único.

Contraseña: Contraseña segura.

Email: Correo electrónico del usuario.

Número de documento: Documento de identidad (por ejemplo, cédula o pasaporte).

Dirección: Dirección física.

Teléfono y celular: Información de contacto.

Nombre y teléfono de emergencia: Datos de contacto en caso de emergencia.

Lugar y fecha de expedición del documento: Datos relacionados con el lugar de emisión del documento de identidad.

Validación de datos: Antes de que la información se guarde en la base de datos, el sistema verifica si el correo electrónico, nombre de usuario o número de documento ya existen para evitar duplicados.

Persistencia: Una vez que la validación sea exitosa, los datos se almacenan en la base de datos MySQL a través de la conexión configurada en config.php.

API GraphQL
La API GraphQL permite realizar consultas y mutaciones sobre los datos de los usuarios. Por ejemplo:

Consultas: Obtener información de los usuarios existentes.

Mutaciones: Registrar un nuevo usuario, actualizar la información de un usuario, etc.

graphql
Copiar
Editar
mutation {
  registerUser(
    LastName: "Doe",
    Name: "John",
    username: "johndoe1232",
    password: "securepassword123",
    email: "johndoe@example.com",
    Document: "123456789",
    TypeDocumentID: 1,
    Address: "123 Main St",
    CountryID: 1,
    Phone: "+1234567890",
    City: "New York",
    CelPhone: "+0987654321",
    EmergencyName: "Jane Doe",
    EmergencyPhone: "+1122334455",
    DocumentPlaceExpedition: "City Hall",
    DocumentDateExpedition: "2025-05-01"
  )
}
Este ejemplo es una mutación que registra un nuevo usuario en el sistema.

Configuración de la Base de Datos
Para configurar la base de datos, modifica el archivo config.php con los datos de tu servidor MySQL:

php
Copiar
Editar
<?php
// Configuración de la base de datos
$host = 'localhost';     // Cambiar según tu configuración
$dbname = 'singularity_health'; // Cambiar según tu base de datos
$username = 'root';   // Cambiar por tu usuario de la base de datos
$password = ''; // Cambiar por tu contraseña de la base de datos

try {
    // Conexión a la base de datos usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Establecer el modo de error a excepción para facilitar la depuración
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si hay un error en la conexión, muestra el mensaje
    echo "Error de conexión: " . $e->getMessage();
    exit;
}
Asegúrate de cambiar los valores de $host, $dbname, $username y $password a los valores correspondientes de tu servidor MySQL.

Requisitos
PHP 7.4 o superior.

Servidor MySQL.

Extensión PDO para PHP.

GraphQL server o implementación de API compatible con GraphQL.

Instalación
Clona o descarga el repositorio:

bash
Copiar
Editar
git clone https://github.com/AlejandroBonilla2000/Singularity_Health.git
Configura la base de datos:

Crea una base de datos MySQL llamada singularity_health (o usa el nombre que prefieras).

Asegúrate de que las tablas necesarias estén creadas y que se puedan insertar datos de usuario.

Instala dependencias:

Si usas Composer para administrar dependencias, instala cualquier paquete adicional si es necesario.

Inicia el servidor:

Usa el servidor PHP embebido para probar la aplicación de forma local:

bash
Copiar
Editar
php -S localhost:8000
Contribuciones
Si deseas contribuir, siéntete libre de enviar un pull request. Asegúrate de seguir buenas prácticas de codificación y realiza pruebas antes de contribuir.
