# Documentación API - Sistema de Citas CERAOR

## Información General

### Base URL
```
http://localhost/citas-ceraor-back/
```

### Sistema de Routing
La API utiliza un sistema de routing personalizado donde la URL se estructura de la siguiente manera:
```
/{controlador}/{método}/{parámetro}/{extra}
```

### Autenticación
La mayoría de endpoints requieren autenticación mediante JWT token en el header `Authorization`.

**Excepciones que NO requieren token:**
- `/user/login`
- `/order/generatedocument`

### Headers Requeridos
```http
Content-Type: application/json
Authorization: Bearer {jwt_token}
```

### Estructura de Response Estándar
```json
{
  "status": "success|false",
  "msg": "Mensaje descriptivo",
  "data": "Datos de respuesta (opcional)"
}
```

### Códigos de Estado HTTP
- **200**: OK
- **201**: Created  
- **400**: Bad Request
- **401**: Unauthorized
- **403**: Forbidden
- **404**: Not Found
- **405**: Method Not Allowed
- **500**: Internal Server Error

### Permisos
Los endpoints verifican permisos específicos del usuario autenticado. Los permisos se almacenan como string separado por comas en el token JWT.

---

## 📋 APPOINTMENT - Gestión de Citas

**Base URL:** `/appointment`

### GET Endpoints

#### 🔹 Obtener todas las citas
```http
GET /appointment/getall
```
**Permiso requerido:** `getall_appointment`

**Response exitoso (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "id": "uuid",
      "id_order": "uuid|null",
      "client": "string",
      "personal": "string",
      "id_subsidiary": "int",
      "service": "int",
      "appointment": "2024-01-15 10:30:00",
      "end_appointment": "2024-01-15 11:00:00",
      "barcode": "ABCD1234.png",
      "code": "ABCD1234",
      "color": "#FF5733",
      "active": 1,
      "created_at": "2024-01-15 08:00:00",
      "updated_at": "2024-01-15 08:00:00"
    }
  ]
}
```

#### 🔹 Obtener cita por código de barras
```http
GET /appointment/getbybarcode/{barcode}
```
**Permiso requerido:** `get_appointment`

**Parámetros:**
- `barcode` (string): Código de barras de la cita (ej: "ABCD1234")

**Response exitoso (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "appointment_id": "uuid",
      "code": "ABCD1234",
      "appointment": "2024-01-15 10:30:00",
      "color": "#FF5733",
      "barcode": "ABCD1234.png",
      "client": "Juan Pérez",
      "personal": "Dr. García",
      "order_id": "uuid",
      "patient": "Juan Pérez",
      "birthdate": "1980-05-15",
      "phone": "555-1234",
      "doctor": "Dr. García",
      "address": "Calle 123",
      "subsidiary_name": "Clínica Norte",
      "service_name": "Radiografía",
      "price": 500.00,
      "created_at": "2024-01-15 08:00:00"
    }
  ]
}
```

#### 🔹 Obtener cita por ID
```http
GET /appointment/getbyid/{id}
```
**Permiso requerido:** `get_appointment`

**Parámetros:**
- `id` (string): UUID de la cita

**Response exitoso (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": {
    "id": "uuid",
    "client": "Juan Pérez",
    "appointment": "2024-01-15 10:30:00",
    "service": 1,
    "active": 1
  }
}
```

#### 🔹 Obtener citas por sucursal
```http
GET /appointment/getbysubsidiary/{subsidiary_id}
```
**⚠️ Sin verificación de permisos**

**Parámetros:**
- `subsidiary_id` (int): ID de la sucursal

**Response exitoso (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "id": "uuid",
      "client": "Juan Pérez",
      "personal": "Dr. García",
      "service": 1,
      "service_name": "Radiografía",
      "id_subsidiary": 1,
      "subsidiary_name": "Clínica Norte",
      "color": "#FF5733",
      "appointment": "2024-01-15 10:30:00",
      "end_appointment": "2024-01-15 11:00:00"
    }
  ]
}
```

#### 🔹 Obtener detalles de cita por ID
```http
GET /appointment/getdetailbyid/{id}
```
**Permiso requerido:** `get_appointment`

**Parámetros:**
- `id` (string): UUID de la cita

