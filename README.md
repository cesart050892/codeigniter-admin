
# AdminLTE + Codeigniter 4

## Implentación
- Copiar en el archivo env y renombrarlo como .env
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