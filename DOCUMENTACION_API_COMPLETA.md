# 📋 **Documentación Completa de API - CERAOR**

**Centro de Radiología Oral y Maxilofacial**  
**Versión:** 1.0  
**Fecha:** Septiembre 2025

---

## 📌 **Índice**

1. [Información General](#-información-general)
2. [Estructura de Routing](#-estructura-de-routing)
3. [Autenticación y Autorización](#-autenticación-y-autorización)
4. [Estructura de Respuestas](#-estructura-de-respuestas)
5. [Códigos de Estado HTTP](#-códigos-de-estado-http)
6. [Endpoints por Controlador](#-endpoints-por-controlador)
   - [User (Usuarios)](#user-usuarios)
   - [Appointment (Citas)](#appointment-citas)
   - [Order (Órdenes)](#order-órdenes)
   - [Payment (Pagos)](#payment-pagos)
   - [CashCut (Cortes de Caja)](#cashcut-cortes-de-caja)
   - [Service (Servicios)](#service-servicios)
   - [Subsidiary (Sucursales)](#subsidiary-sucursales)
   - [Catalog (Catálogos)](#catalog-catálogos)
   - [Permission (Permisos)](#permission-permisos)
   - [Rol (Roles)](#rol-roles)
   - [RolPermission (Roles-Permisos)](#rolpermission-roles-permisos)
   - [File (Archivos)](#file-archivos)
   - [Department (Departamentos)](#department-departamentos)
   - [Especiality (Especialidades)](#especiality-especialidades)
7. [Notas Importantes](#-notas-importantes)

---

## 🌐 **Información General**

### **Base URL**
```
https://api.ceraor.com/
```

### **Formato de Datos**
- **Content-Type:** `application/json`
- **Encoding:** UTF-8
- **Métodos HTTP:** GET, POST, PUT, DELETE

### **Características**
- ✅ **Autenticación JWT**
- ✅ **Control de permisos granular**
- ✅ **Generación de PDFs**
- ✅ **Códigos de barras automáticos**
- ✅ **Exportación a Excel**
- ✅ **CORS habilitado**

---

## 🛣️ **Estructura de Routing**

La API utiliza un sistema de routing personalizado con la siguiente estructura:

```
/{controller}/{method}/{param}/{extra}
```

### **Ejemplos:**
```bash
/user/login                          # Inicio de sesión
/order/getall                        # Obtener todas las órdenes
/order/getbyid/uuid-123              # Obtener orden por ID
/order/generatedocument/uuid-123     # Generar PDF (inline)
/order/generatedocument/uuid-123/download  # Generar PDF (download)
```

---

## 🔐 **Autenticación y Autorización**

### **JWT Token**
Todos los endpoints (excepto login) requieren autenticación JWT.

**Header requerido:**
```http
Authorization: Bearer <jwt_token>
```

### **Estructura del Token**
```json
{
  "iss": "api.ceraor.com",
  "aud": "ceraor-users",
  "iat": 1693534800,
  "exp": 1693621200,
  "data": {
    "id": "uuid-user",
    "email": "user@example.com"
  },
  "permissions": {
    "permissions": "create_user,update_user,delete_user"
  }
}
```

### **Sistema de Permisos**
Los permisos se verifican por endpoint y acción:

```
create_user, update_user, delete_user, get_user, getall_user
create_order, update_order, delete_order, get_order, getall_order
create_appointment, update_appointment, delete_appointment, get_appointment, getall_appointment
create_cashcut, update_cashcut, delete_cashcut, get_cashcut, getall_cashcut
create_service, update_service, delete_service, get_service, getall_service
create_subsidiary, update_subsidiary, delete_subsidiary, get_subsidiary, getall_subsidiary
create_rolpermission, update_rolpermission, delete_rolpermission, get_rolpermission, getall_rolpermission
```

---

## 📊 **Estructura de Respuestas**

### **Respuesta Exitosa**
```json
{
  "status": "success",
  "msg": "OK",
  "data": {...}
}
```

### **Respuesta de Error**
```json
{
  "status": false,
  "msg": "Error message"
}
```

### **Respuesta de Error con Datos**
```json
{
  "status": "error",
  "msg": "Error message",
  "data": []
}
```

---

## 📈 **Códigos de Estado HTTP**

| Código | Estado | Descripción |
|--------|--------|-------------|
| 200 | OK | Operación exitosa |
| 201 | Created | Recurso creado exitosamente |
| 400 | Bad Request | Solicitud incorrecta |
| 401 | Unauthorized | No autorizado |
| 403 | Forbidden | Prohibido |
| 404 | Not Found | Recurso no encontrado |
| 405 | Method Not Allowed | Método no permitido |
| 500 | Internal Server Error | Error interno del servidor |

---

## 👥 **User (Usuarios)**

### **POST /user/login**
Inicio de sesión de usuarios.

**Request:**
```json
{
  "email": "doctor@example.com",
  "password": "password123"
}
```

**Response (200):**
```json
{
  "status": "success",
  "email": "doctor@example.com",
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
}
```

**Response (401):**
```json
{
  "status": "false",
  "msg": "Credenciales no válidas"
}
```

---

### **GET /user/getall**
Obtener todos los usuarios.

**Headers:**
```http
Authorization: Bearer <jwt_token>
```

**Response (200):**
```json
{
  "status": "success",
  "msg": "Fila(s) o Elemento(s) encontrada(s)",
  "data": [
    {
      "id": "uuid-123",
      "parent_id": null,
      "name": "Dr. Juan",
      "lastname": "Pérez",
      "email": "doctor@example.com",
      "birthday": "1980-05-15",
      "phone": "993-123-4567",
      "related": "Radiología",
      "address": "Calle Principal 123",
      "id_rol": 1,
      "professional_id": "PROF123",
      "active": 1,
      "created_at": "2025-01-15",
      "updated_at": "2025-01-15"
    }
  ]
}
```

---

### **GET /user/getbyid/{id}**
Obtener usuario por ID.

**Response (200):**
```json
{
  "status": "success",
  "msg": "Fila(s) o Elemento(s) encontrada(s)",
  "data": {
    "id": "uuid-123",
    "name": "Dr. Juan",
    "lastname": "Pérez",
    "email": "doctor@example.com",
    "phone": "993-123-4567",
    "id_rol": 1,
    "active": 1
  }
}
```

---

### **GET /user/getbyidrol/{id_rol}**
Obtener usuarios por rol.

**Response (200):**
```json
{
  "status": "success",
  "msg": "Fila(s) o Elemento(s) encontrada(s)",
  "data": [
    {
      "id": "uuid-123",
      "name": "Dr. Juan",
      "lastname": "Pérez",
      "email": "doctor@example.com",
      "id_rol": 1
    }
  ]
}
```

---

### **GET /user/getmyusers/{parent_id}**
Obtener usuarios subordinados.

**Response (200):**
```json
{
  "status": "success",
  "msg": "Fila(s) o Elemento(s) encontrada(s)",
  "data": [
    {
      "id": "uuid-456",
      "parent_id": "uuid-123",
      "name": "María",
      "lastname": "García",
      "email": "maria@example.com",
      "id_rol": 2
    }
  ]
}
```

---

### **GET /user/getinstance/{id}**
Obtener instancia de usuario (sin autenticación).

**Response (200):**
```json
{
  "status": "success",
  "msg": "Fila(s) o Elemento(s) encontrada(s)",
  "data": {
    "id": "uuid-123",
    "name": "Dr. Juan",
    "lastname": "Pérez",
    "email": "doctor@example.com"
  }
}
```

---

### **POST /user/register**
Registrar nuevo usuario.

**Request:**
```json
{
  "parentId": "uuid-parent",
  "name": "María",
  "lastname": "García",
  "email": "maria@example.com",
  "password": "password123",
  "birthday": "1990-03-20",
  "phone": "993-987-6543",
  "related": "Asistente",
  "address": "Av. Secundaria 456",
  "id_rol": 2
}
```

**Response (201):**
```json
{
  "status": "success",
  "data": {
    "id": "uuid-new",
    "email": "maria@example.com"
  },
  "msg": "Created"
}
```

---

### **PUT /user/updateuser/{id}**
Actualizar usuario.

**Request:**
```json
{
  "id": "uuid-123",
  "name": "Dr. Juan Carlos",
  "lastname": "Pérez López",
  "phone": "993-123-4567",
  "address": "Nueva Dirección 789"
}
```

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": true
}
```

---

### **DELETE /user/deleteuser**
Eliminar usuario.

**Request:**
```json
{
  "id": "uuid-123"
}
```

**Response (200):**
```json
{
  "status": "success",
  "msg": "Fila(s) o Elemento(s) eliminado(s)",
  "data": true
}
```

---

## 📅 **Appointment (Citas)**

### **GET /appointment/getall**
Obtener todas las citas.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "id": "uuid-appointment",
      "id_order": "uuid-order",
      "client": "Juan Pérez",
      "personal": "Dr. María García",
      "id_subsidiary": "uuid-subsidiary",
      "service": "Radiografía Panorámica",
      "appointment": "2025-09-15 10:00:00",
      "end_appointment": "2025-09-15 10:30:00",
      "barcode": "APPT123.png",
      "code": "APPT123",
      "color": "#ff0000",
      "active": 1,
      "created_at": "2025-09-10",
      "updated_at": "2025-09-10"
    }
  ]
}
```

---

### **GET /appointment/getbyid/{id}**
Obtener cita por ID.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": {
    "id": "uuid-appointment",
    "client": "Juan Pérez",
    "personal": "Dr. María García",
    "service": "Radiografía Panorámica",
    "appointment": "2025-09-15 10:00:00",
    "end_appointment": "2025-09-15 10:30:00",
    "code": "APPT123",
    "active": 1
  }
}
```

---

### **GET /appointment/getbybarcode/{barcode}**
Obtener cita por código de barras.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": {
    "id": "uuid-appointment",
    "client": "Juan Pérez",
    "personal": "Dr. María García",
    "barcode": "APPT123.png",
    "code": "APPT123",
    "appointment": "2025-09-15 10:00:00"
  }
}
```

---

### **GET /appointment/getbysubsidiary/{id_subsidiary}**
Obtener citas por sucursal.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "id": "uuid-appointment",
      "client": "Juan Pérez",
      "personal": "Dr. María García",
      "id_subsidiary": "uuid-subsidiary",
      "appointment": "2025-09-15 10:00:00",
      "service": "Radiografía Panorámica"
    }
  ]
}
```

---

### **GET /appointment/getdetailbyid/{id}**
Obtener detalles completos de cita.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": {
    "id": "uuid-appointment",
    "id_order": "uuid-order",
    "client": "Juan Pérez",
    "personal": "Dr. María García",
    "subsidiary_name": "Sucursal Centro",
    "service": "Radiografía Panorámica",
    "appointment": "2025-09-15 10:00:00",
    "end_appointment": "2025-09-15 10:30:00",
    "barcode": "APPT123.png",
    "code": "APPT123",
    "color": "#ff0000"
  }
}
```

---

### **POST /appointment/setappointment**
Crear nueva cita.

**Request:**
```json
{
  "id_order": "uuid-order",
  "client": "Juan Pérez",
  "personal": "Dr. María García",
  "id_subsidiary": "uuid-subsidiary",
  "service": "Radiografía Panorámica",
  "appointment": "2025-09-15 10:00:00",
  "end_appointment": "2025-09-15 10:30:00",
  "color": "#ff0000"
}
```

**Response (201):**
```json
{
  "status": "success",
  "msg": "Created",
  "data": {
    "id": "uuid-new-appointment",
    "code": "APPT123",
    "barcode": "APPT123.png"
  }
}
```

**Response (400 - Conflicto de horario):**
```json
{
  "status": "error",
  "msg": "Bad Request",
  "data": false
}
```

---

### **POST /appointment/create**
Crear cita (método estándar).

**Request:**
```json
{
  "id_order": "uuid-order",
  "client": "Juan Pérez",
  "personal": "Dr. María García",
  "id_subsidiary": "uuid-subsidiary",
  "service": "Radiografía Panorámica",
  "appointment": "2025-09-15 10:00:00",
  "end_appointment": "2025-09-15 10:30:00",
  "color": "#ff0000",
  "active": 1
}
```

**Response (201):**
```json
{
  "status": "success",
  "msg": "Created",
  "data": {
    "id": "uuid-new-appointment"
  }
}
```

---

### **PUT /appointment/update**
Actualizar cita.

**Request:**
```json
{
  "id": "uuid-appointment",
  "client": "Juan Carlos Pérez",
  "appointment": "2025-09-15 11:00:00",
  "end_appointment": "2025-09-15 11:30:00",
  "color": "#00ff00"
}
```

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": true
}
```

---

### **DELETE /appointment/delete**
Eliminar cita.

**Request:**
```json
{
  "id": "uuid-appointment"
}
```

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": true
}
```

---

## 📋 **Order (Órdenes)**

Las órdenes representan las solicitudes de servicios radiológicos. Cada orden contiene información del paciente, doctor, tipos de estudios solicitados y configuraciones de entrega.

**Campos importantes:**
- **packet:** Tipo de paquete de servicios (0-3, ver tipos en Notas Importantes)
  - Determina el texto que aparece en "Estudio Ortodóntico" en el PDF generado
  - Los valores se mapean automáticamente en la generación del documento
- **acetate_print/paper_print:** Formato de impresión requerido
- **send_email:** Si debe enviarse por correo electrónico
- **status:** Estado actual de la orden
- **method:** Método de entrega (físico/digital)

### **GET /order/getall**
Obtener todas las órdenes activas.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "id": "uuid-order",
      "patient": "Juan Pérez García",
      "birthdate": "1985-06-15",
      "phone": "993-123-4567",
      "doctor": "Dr. María García",
      "address": "Calle Principal 123",
      "professional_id": "PROF123",
      "email": "juan@example.com",
      "acetate_print": true,
      "paper_print": false,
      "send_email": true,
      "packet": 1,
      "rx_panoramic": true,
      "rx_arc_panoramic": false,
      "rx_lateral_skull": false,
      "status": "solicitado",
      "method": "fisico",
      "code_ticket": "TK123456",
      "active": 1,
      "created_at": "2025-09-10",
      "updated_at": "2025-09-10"
    }
  ]
}
```

---

### **GET /order/getbyid/{id}**
Obtener orden por ID.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": {
    "id": "uuid-order",
    "patient": "Juan Pérez García",
    "birthdate": "1985-06-15",
    "phone": "993-123-4567",
    "doctor": "Dr. María García",
    "address": "Calle Principal 123",
    "email": "juan@example.com",
    "packet": 1,
    "rx_panoramic": true,
    "complete_tomography": false,
    "status": "solicitado",
    "method": "fisico",
    "code_ticket": "TK123456",
    "created_at": "2025-09-10"
  }
}
```

---

### **GET /order/getbyappointment/{id_appointment}**
Obtener órdenes por cita.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "id": "uuid-order",
      "patient": "Juan Pérez García",
      "doctor": "Dr. María García",
      "status": "solicitado",
      "created_at": "2025-09-10"
    }
  ]
}
```

---

### **GET /order/getbydoctor/{doctor_name}**
Obtener órdenes por doctor.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "id": "uuid-order",
      "patient": "Juan Pérez García",
      "doctor": "Dr. María García",
      "appointment_code": "APPT123",
      "status": "solicitado",
      "created_at": "2025-09-10"
    }
  ]
}
```

---

### **GET /order/getbystatus/{status}**
Obtener órdenes por estado.

**Valores válidos para status:**
- `solicitado`
- `en_proceso`
- `completado`
- `entregado`
- `cancelado`

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "id": "uuid-order",
      "patient": "Juan Pérez García",
      "doctor": "Dr. María García",
      "status": "solicitado",
      "created_at": "2025-09-10"
    }
  ]
}
```

---

### **GET /order/getbymethod/{method}**
Obtener órdenes por método.

**Valores válidos para method:**
- `fisico`
- `digital`

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "id": "uuid-order",
      "patient": "Juan Pérez García",
      "method": "fisico",
      "status": "solicitado"
    }
  ]
}
```

---

### **GET /order/getdetailsbyid/{id}**
Obtener detalles completos de orden.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": {
    "id": "uuid-order",
    "patient": "Juan Pérez García",
    "birthdate": "1985-06-15",
    "phone": "993-123-4567",
    "doctor": "Dr. María García",
    "address": "Calle Principal 123",
    "professional_id": "PROF123",
    "email": "juan@example.com",
    "acetate_print": true,
    "paper_print": false,
    "send_email": true,
    "packet": 1,
    "rx_panoramic": true,
    "rx_arc_panoramic": false,
    "complete_tomography": false,
    "clinical_photography": true,
    "status": "solicitado",
    "method": "fisico",
    "code_ticket": "TK123456",
    "dental_interpretation": "Revisión general",
    "created_at": "2025-09-10",
    "updated_at": "2025-09-10"
  }
}
```

---

### **GET /order/getticket/{id}**
Obtener información del ticket.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": {
    "ticket_info": "Generated successfully",
    "code_ticket": "TK123456"
  }
}
```

---

### **GET /order/generatedocument/{id}**
Generar y visualizar PDF del documento (inline).

**Response:** PDF inline en el navegador

---

### **GET /order/generatedocument/{id}/download**
Generar y descargar PDF del documento.

**Response:** PDF como descarga

---

### **GET /order/generateticket/{id}**
Generar y visualizar PDF del ticket (inline).

**Response:** PDF inline en el navegador

---

### **GET /order/generateticket/{id}/download**
Generar y descargar PDF del ticket.

**Response:** PDF como descarga

---

### **GET /order/generatedocumentbycode/{code}**
Generar PDF por código de cita (inline).

**Response:** PDF inline en el navegador

---

### **GET /order/generatedocumentbycode/{code}/download**
Generar PDF por código de cita (descarga).

**Response:** PDF como descarga

---

### **GET /order/generatedocumentbyorderid/{order_id}**
Generar PDF por ID de orden (inline).

**Response:** PDF inline en el navegador

---

### **GET /order/generatedocumentbyorderid/{order_id}/download**
Generar PDF por ID de orden (descarga).

**Response:** PDF como descarga

---

### **POST /order/create**
Crear nueva orden.

**Request:**
```json
{
  "patient": "Juan Pérez García",
  "birthdate": "1985-06-15",
  "phone": "993-123-4567",
  "doctor": "Dr. María García",
  "address": "Calle Principal 123",
  "professional_id": "PROF123",
  "email": "juan@example.com",
  "acetate_print": true,
  "paper_print": false,
  "send_email": true,
  "packet": 1,
  "rx_panoramic": true,
  "rx_arc_panoramic": false,
  "rx_lateral_skull": false,
  "ap_skull": false,
  "pa_skull": false,
  "paranasal_sinuses": false,
  "atm_open_close": false,
  "profilogram": false,
  "watters_skull": false,
  "palmar_digit": false,
  "others_radiography": "",
  "occlusal_xray": false,
  "superior": false,
  "inferior": false,
  "complete_periapical": false,
  "individual_periapical": false,
  "conductometry": false,
  "clinical_photography": true,
  "rickets": false,
  "mcnamara": false,
  "downs": false,
  "jaraback": false,
  "steiner": false,
  "others_analysis": "",
  "analysis_bolton": false,
  "analysis_moyers": false,
  "others_models_analysis": "",
  "risina": false,
  "dentalprint": false,
  "3d_risina": false,
  "surgical_guide": false,
  "studio_piece": "",
  "complete_tomography": false,
  "two_jaws_tomography": false,
  "maxilar_tomography": false,
  "jaw_tomography": false,
  "snp_tomography": false,
  "ear_tomography": false,
  "atm_tomography_open_close": false,
  "lateral_left_tomography_open_close": false,
  "lateral_right_tomography_open_close": false,
  "ondemand": "",
  "dicom": "",
  "tomography_piece": "",
  "implant": "",
  "impacted_tooth": "",
  "others_tomography": "",
  "stl": false,
  "obj": false,
  "ply": false,
  "invisaligh": false,
  "others_scanners": "",
  "maxilar_superior": false,
  "maxilar_inferior": false,
  "maxilar_both": false,
  "maxilar_others": "",
  "dental_interpretation": "Revisión general"
}
```

**Response (201):**
```json
{
  "status": "success",
  "msg": "Created",
  "data": {
    "id": "uuid-new-order",
    "code_ticket": "TK123456"
  }
}
```

---

### **POST /order/getbyticketcode/{ticket_code}**
Obtener orden por código de ticket.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": {
    "id": "uuid-order",
    "patient": "Juan Pérez García",
    "doctor": "Dr. María García",
    "code_ticket": "TK123456",
    "status": "solicitado"
  }
}
```

---

### **POST /order/getwithticketcode**
Obtener órdenes que tienen código de ticket.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "id": "uuid-order",
      "patient": "Juan Pérez García",
      "code_ticket": "TK123456",
      "status": "entregado",
      "created_at": "2025-09-10"
    }
  ]
}
```

---

### **PUT /order/update**
Actualizar orden.

**Request:**
```json
{
  "id": "uuid-order",
  "patient": "Juan Carlos Pérez García",
  "phone": "993-123-4567",
  "address": "Nueva Dirección 789",
  "packet": 2,
  "rx_panoramic": false,
  "complete_tomography": true,
  "dental_interpretation": "Actualización de interpretación"
}
```

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": true
}
```

---

### **PUT /order/updatestatus/{id}**
Actualizar estado de orden.

**Request:**
```json
{
  "status": "en_proceso"
}
```

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": true
}
```

