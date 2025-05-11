# Singularity Health

## Descripción
**Singularity Health** es una aplicación de registro de usuarios desarrollada en PHP, utilizando **GraphQL** como API para manejar la persistencia de datos. El sistema permite registrar usuarios, gestionar información de contacto, documentos de identidad y realizar validaciones para evitar duplicados en el sistema.

## Características
- **API GraphQL** para gestionar usuarios.
- **Validación de usuarios duplicados** por correo, nombre de usuario y documento de identidad.
- **Formulario de registro** para ingresar detalles como nombre, dirección, teléfono, etc.
- **Gestión de documentos de identidad**, con validación de tipo y lugar de expedición.
- **Persistencia de datos** en base de datos MySQL.

## Funcionamiento

### Registro de Usuario
1. El usuario se registra proporcionando los siguientes detalles:
   - **Nombre**: Nombre completo del usuario.
   - **Apellido**: Apellido del usuario.
   - **Nombre de usuario**: Identificador único.
   - **Contraseña**: Contraseña segura.
   - **Email**: Correo electrónico del usuario.
   - **Número de documento**: Documento de identidad (por ejemplo, cédula o pasaporte).
   - **Dirección**: Dirección física.
   - **Teléfono y celular**: Información de contacto.
   - **Nombre y teléfono de emergencia**: Datos de contacto en caso de emergencia.
   - **Lugar y fecha de expedición del documento**: Datos relacionados con el lugar de emisión del documento de identidad.

2. **Validación de datos**: Antes de que la información se guarde en la base de datos, el sistema verifica si el correo electrónico, nombre de usuario o número de documento ya existen para evitar duplicados.

3. **Persistencia**: Una vez que la validación sea exitosa, los datos se almacenan en la base de datos MySQL a través de la conexión configurada en `config.php`.

### API GraphQL
La API GraphQL permite realizar consultas y mutaciones sobre los datos de los usuarios. Por ejemplo:
- **Consultas**: Obtener información de los usuarios existentes.
- **Mutaciones**: Registrar un nuevo usuario, actualizar la información de un usuario, etc.

Ejemplo de una mutación para registrar un nuevo usuario:

```graphql
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