**Response exitoso (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "appointment_id": "uuid",
      "patient_name": "Juan Pérez",
      "subsidiary_name": "Clínica Norte",
      "service_name": "Radiografía",
      "service_price": 500.00,
      "appointment_datetime": "2024-01-15 10:30:00",
      "staff_name": "Dr. García"
    }
  ]
}
```

### POST Endpoints

#### 🔹 Crear cita especializada
```http
POST /appointment/setappointment
```
**Permiso requerido:** `create_appointment`

**Request Body:**
```json
{
  "id_order": "uuid-orden", // Opcional
  "client": "Juan Pérez",
  "personal": "Dr. García",
  "id_subsidiary": "1",
  "service": "1",
  "appointment": "2024-01-15 10:30:00",
  "end_appointment": "2024-01-15 11:00:00",
  "color": "#FF5733"
}
```

**Response exitoso (201):**
```json
{
  "status": "success",
  "msg": "Created",
  "data": true
}
```

**Response error (400) - Conflicto de horario:**
```json
{
  "status": "error",
  "msg": "Bad Request",
  "data": false
}
```

#### 🔹 Crear cita genérica
```http
POST /appointment/create
```
**Permiso requerido:** `create_appointment`

**Request Body:**
```json
{
  "client": "string",
  "personal": "string",
  "id_subsidiary": "int",
  "service": "int",
  "appointment": "datetime",
  "end_appointment": "datetime",
  "color": "string"
}
```

**Response exitoso (201):**
```json
{
  "status": "success",
  "msg": "Created",
  "data": "uuid-nueva-cita"
}
```

### PUT Endpoints

#### 🔹 Actualizar cita
```http
PUT /appointment/update
```
**Permiso requerido:** `update_appointment`

**Request Body:**
```json
{
  "id": "uuid",
  "client": "string",
  "appointment": "datetime",
  "color": "string"
}
```

**Response exitoso (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": true
}
```

### DELETE Endpoints

#### 🔹 Eliminar cita
```http
DELETE /appointment/delete
```
**Permiso requerido:** `delete_appointment`

**Request Body:**
```json
{
  "id": "uuid"
}
```

**Response exitoso (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": true
}
```

---

## 💰 CASHCUT - Cortes de Caja

**Base URL:** `/cashcut`

### GET Endpoints

#### 🔹 Obtener todos los cortes de caja
```http
GET /cashcut/getall
```
**Permiso requerido:** `getall_cashcut`

**Response exitoso (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "cash_cut_id": "uuid",
      "user_name": "Juan Pérez",
      "subsidiary_name": "Clínica Norte",
      "start_date": "2024-01-15 08:00:00",
      "end_date": "2024-01-15 18:00:00",
      "total": 2500.00
    }
  ]
}
```

#### 🔹 Obtener corte por ID
```http
GET /cashcut/getbyid/{id}
```
**Permiso requerido:** `get_cashcut`

**Parámetros:**
- `id` (string): UUID del corte de caja

**Response exitoso (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": {
    "id": "uuid",
    "id_user": "uuid",
    "id_subsidiary": 1,
    "start_date": "2024-01-15 08:00:00",
    "end_date": "2024-01-15 18:00:00",
    "total": 2500.00,
    "active": 1
  }
}
```

#### 🔹 Obtener ganancias por mes
```http
GET /cashcut/cashcut-gains/{month}
```
**Parámetros:**
- `month` (string): Formato YYYY-MM (ej: "2024-01")

**Response exitoso (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "fecha": "2024-01-15",
      "total_ingresos": 2500.00,
      "total_pagos": 15
    },
    {
      "fecha": "2024-01-14",
      "total_ingresos": 1800.00,
      "total_pagos": 12
    }
  ]
}
```

**Response error (400):**
```json
{
  "status": "error",
  "msg": "Formato de mes inválido. Usa YYYY-MM",
  "data": []
}
```

#### 🔹 Obtener pagos por corte de caja (PDF)
```http
GET /cashcut/cashcut-payments/{id}
```
**Parámetros:**
- `id` (string): UUID del corte de caja

**Response:** Descarga directa de archivo PDF

#### 🔹 Exportar pagos a Excel
```http
GET /cashcut/cashcut-payments-excel/{id}
```
**Parámetros:**
- `id` (string): UUID del corte de caja