---

### **PUT /order/updatemethod/{id}**
Actualizar método de orden.

**Request:**
```json
{
  "method": "digital"
}
```

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": true
}
```

---

### **DELETE /order/delete**
Eliminar orden.

**Request:**
```json
{
  "id": "uuid-order"
}
```

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": true
}
```

---

## 💳 **Payment (Pagos)**

### **POST /payment/create**
Crear nuevo pago.

**Request:**
```json
{
  "id_appointment": "uuid-appointment",
  "method": "efectivo",
  "amount": 1500.00,
  "status": "completado"
}
```

**Response (201):**
```json
{
  "status": "success",
  "msg": "Created",
  "data": {
    "id": "uuid-payment",
    "amount": 1500.00,
    "method": "efectivo"
  }
}
```

---

## 💰 **CashCut (Cortes de Caja)**

### **GET /cashcut/getall**
Obtener todos los cortes de caja.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "id": "uuid-cashcut",
      "id_user": "uuid-user",
      "id_subsidiary": "uuid-subsidiary",
      "start_date": "2025-09-10 08:00:00",
      "end_date": "2025-09-10 18:00:00",
      "total": 15000.00,
      "active": 1,
      "created_at": "2025-09-10",
      "updated_at": "2025-09-10"
    }
  ]
}
```

---

### **GET /cashcut/getbyid/{id}**
Obtener corte de caja por ID.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": {
    "id": "uuid-cashcut",
    "id_user": "uuid-user",
    "id_subsidiary": "uuid-subsidiary",
    "start_date": "2025-09-10 08:00:00",
    "end_date": "2025-09-10 18:00:00",
    "total": 15000.00,
    "active": 1
  }
}
```

