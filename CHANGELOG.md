# 📑 Changelog

Todas las modificaciones notables de este proyecto se documentarán en este archivo.  
El formato está basado en [Keep a Changelog](https://keepachangelog.com/es-ES/1.0.0/)  
y este proyecto adhiere a [Semantic Versioning](https://semver.org/lang/es/).

---

## [0.2.0] - 2025-09-25

### 🐞 Fixed

- **BodyItem**: ahora se permite crear facturas sin el array de `taxes`, aplicable a facturas de consumidor final.

### 🔄 Changed

- Se reemplazó el método de construcción de facturas basado en instanciación directa de clases (`BodyItem`, `PaymentItem`, etc.) por un patrón más declarativo con métodos agrupados, que facilita la lectura y mantenimiento del código.
- Se modificó el **proceso de autenticación del token** para mejorar la seguridad:
  - Ahora se usan `client_id` y `client_secret` de la configuración en lugar de la variable de entorno `BILLER_TOKEN`.  
  - La sesión es gestionada completamente por el SDK.  
  - Se permite implementar libremente la persistencia del token mediante la interfaz `TokenStorageInterface`, que puede inyectarse en `ClientGuzzleHttp`.  

### 🗑️ Removed

- Se removio la variable de entorno ```BILLER_TOKEN``` por ser obsoleta.
- El flujo antiguo de construcción de facturas mediante instanciación manual de clases ya no es válido.

---

## [0.1.0] - 2025-09-04

### 🚀 Added

- Versión inicial del **SDK Biller**.
- Configuración mediante `.env`, `.php` o `.json`.
- Cliente HTTP basado en `GuzzleHttp`.
- Envío de facturas electrónicas con `FEBuilder`.
- Ejemplo de integración en README.

---

## Leyenda de etiquetas

- **Added**: Nueva funcionalidad.  
- **Changed**: Cambios en funciones existentes.  
- **Deprecated**: Funciones que se dejarán de usar pronto.  
- **Removed**: Funciones eliminadas.  
- **Fixed**: Bugs corregidos.  
- **Security**: Cambios relacionados a seguridad.  