**Response:** Descarga directa de archivo Excel

#### 🔹 Exportar rango de cortes
```http
GET /cashcut/cashcut-export-range/{dates}
```
**Parámetros:**
- `dates` (string): Formato "YYYY-M-YYYY-M::SUCURSAL_ID" (ej: "2024-1-2024-2::1")

**Response:** Descarga directa de archivo Excel o JSON con error

#### 🔹 Obtener porcentaje por sucursal
```http
GET /cashcut/cashcut-percent
```

**Response exitoso (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "sucursal": "Clínica Norte",
      "total_servicios": 150,
      "porcentaje": 45.50
    },
    {
      "sucursal": "Clínica Sur",
      "total_servicios": 180,
      "porcentaje": 54.50
    }
  ]
}
```

#### 🔹 Obtener servicios top
```http
GET /cashcut/cashcut-top-services
```

**Response exitoso (200):**
```json
{
  "status": "success",
  "data": [
    {
      "servicio": "Radiografía Panorámica",
      "total": 85
    },
    {
      "servicio": "Tomografía",
      "total": 42
    }
  ]
}
```

#### 🔹 Obtener datos para home
```http
GET /cashcut/data-home
```

**Response exitoso (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "total_clientes": 250,
      "total_doctores": 15,
      "total_citas_mes": 180,
      "ganancia_mes": 45000.00
    }
  ]
}
```

#### 🔹 Obtener ganancias semanales
```http
GET /cashcut/gains-week
```