---

### **GET /cashcut/cashcut-gains/{month}**
Obtener ganancias por mes.

**Ejemplo:** `/cashcut/cashcut-gains/2025-09`

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": {
    "month": "2025-09",
    "total_gains": 45000.00,
    "cashcuts_count": 15,
    "average_per_day": 1500.00
  }
}
```

---

### **GET /cashcut/cashcut-payments/{id}**
Obtener pagos de un corte de caja.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "id": "uuid-payment",
      "id_appointment": "uuid-appointment",
      "method": "efectivo",
      "amount": 1500.00,
      "status": "completado",
      "created_at": "2025-09-10 10:30:00"
    }
  ]
}
```

---

### **GET /cashcut/cashcut-payments-excel/{id}**
Exportar pagos de corte de caja a Excel.

**Response:** Archivo Excel descargable

---

### **GET /cashcut/cashcut-export-range/{dates}**
Exportar cortes de caja por rango de fechas.

**Ejemplo:** `/cashcut/cashcut-export-range/2025-09-01_2025-09-30`

**Response:** Archivo Excel descargable

---

### **GET /cashcut/cashcut-percent**
Obtener porcentajes por sucursal.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "subsidiary_name": "Sucursal Centro",
      "total": 25000.00,
      "percentage": 55.56
    },
    {
      "subsidiary_name": "Sucursal Norte",
      "total": 20000.00,
      "percentage": 44.44
    }
  ]
}
```

---

### **GET /cashcut/cashcut-top-services**
Obtener servicios más solicitados.

**Response (200):**
```json
{
  "status": "success",
  "data": [
    {
      "service": "Radiografía Panorámica",
      "count": 25,
      "percentage": 41.67
    },
    {
      "service": "Tomografía Completa",
      "count": 15,
      "percentage": 25.00
    }
  ]
}
```

---

### **GET /cashcut/data-home**
Obtener datos para dashboard.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": {
    "today_sales": 3000.00,
    "month_sales": 45000.00,
    "pending_orders": 12,
    "completed_orders": 48,
    "top_service": "Radiografía Panorámica"
  }
}
```

