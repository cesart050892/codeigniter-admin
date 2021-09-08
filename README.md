
# AdminLTE + Codeigniter 4
##### En el proyecto se hicieron uso de:
Filtros, Plantilla, Migraciones, Seeders, set404Override, Entidades.

Se esta desarollando la parte de actualización de usuario.

## Implentación
- Copiar en el archivo env y renombrarlo como .env
> Editar app.baseURL en .env con el nombre o direccion donde dejen el proyecto
```cmd
XAMPP
app.baseURL = 'http://localhost/admin-mvc'
```
- Crear una base de datos
- Agregar las credenciales de su base de datos en .env
> Ejecutar en la terminal para migrar todas las tablas
```cmd
php spark migrate
```
> Ejecutar en la terminal para agregar los datos de inicio
```cmd
php spark db:seed init
```
## Credenciales

Usuario: admin
Contraseña: admin

## Endpoints

| Name | Endpoint API |
| ------ | ------ |
| Login | /api/auth/login |
| Signup | /api/auth/signup |
| Logout | /api/v1/users/logout |