**Response exitoso (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "dia_semana": "Lunes",
      "total_dia": 3500.00
    },
    {
      "dia_semana": "Martes",
      "total_dia": 4200.00
    }
  ]
}
```

### POST Endpoints

#### 🔹 Crear corte de caja
```http
POST /cashcut/create
```
**Permiso requerido:** `create_cashcut`

**Request Body:**
```json
{
  "id_user": "uuid",
  "id_subsidiary": "1",
  "start_date": "2024-01-15 08:00:00",
  "end_date": "2024-01-15 18:00:00",
  "total": 2500.00
}
```

**Response exitoso (201):**
```json
{
  "status": "success",
  "msg": "Created",
  "data": "uuid-nuevo-corte"
}
```

#### 🔹 Actualizar total
```http
POST /cashcut/update-total
```
**Permiso requerido:** `create_cashcut`

**Request Body:**
```json
{
  "id_cashcut": "uuid"
}
```

**Response exitoso (201):**
```json
{
  "status": "success",
  "msg": "Created",
  "data": "uuid-corte-actualizado"
}
```

---

## 📂 CATALOG - Catálogos

**Base URL:** `/catalog`

### GET Endpoints

#### 🔹 Obtener catálogo por tabla
```http
GET /catalog/getall/{table}
```
**Parámetros:**
- `table` (string): Nombre de la tabla del catálogo

#### 🔹 Obtener doctores
```http
GET /catalog/getdoctors
```

#### 🔹 Obtener clientes
```http
GET /catalog/getclients
```

---

## 🏢 DEPARTMENT - Departamentos

**Base URL:** `/department`

### GET Endpoints

#### 🔹 Obtener departamentos por clínica
```http
GET /department/departmentsByClinicId/{clinic_id}
```
**Parámetros:**
- `clinic_id` (int): ID de la clínica

#### 🔹 Operaciones CRUD genéricas
```http
GET /department/{método}/{parámetro}
POST /department
PUT /department  
DELETE /department
```
**Nota:** Requiere autenticación. UserType 5 no puede usar POST/PUT/DELETE.

---

## 🎓 ESPECIALITY - Especialidades

**Base URL:** `/especiality`

### Operaciones CRUD básicas
```http
GET /especiality/{método}/{parámetro}
POST /especiality
PUT /especiality
DELETE /especiality
```
**⚠️ Autenticación comentada actualmente**

---

## 📁 FILE - Gestión de Archivos

**Base URL:** `/file`

### GET Endpoints

#### 🔹 Listar archivos
```http
GET /file/getfile/list
```

#### 🔹 Leer contenido de archivo
```http
GET /file/getfile/read/{filename}
```

#### 🔹 Descargar archivo por folio
```http
GET /file/getfile/download/{filename}
```

#### 🔹 Descargar archivo por ID
```http
GET /file/getfile/downloadbyid/{id}
```

---

## 📋 ORDER - Órdenes

**Base URL:** `/order`

### GET Endpoints

#### 🔹 Obtener todas las órdenes activas
```http
GET /order/getall
```
**Permiso requerido:** `getall_order`

#### 🔹 Obtener orden por ID
```http
GET /order/getbyid/{id}
```
**Permiso requerido:** `get_order`

#### 🔹 Obtener ticket
```http
GET /order/getticket/{id}
```
**Permiso requerido:** `update_order`

#### 🔹 Obtener órdenes por cita
```http
GET /order/getbyappointment/{appointment_id}
```
**Permiso requerido:** `get_order`

#### 🔹 Generar documento PDF por ID
```http
GET /order/generatedocument/{id}
GET /order/generatedocument/{id}/download
```
**⚠️ Sin autenticación requerida**

**Parámetros:**
- `id` (string): UUID de la orden
- `download` (opcional): Si se incluye, fuerza la descarga del archivo

**Response:** Archivo PDF para visualización/descarga directa

**Características:**
- **Genera PDF completo** con todos los detalles de la orden
- **Visualización directa** en el navegador (por defecto)
- **Forzar descarga** agregando `/download` al final de la URL
- **Información detallada** de paciente y servicios solicitados
- **Formato profesional** para impresión
- **Sin necesidad de autenticación** para facilitar acceso público

**Ejemplos:**
- Visualizar: `GET /order/generatedocument/uuid-de-la-orden`
- Descargar: `GET /order/generatedocument/uuid-de-la-orden/download`

#### 🔹 Generar documento PDF por código de cita
```http
GET /order/generatedocumentbycode/{code}
GET /order/generatedocumentbycode/{code}/download
```
**⚠️ Sin autenticación requerida**

**Parámetros:**
- `code` (string): Código de la cita (ej: "ABCD1234")
- `download` (opcional): Si se incluye, fuerza la descarga del archivo

**Response:** Archivo PDF para visualización/descarga directa

**Características:**
- **Búsqueda por código de cita** en lugar de UUID
- **Mismo formato PDF** que el endpoint por ID
- **Ideal para códigos de barras** y escaneado QR
- **Acceso público** sin autenticación
- **Visualizar o descargar** según parámetro

**Ejemplos:**
- Visualizar: `GET /order/generatedocumentbycode/ABCD1234`
- Descargar: `GET /order/generatedocumentbycode/ABCD1234/download`

#### 🔹 Generar ticket PDF por ID
```http
GET /order/generateticket/{id}
GET /order/generateticket/{id}/download
```
**⚠️ Sin autenticación requerida**

**Parámetros:**
- `id` (string): UUID de la orden
- `download` (opcional): Si se incluye, fuerza la descarga del archivo

**Response:** Archivo PDF del ticket para visualización/descarga directa

**Características:**
- **Ticket compacto** con información esencial
- **Código QR/barras** para seguimiento
- **Formato de etiqueta** optimizado para impresión
- **Visualizar en navegador** o **forzar descarga**
- **Genera código de ticket** automáticamente si no existe

**Ejemplos:**
- Visualizar: `GET /order/generateticket/uuid-de-la-orden`
- Descargar: `GET /order/generateticket/uuid-de-la-orden/download`

#### 🔹 Obtener órdenes por doctor
```http
GET /order/getbydoctor/{doctor_name}
```
**Permiso requerido:** `get_order`

#### 🔹 Obtener órdenes por estatus
```http
GET /order/getbystatus/{status}
```
**Permiso requerido:** `get_order`

#### 🔹 Obtener órdenes por método
```http
GET /order/getbymethod/{method}
```
**Permiso requerido:** `get_order`

#### 🔹 Obtener detalles por ID
```http
GET /order/getdetailsbyid/{id}
```
**Permiso requerido:** `get_order`

### POST Endpoints

#### 🔹 Crear orden
```http
POST /order/create
```
**Permiso requerido:** `create_order`

**Request Body (Orden completa de estudios médicos):**
```json
{
  "patient": "Juan Pérez González",
  "birthdate": "1985-03-15",
  "phone": "555-1234",
  "doctor": "Dr. García López",
  "address": "Calle 123, Colonia Centro, Ciudad",
  "professional_id": "12345",
  "email": "juan@ejemplo.com",
  
  // Opciones de entrega
  "acetate_print": 1,
  "paper_print": 0,
  "send_email": 1,
  
  // Radiografías
  "rx_panoramic": 1,
  "rx_arc_panoramic": 0,
  "rx_lateral_skull": 1,
  "ap_skull": 0,
  "pa_skull": 0,
  "paranasal_sinuses": 0,
  "atm_open_close": 1,
  "profilogram": 0,
  "watters_skull": 0,
  "palmar_digit": 0,
  "others_radiography": "Radiografía personalizada",
  
  // Radiografías intraorales
  "occlusal_xray": 1,
  "superior": 1,
  "inferior": 1,
  "complete_periapical": 0,
  "individual_periapical": 1,
  "conductometry": 0,
  "clinical_photography": 1,
  
  // Análisis cefalométricos
  "rickets": 1,
  "mcnamara": 0,
  "downs": 1,
  "jaraback": 0,
  "steiner": 1,
  "others_analysis": "Análisis personalizado",
  
  // Análisis de modelos
  "analysis_bolton": 1,
  "analysis_moyers": 0,
  "others_models_analysis": "Análisis personalizado de modelos",
  
  // Impresiones 3D
  "risina": 1,
  "dentalprint": 0,
  "risina_3d": 1,
  "surgical_guide": 0,
  "studio_piece": "Pieza de estudio personalizada",
  
  // Tomografías
  "complete_tomography": 1,
  "two_jaws_tomography": 0,
  "maxilar_tomography": 1,
  "jaw_tomography": 0,
  "snp_tomography": 0,
  "ear_tomography": 0,
  "atm_tomography_open_close": 1,
  "lateral_left_tomography_open_close": 0,
  "lateral_right_tomography_open_close": 0,
  
  // Formatos de entrega tomografía
  "ondemand": "Si",
  "dicom": "No",
  "tomography_piece": "12,13,14",
  "implant": "Implante zona molar",
  "impacted_tooth": "Cordal inferior izquierdo",
  "others_tomography": "Tomografía personalizada",
  
  // Escáner intraoral
  "stl": 1,
  "obj": 0,
  "ply": 0,
  "invisaligh": 1,
  "others_scanners": "Escáner personalizado",
  
  // Maxilares
  "maxilar_superior": 1,
  "maxilar_inferior": 1,
  "maxilar_both": 0,
  "maxilar_others": "Maxilar personalizado",
  "dental_interpretation": 1,
  
  // Estado y método (opcionales, se asignan valores por defecto)
  "status": "solicitado",
  "method": "por_definir"
}
```

**Response exitoso (201):**
```json
{
  "status": "success",
  "msg": "Created",
  "data": true
}
```

#### 🔹 Buscar por código de ticket
```http
POST /order/getbyticketcode/{ticket_code}
```
**Permiso requerido:** `get_order`

#### 🔹 Obtener órdenes con código de ticket
```http
POST /order/getwithticketcode
```
**Permiso requerido:** `get_order`

### PUT Endpoints

#### 🔹 Actualizar orden
```http
PUT /order/update
```
**Permiso requerido:** `update_order`

#### 🔹 Actualizar estatus
```http
PUT /order/updatestatus/{id}
```
**Permiso requerido:** `update_order`

**Body:**
```json
{
  "status": "string"
}
```

#### 🔹 Actualizar método
```http
PUT /order/updatemethod/{id}
```
**Permiso requerido:** `update_order`

**Body:**
```json
{
  "method": "string"
}
```

### DELETE Endpoints

#### 🔹 Eliminar orden
```http
DELETE /order/delete
```
**Permiso requerido:** `delete_order`

---

## 💳 PAYMENT - Pagos

**Base URL:** `/payment`

### POST Endpoints

#### 🔹 Crear pago
```http
POST /payment/create
```
**Permiso requerido:** `create_cashcut`

---

## 🔐 PERMISSION - Permisos

**Base URL:** `/permission`

### GET Endpoints

#### 🔹 Obtener todos los permisos
```http
GET /permission/getall
```
**Permiso requerido:** `getall_rolpermission`

#### 🔹 Obtener permiso por ID
```http
GET /permission/getbyid/{id}
```
**Permiso requerido:** `get_rolpermission`

### POST Endpoints

#### 🔹 Crear permiso
```http
POST /permission/create
```
**Permiso requerido:** `create_rolpermission`

### PUT Endpoints

#### 🔹 Actualizar permiso
```http
PUT /permission/update
```
**Permiso requerido:** `update_rolpermission`

### DELETE Endpoints

#### 🔹 Eliminar permiso
```http
DELETE /permission/delete
```
**Permiso requerido:** `delete_permission`

---

## 👥 ROL - Roles

**Base URL:** `/rol`

### GET Endpoints

#### 🔹 Obtener todos los roles
```http
GET /rol/getall
```
**Permiso requerido:** `getall_rolpermission`

#### 🔹 Obtener rol por ID
```http
GET /rol/getbyid/{id}
```
**Permiso requerido:** `get_rolpermission`

### POST Endpoints

#### 🔹 Crear rol
```http
POST /rol/create
```
**Permiso requerido:** `create_rolpermission`

### PUT Endpoints

#### 🔹 Actualizar rol
```http
PUT /rol/update
```
**Permiso requerido:** `update_rolpermission`

### DELETE Endpoints

#### 🔹 Eliminar rol
```http
DELETE /rol/delete
```
**Permiso requerido:** `delete_rolpermission`

---

## 🔗 ROLPERMISSION - Roles-Permisos

**Base URL:** `/rolpermission`

### GET Endpoints

#### 🔹 Obtener permisos por rol
```http
GET /rolpermission/getpermissionsbyrol/{rol_id}
```
**Permiso requerido:** `get_rolpermission`

### POST Endpoints

#### 🔹 Crear relación rol-permiso
```http
POST /rolpermission/create
```
**Permiso requerido:** `create_rolpermission`

#### 🔹 Actualizar permisos de un rol
```http
POST /rolpermission/updatepermissions
```
**Permiso requerido:** `update_rolpermission`

**Body:**
```json
{
  "id_rol": "int",
  "permissions": [
    {
      "id_permission": "int",
      "id_rol": "int"
    }
  ]
}
```

### DELETE Endpoints

#### 🔹 Eliminar relación
```http
DELETE /rolpermission/delete
```
**Permiso requerido:** `delete_rolpermission`

---

## 🛠️ SERVICE - Servicios

**Base URL:** `/service`

### GET Endpoints

#### 🔹 Obtener todos los servicios
```http
GET /service/getall
```
**Permiso requerido:** `getall_service`

#### 🔹 Obtener servicio por ID
```http
GET /service/getbyid/{id}
```
**Permiso requerido:** `get_service`

#### 🔹 Obtener servicios por sucursal
```http
GET /service/getbysubsidiary/{subsidiary_id}
```
**Permiso requerido:** `get_service`

### POST Endpoints

#### 🔹 Crear servicio
```http
POST /service/create
```
**Permiso requerido:** `create_service`

### PUT Endpoints

#### 🔹 Actualizar servicio
```http
PUT /service/update
```
**Permiso requerido:** `update_service`

### DELETE Endpoints

#### 🔹 Eliminar servicio
```http
DELETE /service/delete
```
**Permiso requerido:** `delete_service`

---

## 🏢 SUBSIDIARY - Sucursales

**Base URL:** `/subsidiary`

### GET Endpoints

#### 🔹 Obtener todas las sucursales
```http
GET /subsidiary/getall
```
**Permiso requerido:** `getall_subsidiary`

#### 🔹 Obtener sucursal por ID
```http
GET /subsidiary/getbyid/{id}
```
**Permiso requerido:** `get_subsidiary`

### POST Endpoints

#### 🔹 Crear sucursal
```http
POST /subsidiary/create
```
**Permiso requerido:** `create_subsidiary`

### PUT Endpoints

#### 🔹 Actualizar sucursal
```http
PUT /subsidiary/update
```
**Permiso requerido:** `update_subsidiary`

### DELETE Endpoints

#### 🔹 Eliminar sucursal
```http
DELETE /subsidiary/delete
```
**Permiso requerido:** `delete_subsidiary`

---

## 👤 USER - Usuarios

**Base URL:** `/user`

### GET Endpoints

#### 🔹 Obtener todos los usuarios
```http
GET /user/getall
```
**Permiso requerido:** `getall_user`

**Response exitoso (200):**
```json
{
  "status": "success",
  "msg": "Fila(s) o Elemento(s) encontrada(s)",
  "data": [
    {
      "id": "uuid",
      "parent_id": "uuid|null",
      "name": "Juan",
      "lastname": "Pérez",
      "email": "juan@ejemplo.com",
      "birthday": "1985-03-15",
      "phone": "555-1234",
      "related": "Hermano",
      "address": "Calle 123, Colonia Centro",
      "id_rol": 5,
      "active": 1,
      "created_at": "2024-01-15 10:30:00",
      "updated_at": "2024-01-15 10:30:00"
    }
  ]
}
```

#### 🔹 Obtener usuario por ID
```http
GET /user/getbyid/{id}
```
**Permiso requerido:** `get_user`

**Parámetros:**
- `id` (string): UUID del usuario

**Response exitoso (200):**
```json
{
  "status": "success",
  "msg": "Fila(s) o Elemento(s) encontrada(s)",
  "data": {
    "id": "uuid",
    "name": "Juan",
    "lastname": "Pérez",
    "email": "juan@ejemplo.com",
    "id_rol": 5,
    "active": 1
  }
}
```

#### 🔹 Obtener instancia de usuario
```http
GET /user/getinstance/{id}
```
**⚠️ Sin verificación de permisos**

**Parámetros:**
- `id` (string): UUID del usuario

**Response exitoso (200):**
```json
{
  "status": "success",
  "msg": "Fila(s) o Elemento(s) encontrada(s)",
  "data": {
    "id": "uuid",
    "name": "Juan",
    "lastname": "Pérez",
    "email": "juan@ejemplo.com"
  }
}
```

#### 🔹 Obtener usuarios por rol
```http
GET /user/getbyidrol/{rol_id}
```
**Permiso requerido:** `get_user`

**Parámetros:**
- `rol_id` (int): ID del rol (5=doctores, 6=clientes)

**Response exitoso (200):**
```json
{
  "status": "success",
  "msg": "Fila(s) o Elemento(s) encontrada(s)",
  "data": [
    {
      "id": "uuid",
      "name": "Dr. García",
      "lastname": "López",
      "email": "garcia@clinica.com",
      "id_rol": 5
    }
  ]
}
```

#### 🔹 Obtener mis usuarios
```http
GET /user/getmyusers/{parent_id}
```
**Permiso requerido:** `get_user`

**Parámetros:**
- `parent_id` (string): UUID del usuario padre

**Response exitoso (200):**
```json
{
  "status": "success",
  "msg": "Fila(s) o Elemento(s) encontrada(s)",
  "data": [
    {
      "id": "uuid",
      "name": "Usuario Hijo",
      "parent_id": "uuid-padre"
    }
  ]
}
```

**Response sin datos (404):**
```json
{
  "status": false,
  "msg": "Usuarios no encontrados"
}
```

### POST Endpoints

#### 🔹 Login
```http
POST /user/login
```
**⚠️ Sin autenticación requerida**

**Request Body:**
```json
{
  "email": "juan@ejemplo.com",
  "password": "mi_password_seguro"
}
```

**Response exitoso (200):**
```json
{
  "status": "success",
  "email": "juan@ejemplo.com",
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
}
```

**Response error (401):**
```json
{
  "status": "false",
  "msg": "Credenciales no válidas"
}
```

#### 🔹 Registrar usuario
```http
POST /user/register
```
**Permiso requerido:** `create_user`

**Request Body:**
```json
{
  "parentId": "uuid-padre",
  "name": "Juan",
  "lastname": "Pérez",
  "email": "juan@ejemplo.com",
  "password": "password_seguro",
  "birthday": "1985-03-15",
  "phone": "555-1234",
  "related": "Hermano",
  "address": "Calle 123, Colonia Centro",
  "id_rol": 6
}
```

**Response exitoso (201):**
```json
{
  "status": "success",
  "data": true,
  "msg": "Created"
}
```

**Response error (403) - Email existente:**
```json
{
  "status": "false",
  "data": false,
  "msg": "Forbidden"
}
```

### PUT Endpoints

#### 🔹 Actualizar usuario
```http
PUT /user/updateuser/{id}
```
**Permiso requerido:** `update_user`

**Parámetros:**
- `id` (string): UUID del usuario

**Request Body:**
```json
{
  "id": "uuid",
  "name": "Juan Actualizado",
  "lastname": "Pérez",
  "email": "nuevo_email@ejemplo.com",
  "phone": "555-5678"
}
```

**Response exitoso (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": true
}
```