---

### **GET /cashcut/gains-week**
Obtener ganancias de la semana.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": {
    "week_total": 10500.00,
    "daily_breakdown": [
      {"date": "2025-09-09", "total": 1500.00},
      {"date": "2025-09-10", "total": 2000.00}
    ]
  }
}
```

---

### **POST /cashcut/create**
Crear nuevo corte de caja.

**Request:**
```json
{
  "id_user": "uuid-user",
  "id_subsidiary": "uuid-subsidiary",
  "start_date": "2025-09-10 08:00:00",
  "end_date": "2025-09-10 18:00:00",
  "total": 15000.00
}
```

**Response (201):**
```json
{
  "status": "success",
  "msg": "Created",
  "data": {
    "id": "uuid-cashcut",
    "total": 15000.00
  }
}
```

---

### **POST /cashcut/update-total**
Actualizar total de corte de caja.

**Request:**
```json
{
  "id": "uuid-cashcut",
  "total": 16500.00
}
```

**Response (201):**
```json
{
  "status": "success",
  "msg": "Created",
  "data": true
}
```

---

## 🛠️ **Service (Servicios)**

### **GET /service/getall**
Obtener todos los servicios.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "id": "uuid-service",
      "name": "Radiografía Panorámica",
      "id_subsidiary": "uuid-subsidiary",
      "description": "Radiografía panorámica completa",
      "price": 800.00,
      "active": 1,
      "created_at": "2025-09-10",
      "updated_at": "2025-09-10"
    }
  ]
}
```

