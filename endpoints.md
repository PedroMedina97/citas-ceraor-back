# Documentación de Endpoints API

## Tabla de Contenidos
1. [Appointment](#appointment)
2. [CashCut](#cashcut)
3. [Catalog](#catalog)
4. [Category](#category)
5. [Department](#department)
6. [Especiality](#especiality)
7. [File](#file)
8. [Note](#note)
9. [Order](#order)
10. [Packet](#packet)
11. [Payment](#payment)
12. [Permission](#permission)
13. [Rol](#rol)
14. [RolPermission](#rolpermission)
15. [Service](#service)
16. [Subsidiary](#subsidiary)
17. [User](#user)

---

## Appointment

### GET

#### `/appointment/getall`
- **Descripción**: Obtiene todas las citas
- **Autorización**: Token requerido
- **Permisos**: `getall_appointment`
- **Respuesta exitosa**: 200
  ```json
  {
    "status": "success",
    "msg": "OK",
    "data": []
  }
  ```

#### `/appointment/getbybarcode/{barcode}`
- **Descripción**: Obtiene una cita por código de barras
- **Autorización**: Token requerido
- **Permisos**: `get_appointment`
- **Parámetros**: 
  - `barcode` (URL): Código de barras de la cita
- **Respuesta exitosa**: 200

#### `/appointment/getbyid/{id}`
- **Descripción**: Obtiene una cita por ID
- **Autorización**: Token requerido
- **Permisos**: `get_appointment`
- **Parámetros**: 
  - `id` (URL): ID de la cita
- **Respuesta exitosa**: 200

#### `/appointment/getbysubsidiary/{id}`
- **Descripción**: Obtiene citas por sucursal
- **Autorización**: Token requerido (comentado en el código)
- **Parámetros**: 
  - `id` (URL): ID de la sucursal
- **Respuesta exitosa**: 200

#### `/appointment/getdetailbyid/{id}`
- **Descripción**: Obtiene el detalle completo de una cita por ID
- **Autorización**: Token requerido
- **Permisos**: `get_appointment`
- **Parámetros**: 
  - `id` (URL): ID de la cita
- **Respuesta exitosa**: 200

#### `/appointment/getavaliables/{id_subsidiary}/{date}`
- **Descripción**: Obtiene horarios disponibles para citas en una sucursal
- **Autorización**: Token requerido
- **Permisos**: `get_appointment`
- **Parámetros**: 
  - `id_subsidiary` (URL): ID de la sucursal
  - `date` (URL): Fecha para consultar disponibilidad
- **Respuesta exitosa**: 200
- **Respuesta error**: 400 si faltan parámetros

### POST

#### `/appointment/setappointment`
- **Descripción**: Crea una nueva cita
- **Autorización**: Token requerido
- **Permisos**: `create_appointment`
- **Body**:
  ```json
  {
    "id_order": "string",
    "client": "string",
    "personal": "string",
    "id_subsidiary": "string",
    "service": "string",
    "appointment": "datetime",
    "end_appointment": "datetime",
    "color": "string"
  }
  ```
- **Respuesta exitosa**: 201

#### `/appointment/create`
- **Descripción**: Crea una cita (método genérico)
- **Autorización**: Token requerido
- **Permisos**: `create_appointment`
- **Respuesta exitosa**: 201

### PUT

#### `/appointment/update`
- **Descripción**: Actualiza una cita existente
- **Autorización**: Token requerido
- **Permisos**: `update_appointment`
- **Body**: Datos de la cita a actualizar
- **Respuesta exitosa**: 200

### DELETE

#### `/appointment/delete`
- **Descripción**: Elimina una cita
- **Autorización**: Token requerido
- **Permisos**: `delete_appointment`
- **Respuesta exitosa**: 200

---

## CashCut

### GET

#### `/cashcut/getall`
- **Descripción**: Obtiene todos los cortes de caja
- **Autorización**: Token requerido
- **Permisos**: `getall_cashcut`
- **Respuesta exitosa**: 200

#### `/cashcut/getbyid/{id}`
- **Descripción**: Obtiene un corte de caja por ID
- **Autorización**: Token requerido
- **Permisos**: `get_cashcut`
- **Parámetros**: 
  - `id` (URL): ID del corte de caja
- **Respuesta exitosa**: 200

#### `/cashcut/cashcut-gains/{month}`
- **Descripción**: Obtiene las ganancias del mes
- **Autorización**: Token requerido
- **Parámetros**: 
  - `month` (URL): Mes en formato YYYY-MM
- **Respuesta exitosa**: 200

#### `/cashcut/cashcut-payments/{id}`
- **Descripción**: Obtiene los pagos de un corte de caja específico
- **Autorización**: Token requerido
- **Parámetros**: 
  - `id` (URL): ID del corte de caja
- **Respuesta exitosa**: 200

#### `/cashcut/cashcut-payments-excel/{id}`
- **Descripción**: Obtiene los pagos de un corte de caja en formato Excel
- **Autorización**: Token requerido
- **Parámetros**: 
  - `id` (URL): ID del corte de caja
- **Respuesta exitosa**: 200

#### `/cashcut/cashcut-export-range/{dates}`
- **Descripción**: Exporta cortes de caja agrupados con pagos en un rango de fechas
- **Autorización**: Token requerido
- **Parámetros**: 
  - `dates` (URL): Rango de fechas
- **Respuesta**: Archivo para descarga

#### `/cashcut/cashcut-percent`
- **Descripción**: Obtiene el porcentaje por sucursal
- **Autorización**: Token requerido
- **Respuesta exitosa**: 200

#### `/cashcut/cashcut-top-services`
- **Descripción**: Obtiene los servicios más solicitados
- **Autorización**: Token requerido
- **Respuesta exitosa**: 200

#### `/cashcut/data-home`
- **Descripción**: Obtiene datos para el dashboard principal
- **Autorización**: Token requerido
- **Respuesta exitosa**: 200

#### `/cashcut/gains-week`
- **Descripción**: Obtiene las ganancias de la semana
- **Autorización**: Token requerido
- **Respuesta exitosa**: 200

### POST

#### `/cashcut/create`
- **Descripción**: Crea un nuevo corte de caja
- **Autorización**: Token requerido
- **Permisos**: `create_cashcut`
- **Body**: Datos del corte de caja
- **Respuesta exitosa**: 201

#### `/cashcut/update-total`
- **Descripción**: Actualiza el total de un corte de caja
- **Autorización**: Token requerido
- **Permisos**: `create_cashcut`
- **Body**: Datos del total a actualizar
- **Respuesta exitosa**: 201

---

## Catalog

### GET

#### `/catalog/getall/{table}`
- **Descripción**: Obtiene el catálogo de una tabla específica
- **Autorización**: Token requerido (excepto para getsubsidiaries)
- **Parámetros**: 
  - `table` (URL): Nombre de la tabla del catálogo
- **Respuesta exitosa**: 200

#### `/catalog/getdoctors`
- **Descripción**: Obtiene el catálogo de doctores
- **Autorización**: Token requerido
- **Respuesta exitosa**: 200

#### `/catalog/getsubsidiaries`
- **Descripción**: Obtiene el catálogo de sucursales (sin autenticación)
- **Autorización**: No requerida
- **Respuesta exitosa**: 200

#### `/catalog/getclients`
- **Descripción**: Obtiene el catálogo de clientes
- **Autorización**: Token requerido
- **Respuesta exitosa**: 200

---

## Category

### GET

#### `/category/getall`
- **Descripción**: Obtiene todas las categorías
- **Autorización**: Token requerido
- **Permisos**: `getall_service`
- **Respuesta exitosa**: 200

#### `/category/getbyid/{id}`
- **Descripción**: Obtiene una categoría por ID
- **Autorización**: Token requerido
- **Permisos**: `get_service`
- **Parámetros**: 
  - `id` (URL): ID de la categoría
- **Respuesta exitosa**: 200

### POST

#### `/category/create`
- **Descripción**: Crea una nueva categoría
- **Autorización**: Token requerido
- **Permisos**: `create_service`
- **Body**: Datos de la categoría
- **Respuesta exitosa**: 201

### PUT

#### `/category/update`
- **Descripción**: Actualiza una categoría existente
- **Autorización**: Token requerido
- **Permisos**: `update_service`
- **Body**: Datos de la categoría a actualizar
- **Respuesta exitosa**: 200

### DELETE

#### `/category/delete`
- **Descripción**: Elimina una categoría
- **Autorización**: Token requerido
- **Permisos**: `delete_service`
- **Respuesta exitosa**: 200

---

## Department

### GET

#### `/department/departmentsByClinicId/{id}`
- **Descripción**: Obtiene departamentos por ID de clínica
- **Autorización**: Token requerido
- **Parámetros**: 
  - `id` (URL): ID de la clínica
- **Respuesta exitosa**: 200

#### `/department/*` (rutas por defecto)
- **Descripción**: Operaciones CRUD estándar de departamentos
- **Autorización**: Token requerido
- **Restricciones**: Usuario tipo 5 no puede crear, actualizar o eliminar

### POST

#### `/department/create`
- **Descripción**: Crea un nuevo departamento
- **Autorización**: Token requerido
- **Restricciones**: Usuario tipo 5 no autorizado

### PUT

#### `/department/update`
- **Descripción**: Actualiza un departamento
- **Autorización**: Token requerido
- **Restricciones**: Usuario tipo 5 no autorizado

### DELETE

#### `/department/delete`
- **Descripción**: Elimina un departamento
- **Autorización**: Token requerido
- **Restricciones**: Usuario tipo 4 y 5 no autorizados

---

## Especiality

### GET

#### `/especiality/*` (rutas por defecto)
- **Descripción**: Obtiene especialidades
- **Autorización**: No validada actualmente (código comentado)

### POST

#### `/especiality/create`
- **Descripción**: Crea una nueva especialidad
- **Autorización**: No validada actualmente

### PUT

#### `/especiality/update`
- **Descripción**: Actualiza una especialidad
- **Autorización**: No validada actualmente

### DELETE

#### `/especiality/delete`
- **Descripción**: Elimina una especialidad
- **Autorización**: No validada actualmente

---

## File

### GET

#### `/file/getfile/list`
- **Descripción**: Lista todos los archivos en el directorio docs/
- **Autorización**: No especificada
- **Respuesta**: 
  ```json
  {
    "files": ["archivo1.pdf", "archivo2.pdf"]
  }
  ```

#### `/file/getfile/read/{filename}`
- **Descripción**: Lee el contenido de un archivo
- **Autorización**: No especificada
- **Parámetros**: 
  - `filename` (URL): Nombre del archivo a leer
- **Respuesta**: Contenido del archivo

#### `/file/getfile/download/{filename}`
- **Descripción**: Descarga un archivo PDF y genera el documento
- **Autorización**: No especificada
- **Parámetros**: 
  - `filename` (URL): Nombre del archivo a descargar
- **Respuesta**: Archivo PDF

#### `/file/getfile/downloadbyid/{id}`
- **Descripción**: Descarga un archivo PDF por ID de orden
- **Autorización**: No especificada
- **Parámetros**: 
  - `id` (URL): ID de la orden
- **Respuesta**: Archivo PDF

---

## Note

### GET

#### `/note/getall`
- **Descripción**: Obtiene todas las notas
- **Autorización**: Token requerido
- **Permisos**: `getall_order`
- **Respuesta exitosa**: 200

#### `/note/getbyid/{id}`
- **Descripción**: Obtiene una nota por ID
- **Autorización**: Token requerido
- **Permisos**: `get_order`
- **Parámetros**: 
  - `id` (URL): ID de la nota
- **Respuesta exitosa**: 200

### POST

#### `/note/create`
- **Descripción**: Crea una nueva nota
- **Autorización**: Token requerido
- **Permisos**: `create_order`
- **Body**: Datos de la nota
- **Respuesta exitosa**: 201

---

## Order

### GET

#### `/order/getall`
- **Descripción**: Obtiene todas las órdenes activas
- **Autorización**: Token requerido
- **Permisos**: `getall_order`
- **Respuesta exitosa**: 200

#### `/order/getbyid/{id}`
- **Descripción**: Obtiene una orden por ID
- **Autorización**: Token requerido
- **Permisos**: `get_order`
- **Parámetros**: 
  - `id` (URL): ID de la orden
- **Respuesta exitosa**: 200

#### `/order/getticket/{id}`
- **Descripción**: Genera el ticket de una orden
- **Autorización**: Token requerido
- **Permisos**: `update_order`
- **Parámetros**: 
  - `id` (URL): ID de la orden
- **Respuesta exitosa**: 200

#### `/order/getbyappointment/{id}`
- **Descripción**: Obtiene órdenes por ID de cita
- **Autorización**: Token requerido
- **Permisos**: `get_order`
- **Parámetros**: 
  - `id` (URL): ID de la cita
- **Respuesta exitosa**: 200

#### `/order/generatedocument/{id}/{disposition?}`
- **Descripción**: Genera y descarga el documento PDF de una orden
- **Autorización**: No requerida
- **Parámetros**: 
  - `id` (URL): ID de la orden
  - `disposition` (URL, opcional): 'download' para descargar, 'inline' para visualizar
- **Respuesta**: Archivo PDF

#### `/order/generateticket/{id}/{disposition?}`
- **Descripción**: Genera y descarga el ticket PDF de una orden
- **Autorización**: No requerida
- **Parámetros**: 
  - `id` (URL): ID de la orden
  - `disposition` (URL, opcional): 'download' para descargar, 'inline' para visualizar
- **Respuesta**: Archivo PDF

#### `/order/generatedocumentbycode/{code}/{disposition?}`
- **Descripción**: Genera documento PDF por código de cita
- **Autorización**: No requerida
- **Parámetros**: 
  - `code` (URL): Código de la cita
  - `disposition` (URL, opcional): 'download' o 'inline'
- **Respuesta**: Archivo PDF

#### `/order/generatedocumentbyorderid/{id}/{disposition?}`
- **Descripción**: Genera documento PDF por ID de orden
- **Autorización**: No requerida
- **Parámetros**: 
  - `id` (URL): ID de la orden
  - `disposition` (URL, opcional): 'download' o 'inline'
- **Respuesta**: Archivo PDF

#### `/order/getbydoctor/{name}`
- **Descripción**: Obtiene órdenes por nombre de doctor
- **Autorización**: Token requerido
- **Permisos**: `get_order`
- **Parámetros**: 
  - `name` (URL): Nombre del doctor
- **Respuesta exitosa**: 200

#### `/order/getbystatus/{status}`
- **Descripción**: Obtiene órdenes por estado
- **Autorización**: Token requerido
- **Permisos**: `get_order`
- **Parámetros**: 
  - `status` (URL): Estado de la orden
- **Respuesta exitosa**: 200

#### `/order/getbymethod/{method}`
- **Descripción**: Obtiene órdenes por método de pago
- **Autorización**: Token requerido
- **Permisos**: `get_order`
- **Parámetros**: 
  - `method` (URL): Método de pago
- **Respuesta exitosa**: 200

#### `/order/getdetailsbyid/{id}`
- **Descripción**: Obtiene detalles completos de una orden
- **Autorización**: Token requerido
- **Permisos**: `get_order`
- **Parámetros**: 
  - `id` (URL): ID de la orden
- **Respuesta exitosa**: 200

#### `/order/getformorder/{id}`
- **Descripción**: Obtiene el formulario de una orden
- **Autorización**: No requerida
- **Parámetros**: 
  - `id` (URL): ID de la orden
- **Respuesta exitosa**: 200

#### `/order/getbyticketcode/{ticketCode}`
- **Descripción**: Obtiene orden por código de ticket
- **Autorización**: Token requerido
- **Permisos**: `get_order`
- **Parámetros**: 
  - `ticketCode` (URL): Código del ticket
- **Respuesta exitosa**: 200

#### `/order/getwithticketcode`
- **Descripción**: Obtiene todas las órdenes con código de ticket
- **Autorización**: Token requerido
- **Permisos**: `get_order`
- **Respuesta exitosa**: 200

### POST

#### `/order/create`
- **Descripción**: Crea una nueva orden
- **Autorización**: Token requerido
- **Permisos**: `create_order`
- **Body**: Datos de la orden
- **Respuesta exitosa**: 201

### PUT

#### `/order/update`
- **Descripción**: Actualiza una orden existente
- **Autorización**: Token requerido
- **Permisos**: `update_order`
- **Body**: Datos de la orden a actualizar
- **Respuesta exitosa**: 200

#### `/order/updatestatus/{id}`
- **Descripción**: Actualiza el estado de una orden
- **Autorización**: Token requerido
- **Permisos**: `update_order`
- **Parámetros**: 
  - `id` (URL): ID de la orden
- **Body**:
  ```json
  {
    "status": "string"
  }
  ```
- **Respuesta exitosa**: 200

#### `/order/updatemethod/{id}`
- **Descripción**: Actualiza el método de pago de una orden
- **Autorización**: Token requerido
- **Permisos**: `update_order`
- **Parámetros**: 
  - `id` (URL): ID de la orden
- **Body**:
  ```json
  {
    "method": "string"
  }
  ```
- **Respuesta exitosa**: 200

### DELETE

#### `/order/delete`
- **Descripción**: Elimina una orden
- **Autorización**: Token requerido
- **Permisos**: `delete_order`
- **Respuesta exitosa**: 200

---

## Packet

### GET

#### `/packet/getall`
- **Descripción**: Obtiene todos los paquetes
- **Autorización**: Token requerido
- **Permisos**: `getall_service`
- **Respuesta exitosa**: 200

#### `/packet/getbypacketid/{id}`
- **Descripción**: Obtiene servicios de un paquete por ID
- **Autorización**: Token requerido
- **Permisos**: `get_service`
- **Parámetros**: 
  - `id` (URL): ID del paquete
- **Respuesta exitosa**: 200

#### `/packet/getbyid/{id}`
- **Descripción**: Obtiene un paquete por ID
- **Autorización**: Token requerido
- **Permisos**: `get_service`
- **Parámetros**: 
  - `id` (URL): ID del paquete
- **Respuesta exitosa**: 200

### POST

#### `/packet/create`
- **Descripción**: Crea un nuevo paquete
- **Autorización**: Token requerido
- **Permisos**: `create_service`
- **Body**: Datos del paquete
- **Respuesta exitosa**: 201

### PUT

#### `/packet/update`
- **Descripción**: Actualiza un paquete existente
- **Autorización**: Token requerido
- **Permisos**: `update_service`
- **Body**: Datos del paquete a actualizar
- **Respuesta exitosa**: 200

#### `/packet/setservices/{id}`
- **Descripción**: Asigna servicios a un paquete
- **Autorización**: Token requerido
- **Permisos**: `update_service`
- **Parámetros**: 
  - `id` (URL): ID del paquete
- **Body**:
  ```json
  {
    "services": [
      { "id_service": "string" },
      "string"
    ]
  }
  ```
- **Respuesta exitosa**: 200

### DELETE

#### `/packet/delete`
- **Descripción**: Elimina un paquete
- **Autorización**: Token requerido
- **Permisos**: `delete_service`
- **Respuesta exitosa**: 200

---

## Payment

### GET

#### `/payment/getall`
- **Descripción**: Obtiene todos los pagos
- **Autorización**: Token requerido
- **Permisos**: `getall_cashcut`
- **Respuesta exitosa**: 200

#### `/payment/generatePaymentTicket/{id}/{disposition?}`
- **Descripción**: Genera el ticket PDF de un pago
- **Autorización**: Token requerido
- **Parámetros**: 
  - `id` (URL): ID del pago
  - `disposition` (URL, opcional): 'download' o 'inline'
- **Respuesta**: Archivo PDF

### POST

#### `/payment/create`
- **Descripción**: Crea un nuevo pago
- **Autorización**: Token requerido
- **Permisos**: `create_cashcut`
- **Body**: Datos del pago
- **Respuesta exitosa**: 201

---

## Permission

### GET

#### `/permission/getall`
- **Descripción**: Obtiene todos los permisos
- **Autorización**: Token requerido
- **Permisos**: `getall_rolpermission`
- **Respuesta exitosa**: 200

#### `/permission/getbyid/{id}`
- **Descripción**: Obtiene un permiso por ID
- **Autorización**: Token requerido
- **Permisos**: `get_rolpermission`
- **Parámetros**: 
  - `id` (URL): ID del permiso
- **Respuesta exitosa**: 200

### POST

#### `/permission/create`
- **Descripción**: Crea un nuevo permiso
- **Autorización**: Token requerido
- **Permisos**: `create_rolpermission`
- **Body**: Datos del permiso
- **Respuesta exitosa**: 201

### PUT

#### `/permission/update`
- **Descripción**: Actualiza un permiso existente
- **Autorización**: Token requerido
- **Permisos**: `update_rolpermission`
- **Body**: Datos del permiso a actualizar
- **Respuesta exitosa**: 200

### DELETE

#### `/permission/delete`
- **Descripción**: Elimina un permiso
- **Autorización**: Token requerido
- **Permisos**: `delete_permission`
- **Respuesta exitosa**: 200

---

## Rol

### GET

#### `/rol/getall`
- **Descripción**: Obtiene todos los roles
- **Autorización**: Token requerido
- **Permisos**: `getall_rolpermission`
- **Respuesta exitosa**: 200

#### `/rol/getbyid/{id}`
- **Descripción**: Obtiene un rol por ID
- **Autorización**: Token requerido
- **Permisos**: `get_rolpermission`
- **Parámetros**: 
  - `id` (URL): ID del rol
- **Respuesta exitosa**: 200

### POST

#### `/rol/create`
- **Descripción**: Crea un nuevo rol
- **Autorización**: Token requerido
- **Permisos**: `create_rolpermission`
- **Body**: Datos del rol
- **Respuesta exitosa**: 201

### PUT

#### `/rol/update`
- **Descripción**: Actualiza un rol existente
- **Autorización**: Token requerido
- **Permisos**: `update_rolpermission`
- **Body**: Datos del rol a actualizar
- **Respuesta exitosa**: 200

### DELETE

#### `/rol/delete`
- **Descripción**: Elimina un rol
- **Autorización**: Token requerido
- **Permisos**: `delete_rolpermission`
- **Respuesta exitosa**: 200

---

## RolPermission

### GET

#### `/rolpermission/getpermissionsbyrol/{id}`
- **Descripción**: Obtiene los permisos de un rol específico
- **Autorización**: Token requerido
- **Permisos**: `get_rolpermission`
- **Parámetros**: 
  - `id` (URL): ID del rol
- **Respuesta exitosa**: 200

### POST

#### `/rolpermission/create`
- **Descripción**: Crea una nueva relación rol-permiso
- **Autorización**: Token requerido
- **Permisos**: `create_rolpermission`
- **Body**: Datos de la relación rol-permiso
- **Respuesta exitosa**: 201

#### `/rolpermission/updatepermissions`
- **Descripción**: Actualiza todos los permisos de un rol
- **Autorización**: Token requerido
- **Permisos**: `update_rolpermission`
- **Body**:
  ```json
  {
    "id_rol": "string",
    "permissions": [
      {
        "id_permission": "string",
        "id_rol": "string"
      }
    ]
  }
  ```
- **Respuesta exitosa**: 200
- **Nota**: Elimina los permisos actuales del rol y los reemplaza con los nuevos

### DELETE

#### `/rolpermission/delete`
- **Descripción**: Elimina una relación rol-permiso
- **Autorización**: Token requerido
- **Permisos**: `delete_rolpermission`
- **Respuesta exitosa**: 200

---

## Service

### GET

#### `/service/getall`
- **Descripción**: Obtiene todos los servicios
- **Autorización**: Token requerido
- **Permisos**: `getall_service`
- **Respuesta exitosa**: 200

#### `/service/getbyid/{id}`
- **Descripción**: Obtiene un servicio por ID
- **Autorización**: Token requerido
- **Permisos**: `get_service`
- **Parámetros**: 
  - `id` (URL): ID del servicio
- **Respuesta exitosa**: 200

#### `/service/getbysubsidiary/{id}`
- **Descripción**: Obtiene servicios por sucursal
- **Autorización**: Token requerido
- **Permisos**: `get_service`
- **Parámetros**: 
  - `id` (URL): ID de la sucursal
- **Respuesta exitosa**: 200

### POST

#### `/service/create`
- **Descripción**: Crea un nuevo servicio
- **Autorización**: Token requerido
- **Permisos**: `create_service`
- **Body**: Datos del servicio
- **Respuesta exitosa**: 201

### PUT

#### `/service/update`
- **Descripción**: Actualiza un servicio existente
- **Autorización**: Token requerido
- **Permisos**: `update_service`
- **Body**: Datos del servicio a actualizar
- **Respuesta exitosa**: 200

### DELETE

#### `/service/delete`
- **Descripción**: Elimina un servicio
- **Autorización**: Token requerido
- **Permisos**: `delete_service`
- **Respuesta exitosa**: 200

---

## Subsidiary

### GET

#### `/subsidiary/getall`
- **Descripción**: Obtiene todas las sucursales
- **Autorización**: Token requerido
- **Permisos**: `getall_subsidiary`
- **Respuesta exitosa**: 200

#### `/subsidiary/getbyid/{id}`
- **Descripción**: Obtiene una sucursal por ID
- **Autorización**: Token requerido
- **Permisos**: `get_subsidiary`
- **Parámetros**: 
  - `id` (URL): ID de la sucursal
- **Respuesta exitosa**: 200

#### `/subsidiary/getservices/{id}`
- **Descripción**: Obtiene los servicios de una sucursal
- **Autorización**: Token requerido
- **Permisos**: `get_subsidiary`
- **Parámetros**: 
  - `id` (URL): ID de la sucursal
- **Respuesta exitosa**: 200

#### `/subsidiary/getpackets/{id}`
- **Descripción**: Obtiene los paquetes de una sucursal
- **Autorización**: Token requerido
- **Permisos**: `get_subsidiary`
- **Parámetros**: 
  - `id` (URL): ID de la sucursal
- **Respuesta exitosa**: 200

#### `/subsidiary/getallservices`
- **Descripción**: Obtiene todos los servicios de todas las sucursales
- **Autorización**: Token requerido
- **Permisos**: `get_subsidiary` o `getall_service`
- **Respuesta exitosa**: 200

### POST

#### `/subsidiary/create`
- **Descripción**: Crea una nueva sucursal
- **Autorización**: Token requerido
- **Permisos**: `create_subsidiary`
- **Body**: Datos de la sucursal
- **Respuesta exitosa**: 201

### PUT

#### `/subsidiary/update`
- **Descripción**: Actualiza una sucursal existente
- **Autorización**: Token requerido
- **Permisos**: `update_subsidiary`
- **Body**: Datos de la sucursal a actualizar
- **Respuesta exitosa**: 200

#### `/subsidiary/setservices/{id}`
- **Descripción**: Asigna servicios a una sucursal con sus precios
- **Autorización**: Token requerido
- **Permisos**: `update_subsidiary`
- **Parámetros**: 
  - `id` (URL): ID de la sucursal
- **Body**:
  ```json
  {
    "services": [
      {
        "id_service": "string",
        "price": "number"
      }
    ]
  }
  ```
- **Respuesta exitosa**: 200

#### `/subsidiary/setpackets/{id}`
- **Descripción**: Asigna paquetes a una sucursal con sus precios
- **Autorización**: Token requerido
- **Permisos**: `update_subsidiary`
- **Parámetros**: 
  - `id` (URL): ID de la sucursal
- **Body**:
  ```json
  {
    "packets": [
      {
        "id_packet": "string",
        "price": "number"
      }
    ]
  }
  ```
- **Respuesta exitosa**: 200

### DELETE

#### `/subsidiary/delete`
- **Descripción**: Elimina una sucursal
- **Autorización**: Token requerido
- **Permisos**: `delete_subsidiary`
- **Respuesta exitosa**: 200

---

## User

### GET

#### `/user/getall`
- **Descripción**: Obtiene todos los usuarios
- **Autorización**: Token requerido
- **Permisos**: `getall_user`
- **Respuesta exitosa**: 200

#### `/user/getbyid/{id}`
- **Descripción**: Obtiene un usuario por ID
- **Autorización**: Token requerido
- **Permisos**: `get_user`
- **Parámetros**: 
  - `id` (URL): ID del usuario
- **Respuesta exitosa**: 200

#### `/user/getinstance/{id}`
- **Descripción**: Obtiene la instancia de un usuario por ID (sin validación de permisos)
- **Autorización**: Token requerido
- **Parámetros**: 
  - `id` (URL): ID del usuario
- **Respuesta exitosa**: 200

#### `/user/getbyidrol/{id}`
- **Descripción**: Obtiene usuarios por ID de rol
- **Autorización**: Token requerido
- **Permisos**: `get_user`
- **Parámetros**: 
  - `id` (URL): ID del rol
- **Respuesta exitosa**: 200

#### `/user/getmyusers/{id}`
- **Descripción**: Obtiene los usuarios hijos de un usuario padre
- **Autorización**: Token requerido
- **Permisos**: `get_user`
- **Parámetros**: 
  - `id` (URL): ID del usuario padre
- **Respuesta exitosa**: 200

### POST

#### `/user/login`
- **Descripción**: Autentica a un usuario y devuelve un token
- **Autorización**: No requerida
- **Body**:
  ```json
  {
    "email": "string",
    "password": "string"
  }
  ```
- **Respuesta exitosa**: 200
  ```json
  {
    "status": "success",
    "email": "string",
    "token": "string"
  }
  ```
- **Respuesta error**: 401 si las credenciales no son válidas

#### `/user/createpatient`
- **Descripción**: Crea un nuevo paciente
- **Autorización**: Token requerido
- **Permisos**: `create_user`
- **Body**:
  ```json
  {
    "name": "string",
    "lastname": "string",
    "birthday": "date",
    "phone": "string",
    "address": "string",
    "email": "string" (opcional)
  }
  ```
- **Respuesta exitosa**: 201
- **Respuesta error**: 409 si el email ya existe

#### `/user/register`
- **Descripción**: Registra un nuevo usuario completo
- **Autorización**: Token requerido
- **Permisos**: `create_user`
- **Body**:
  ```json
  {
    "parentId": "string",
    "name": "string",
    "lastname": "string",
    "email": "string",
    "password": "string",
    "birthday": "date",
    "phone": "string",
    "related": "string",
    "address": "string",
    "id_rol": "string"
  }
  ```
- **Respuesta exitosa**: 201

### PUT

#### `/user/updateuser/{id}`
- **Descripción**: Actualiza un usuario
- **Autorización**: Token requerido
- **Permisos**: `update_user`
- **Parámetros**: 
  - `id` (URL): ID del usuario
- **Body**: Datos del usuario a actualizar
- **Respuesta exitosa**: 200

#### `/user/updatedata/{id}`
- **Descripción**: Actualiza datos de un usuario (método genérico)
- **Autorización**: Token requerido
- **Permisos**: `update_user`
- **Parámetros**: 
  - `id` (URL): ID del usuario
- **Body**: Datos a actualizar
- **Respuesta exitosa**: 200

#### `/user/resetpassword/{id}`
- **Descripción**: Restablece la contraseña de un usuario a su fecha de nacimiento
- **Autorización**: Token requerido
- **Permisos**: `update_user`
- **Parámetros**: 
  - `id` (URL): ID del usuario
- **Respuesta exitosa**: 200

### DELETE

#### `/user/deleteuser`
- **Descripción**: Elimina un usuario
- **Autorización**: Token requerido
- **Permisos**: `delete_user`
- **Respuesta exitosa**: 200

---

## Notas Generales

### Autenticación

La mayoría de los endpoints requieren autenticación mediante token JWT que debe enviarse en el encabezado `Authorization`:

```
Authorization: Bearer {token}
```

### Códigos de Estado HTTP

- **200**: Operación exitosa
- **201**: Recurso creado exitosamente
- **400**: Solicitud incorrecta
- **401**: No autorizado (sin token o token inválido)
- **403**: Prohibido (token válido pero sin permisos)
- **404**: Recurso no encontrado
- **405**: Método no permitido
- **409**: Conflicto (por ejemplo, email duplicado)
- **500**: Error interno del servidor

### Formato de Respuesta Estándar

```json
{
  "status": "success|false|error",
  "msg": "Mensaje descriptivo",
  "data": {} | []
}
```

### Permisos

El sistema utiliza permisos basados en roles. Los permisos comunes incluyen:

- `getall_{resource}`: Ver todos los registros
- `get_{resource}`: Ver un registro específico
- `create_{resource}`: Crear un nuevo registro
- `update_{resource}`: Actualizar un registro
- `delete_{resource}`: Eliminar un registro

Los permisos se verifican a través del token JWT decodificado que contiene los permisos del usuario autenticado.