### DELETE Endpoints

#### 🔹 Eliminar usuario
```http
DELETE /user/deleteuser
```
**Permiso requerido:** `delete_user`

**Request Body:**
```json
{
  "id": "uuid"
}
```

**Response exitoso (200):**
```json
{
  "status": "success",
  "msg": "Fila(s) o Elemento(s) eliminado(s)",
  "data": true
}
```

---

## 📝 Notas Importantes

### Valores Permitidos para Enums

#### Status de Órdenes
- `solicitado`: Orden recién creada
- `en_proceso`: Orden en procesamiento
- `entregado`: Orden completada y entregada

#### Métodos de Entrega
- `fisico`: Entrega física
- `digital`: Entrega digital
- `ambos`: Entrega física y digital
- `por_definir`: Método pendiente de definir

#### Roles de Usuario
- `5`: Doctores/Profesionales médicos
- `6`: Clientes/Pacientes

### Formatos de Fecha
- **Fechas**: `YYYY-MM-DD` (ej: "2024-01-15")
- **Fechas con hora**: `YYYY-MM-DD HH:MM:SS` (ej: "2024-01-15 10:30:00")
- **Mes para reportes**: `YYYY-MM` (ej: "2024-01")

### Campos Numéricos Booleanos
En muchos endpoints, los campos boolean se manejan como:
- `1`: Verdadero/Sí/Activo
- `0`: Falso/No/Inactivo