---

### **GET /service/getbyid/{id}**
Obtener servicio por ID.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": {
    "id": "uuid-service",
    "name": "Radiografía Panorámica",
    "id_subsidiary": "uuid-subsidiary",
    "description": "Radiografía panorámica completa",
    "price": 800.00,
    "active": 1
  }
}
```

---

### **GET /service/getbysubsidiary/{id_subsidiary}**
Obtener servicios por sucursal.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "id": "uuid-service",
      "name": "Radiografía Panorámica",
      "description": "Radiografía panorámica completa",
      "price": 800.00,
      "active": 1
    }
  ]
}
```

---

### **POST /service/create**
Crear nuevo servicio.

**Request:**
```json
{
  "name": "Tomografía 3D",
  "id_subsidiary": "uuid-subsidiary",
  "description": "Tomografía tridimensional completa",
  "price": 2500.00
}
```

**Response (201):**
```json
{
  "status": "success",
  "msg": "Created",
  "data": {
    "id": "uuid-new-service",
    "name": "Tomografía 3D"
  }
}
```

---

### **PUT /service/update**
Actualizar servicio.

**Request:**
```json
{
  "id": "uuid-service",
  "name": "Radiografía Panorámica Digital",
  "description": "Radiografía panorámica digital de alta resolución",
  "price": 900.00
}
```

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": true
}
```

---

### **DELETE /service/delete**
Eliminar servicio.

**Request:**
```json
{
  "id": "uuid-service"
}
```

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": true
}
```