### Códigos de Barras y Tickets
- **Códigos de citas**: 8 caracteres alfanuméricos (ej: "ABCD1234")
- **Códigos de ticket**: Prefijo "TK" + 6 caracteres (ej: "TKABCD12")

### Archivos Generados
- **PDFs**: Se generan automáticamente para órdenes y tickets
- **Excel**: Disponible para reportes de cortes de caja
- **Códigos de barras**: Se generan como archivos PNG

### Autenticación JWT
El token JWT contiene:
```json
{
  "id": "uuid",
  "name": "string",
  "lastname": "string", 
  "email": "string",
  "parent_id": "uuid",
  "permissions": {
    "role_name": "string",
    "permissions": "perm1, perm2, perm3"
  }
}
```

### Lista Completa de Permisos
**Citas:**
- `getall_appointment`, `get_appointment`, `create_appointment`, `update_appointment`, `delete_appointment`

**Cortes de Caja:**
- `getall_cashcut`, `get_cashcut`, `create_cashcut`

**Órdenes:**
- `getall_order`, `get_order`, `create_order`, `update_order`, `delete_order`

**Roles y Permisos:**
- `getall_rolpermission`, `get_rolpermission`, `create_rolpermission`, `update_rolpermission`, `delete_rolpermission`, `delete_permission`

**Servicios:**
- `getall_service`, `get_service`, `create_service`, `update_service`, `delete_service`

**Sucursales:**
- `getall_subsidiary`, `get_subsidiary`, `create_subsidiary`, `update_subsidiary`, `delete_subsidiary`

**Usuarios:**
- `getall_user`, `get_user`, `create_user`, `update_user`, `delete_user`

### Respuestas de Error Comunes

#### 401 - No Autorizado
```json
{
  "status": false,
  "msg": "No autorizado"
}
```

#### 404 - No Encontrado
```json
{
  "status": false,
  "msg": "Not Found"
}
```

#### 405 - Método No Permitido
```json
{
  "status": false,
  "msg": "Method Not Allowed"
}
```

---

**Documentación API Sistema de Citas CERAOR**  
**Versión:** 2.0  
**Última actualización:** Enero 2024  
**Total de endpoints documentados:** 89+  
**Controladores incluidos:** 15  

> 📋 **Esta documentación incluye ejemplos completos de request/response para todos los endpoints de la API del sistema de gestión de citas médicas CERAOR.**