---

## 🏢 **Subsidiary (Sucursales)**

### **GET /subsidiary/getall**
Obtener todas las sucursales.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "id": "uuid-subsidiary",
      "id_user": "uuid-user",
      "name": "Sucursal Centro",
      "address": "Av. Principal 123, Centro",
      "active": 1,
      "created_at": "2025-09-10",
      "updated_at": "2025-09-10"
    }
  ]
}
```

---

### **GET /subsidiary/getbyid/{id}**
Obtener sucursal por ID.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": {
    "id": "uuid-subsidiary",
    "id_user": "uuid-user",
    "name": "Sucursal Centro",
    "address": "Av. Principal 123, Centro",
    "active": 1
  }
}
```

---

### **POST /subsidiary/create**
Crear nueva sucursal.

**Request:**
```json
{
  "id_user": "uuid-user",
  "name": "Sucursal Norte",
  "address": "Av. Norte 456, Zona Norte"
}
```

**Response (201):**
```json
{
  "status": "success",
  "msg": "Created",
  "data": {
    "id": "uuid-new-subsidiary",
    "name": "Sucursal Norte"
  }
}
```

---

### **PUT /subsidiary/update**
Actualizar sucursal.

**Request:**
```json
{
  "id": "uuid-subsidiary",
  "name": "Sucursal Centro Renovada",
  "address": "Av. Principal 123, Centro, Nueva Ubicación"
}
```

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": true
}
```

---

### **DELETE /subsidiary/delete**
Eliminar sucursal.

**Request:**
```json
{
  "id": "uuid-subsidiary"
}
```

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": true
}
```

---

## 📊 **Catalog (Catálogos)**

### **GET /catalog/getall/{table}**
Obtener catálogo de tabla específica.

**Ejemplo:** `/catalog/getall/services`

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "id": "uuid-item",
      "name": "Elemento del catálogo",
      "active": 1
    }
  ]
}
```

---

### **GET /catalog/getdoctors**
Obtener catálogo de doctores.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "id": "uuid-doctor",
      "name": "Dr. Juan",
      "lastname": "Pérez",
      "email": "doctor@example.com",
      "professional_id": "PROF123"
    }
  ]
}
```

---

### **GET /catalog/getclients**
Obtener catálogo de clientes.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "patient": "Juan Pérez García",
      "phone": "993-123-4567",
      "email": "juan@example.com",
      "last_visit": "2025-09-10"
    }
  ]
}
```

---

## 🔐 **Permission (Permisos)**

### **GET /permission/getall**
Obtener todos los permisos.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "id": 1,
      "name": "create_user",
      "description": "Crear usuarios",
      "active": 1,
      "created_at": "2025-09-10",
      "updated_at": "2025-09-10"
    }
  ]
}
```

---

### **GET /permission/getbyid/{id}**
Obtener permiso por ID.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": {
    "id": 1,
    "name": "create_user",
    "description": "Crear usuarios",
    "active": 1
  }
}
```

---

### **POST /permission/create**
Crear nuevo permiso.

**Request:**
```json
{
  "name": "manage_reports",
  "description": "Gestionar reportes del sistema"
}
```

**Response (201):**
```json
{
  "status": "success",
  "msg": "Created",
  "data": {
    "id": 25,
    "name": "manage_reports"
  }
}
```

---

### **PUT /permission/update**
Actualizar permiso.

**Request:**
```json
{
  "id": 1,
  "name": "create_user",
  "description": "Crear y gestionar usuarios del sistema"
}
```

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": true
}
```

---

### **DELETE /permission/delete**
Eliminar permiso.

**Request:**
```json
{
  "id": 25
}
```

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": true
}
```

---

## 👥 **Rol (Roles)**

### **GET /rol/getall**
Obtener todos los roles.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "id": 1,
      "name": "Administrador",
      "description": "Acceso completo al sistema",
      "active": 1,
      "created_at": "2025-09-10",
      "updated_at": "2025-09-10"
    }
  ]
}
```

---

### **GET /rol/getbyid/{id}**
Obtener rol por ID.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": {
    "id": 1,
    "name": "Administrador",
    "description": "Acceso completo al sistema",
    "active": 1
  }
}
```

---

### **POST /rol/create**
Crear nuevo rol.

**Request:**
```json
{
  "name": "Radiologista",
  "description": "Especialista en radiología"
}
```

**Response (201):**
```json
{
  "status": "success",
  "msg": "Created",
  "data": {
    "id": 5,
    "name": "Radiologista"
  }
}
```

---

### **PUT /rol/update**
Actualizar rol.

**Request:**
```json
{
  "id": 1,
  "name": "Super Administrador",
  "description": "Acceso completo y privilegios especiales"
}
```

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": true
}
```

---

### **DELETE /rol/delete**
Eliminar rol.

**Request:**
```json
{
  "id": 5
}
```

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": true
}
```

---

## 🔗 **RolPermission (Roles-Permisos)**

### **GET /rolpermission/getpermissionsbyrol/{id_rol}**
Obtener permisos de un rol.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "id": 1,
      "id_permission": 1,
      "id_rol": 1,
      "permission_name": "create_user",
      "permission_description": "Crear usuarios",
      "active": 1
    }
  ]
}
```

---

### **POST /rolpermission/create**
Crear nueva relación rol-permiso.

**Request:**
```json
{
  "id_permission": 1,
  "id_rol": 2
}
```

**Response (201):**
```json
{
  "status": "success",
  "msg": "Created",
  "data": {
    "id": 15,
    "id_permission": 1,
    "id_rol": 2
  }
}
```

---

### **POST /rolpermission/updatepermissions**
Actualizar permisos de un rol (batch).

**Request:**
```json
{
  "id_rol": 2,
  "permissions": [
    {"id_permission": "1", "id_rol": "2"},
    {"id_permission": "3", "id_rol": "2"},
    {"id_permission": "5", "id_rol": "2"}
  ]
}
```

**Response (200):**
```json
{
  "status": "success",
  "msg": "Permisos actualizados correctamente",
  "data": [
    {"id_permission": "1", "id_rol": "2"},
    {"id_permission": "3", "id_rol": "2"},
    {"id_permission": "5", "id_rol": "2"}
  ]
}
```

---

### **DELETE /rolpermission/delete**
Eliminar relación rol-permiso.

**Request:**
```json
{
  "id": 15
}
```

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": true
}
```

---

## 📁 **File (Archivos)**

### **GET /file/getfile/list**
Listar archivos en directorio docs.

**Response (200):**
```json
{
  "files": [
    "document_001.pdf",
    "document_002.pdf",
    "ticket_001.pdf"
  ]
}
```

---

### **GET /file/getfile/read/{filename}**
Leer contenido de archivo.

**Response (200):**
```json
{
  "content": "Base64 encoded file content..."
}
```

**Response (404):**
```json
{
  "error": "El archivo no existe"
}
```

---

### **GET /file/getfile/download/{filename}**
Descargar archivo PDF.

**Response:** PDF descargable

**Response (404):**
```json
{
  "error": "El archivo no existe"
}
```

---

### **GET /file/getfile/downloadbyid/{id}**
Descargar archivo PDF por ID.

**Response:** PDF descargable

**Response (404):**
```json
{
  "error": "El archivo no existe"
}
```

---

## 🏥 **Department (Departamentos)**

### **GET /department/departmentsByClinicId/{id}**
Obtener departamentos por ID de clínica.

**Response (200):**
```json
{
  "status": "success",
  "msg": "Fila(s) o Elemento(s) encontrada(s)",
  "data": [
    {
      "id": "uuid-department",
      "name": "Radiología",
      "clinic_id": "uuid-clinic",
      "active": 1
    }
  ]
}
```

---

### **POST /department/create**
Crear nuevo departamento.

**Request:**
```json
{
  "name": "Odontología",
  "clinic_id": "uuid-clinic",
  "description": "Departamento de odontología general"
}
```

**Response (201):**
```json
{
  "status": "success",
  "msg": "Created",
  "data": {
    "id": "uuid-new-department",
    "name": "Odontología"
  }
}
```

---

### **PUT /department/update**
Actualizar departamento.

**Request:**
```json
{
  "id": "uuid-department",
  "name": "Radiología Digital",
  "description": "Departamento de radiología digital avanzada"
}
```

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": true
}
```

---

### **DELETE /department/delete**
Eliminar departamento.

**Request:**
```json
{
  "id": "uuid-department"
}
```

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": true
}
```

---

## 🎓 **Especiality (Especialidades)**

### **GET /especiality/getall**
Obtener todas las especialidades.

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": [
    {
      "id": "uuid-specialty",
      "name": "Radiología Oral",
      "description": "Especialidad en radiología oral y maxilofacial",
      "active": 1,
      "created_at": "2025-09-10",
      "updated_at": "2025-09-10"
    }
  ]
}
```

---

### **POST /especiality/create**
Crear nueva especialidad.

**Request:**
```json
{
  "name": "Implantología",
  "description": "Especialidad en implantes dentales"
}
```

**Response (201):**
```json
{
  "status": "success",
  "msg": "Created",
  "data": {
    "id": "uuid-new-specialty",
    "name": "Implantología"
  }
}
```

---

### **PUT /especiality/update**
Actualizar especialidad.

**Request:**
```json
{
  "id": "uuid-specialty",
  "name": "Radiología Oral Avanzada",
  "description": "Especialidad avanzada en radiología oral y maxilofacial"
}
```

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": true
}
```

---

### **DELETE /especiality/delete**
Eliminar especialidad.

**Request:**
```json
{
  "id": "uuid-specialty"
}
```

**Response (200):**
```json
{
  "status": "success",
  "msg": "OK",
  "data": true
}
```

---

## 📝 **Notas Importantes**

### **🔢 Valores de Enums**

#### **Status de Órdenes:**
- `solicitado` - Orden recién creada
- `en_proceso` - Orden siendo procesada
- `completado` - Orden completada
- `entregado` - Orden entregada al cliente
- `cancelado` - Orden cancelada

#### **Métodos de Órdenes:**
- `fisico` - Entrega física
- `digital` - Entrega digital

#### **Métodos de Pago:**
- `efectivo` - Pago en efectivo
- `tarjeta` - Pago con tarjeta
- `transferencia` - Transferencia bancaria

#### **Tipos de Paquete (packet):**
- `0` - Personalizado (aparece como "Personalizado" en PDF)
- `1` - Paquete básico (aparece como "Básico" en PDF)
- `2` - Paquete básico digital (aparece como "Básico Digital" en PDF)
- `3` - Paquete premium (aparece como "3D con Tomografía" en PDF)

### **📅 Formato de Fechas**
- **Fechas:** `YYYY-MM-DD` (ej: `2025-09-15`)
- **Fechas con hora:** `YYYY-MM-DD HH:mm:ss` (ej: `2025-09-15 14:30:00`)

### **✅ Campos Booleanos**
Los campos booleanos se manejan como:
- `true` / `1` - Verdadero
- `false` / `0` - Falso

### **🏷️ Códigos de Barras y Tickets**
- **Códigos de Barras:** Se generan automáticamente para citas (ej: `APPT123`)
- **Códigos de Ticket:** Se generan para órdenes entregadas (ej: `TK123456`)
- **Archivos de Barras:** Se almacenan en `appointments-barcodes/` como PNG

### **📄 Archivos Generados**
- **PDFs de Documentos:** Generados dinámicamente
- **PDFs de Tickets:** Formato horizontal optimizado
- **Archivos Excel:** Para exportación de reportes

### **🔐 Estructura JWT**
```json
{
  "iss": "api.ceraor.com",
  "aud": "ceraor-users", 
  "iat": timestamp_issued,
  "exp": timestamp_expiration,
  "data": {
    "id": "user_uuid",
    "email": "user_email"
  },
  "permissions": {
    "permissions": "comma,separated,permissions"
  }
}
```

### **❌ Respuestas de Error Comunes**

#### **401 No Autorizado:**
```json
{
  "status": false,
  "msg": "No autorizado"
}
```

#### **404 No Encontrado:**
```json
{
  "status": false,
  "msg": "Not Found"
}
```

#### **400 Solicitud Incorrecta:**
```json
{
  "status": false,
  "msg": "Bad Request"
}
```

#### **500 Error Interno:**
```json
{
  "status": false,
  "msg": "Internal Server Error"
}
```

### **🎯 Endpoints sin Autenticación**
- `/user/login` - Inicio de sesión
- `/user/getinstance/{id}` - Obtener instancia de usuario
- `/order/generatedocument/*` - Generación de PDFs (todos los métodos)
- `/order/generateticket/*` - Generación de tickets (todos los métodos)
- `/order/generatedocumentbycode/*` - Generación por código
- `/order/generatedocumentbyorderid/*` - Generación por ID de orden

### **📱 Códigos de Ejemplo**
- **UUID:** `c27482d7-df09-4a5e-b8c3-1234567890ab`
- **Código de Cita:** `APPT123`
- **Código de Ticket:** `TK123456`
- **Código de Barras:** `APPT123.png`

---

**© 2025 CERAOR - Centro de Radiología Oral y Maxilofacial**  
**Documentación Técnica v1.0**
