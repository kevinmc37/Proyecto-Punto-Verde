# ♻️ Green Point Waste Management System (Deixalleria)

---

### 📌 Navigation / Navegación
[🇺🇸 English](#english-version) | [🇪🇸 Español](#versión-en-español) | [📸 Diagrams / Diagramas](#diagrams-section)

---

## <a name="english-version"></a>🇺🇸 English Version

A basic full-stack enterprise web application prototype designed to classify, manage, and track municipal waste recycling data across multiple green points (*deixalleries*) in Catalonia. 

**Note: This project is featured as a stable, historical development sample. It showcases backend architectural foundations, database modeling, and third-party library integrations in an early-stage production-like environment using temporary UI structures.**

Built using an Object-Oriented Programming (OOP) approach in **PHP**, this platform enables municipal administrators and operators to register incoming waste, generate official delivery notes, export structured data, and maintain strict analytical control over waste streams (including household, special, and RAEE electronic waste).

### 🛠️ Technical Highlights & Architecture

*   **Object-Oriented Domain Layer:** The backend features a modular class architecture (`Administracio`, `Municipis`, `Deixalles`, `Usuaris`, `Raes`, etc.) that cleanly maps physical entities into testable, scalable PHP objects.
*   **Secure Data Access Layer:** Built around a dedicated database management class (`DB.php`) to handle connections, configurations, and queries efficiently.
*   **Automated Document Reporting:** Integrates `FPDF` to dynamically generate official physical delivery notes and receipts (`albaran.php`) for waste transfers.
*   **Data Export & Analytics Engine:** Implements `PHPExcel` to compile complex administrative logs into structured Excel sheets (`excel.php`) for municipal auditing.
*   **Dynamic UX & Accessibility Framework:** Uses Bootstrap and jQuery for responsive data filtering (`search.js`) paired with dedicated accessibility modules (`accessibility.js`) ensuring compliance with inclusive design guidelines.

### 🔒 Security & Evolution Notes
As an early-stage legacy prototype, database queries are handled via raw standard SQL statements. In a modern production environment, this architecture would be refactored to use **PDO (PHP Data Objects) and Prepared Statements** to strictly prevent SQL Injection (SQLi) vulnerabilities and enforce enterprise-grade data sanitization.

### 🚀 Technologies Used

*   **Backend Core:** PHP & Object-Oriented Software Design
*   **IDE & Environment:** NetBeans
*   **Database:** MySQL / MariaDB (Relational Model)
*   **Frontend & Utilities:** Bootstrap, jQuery, Custom Vanilla JS/CSS Placeholders
*   **Libraries:** PHPExcel 1.8 (Data Exports), FPDF 1.81 (PDF Generation)

---

## <a name="versión-en-español"></a>🇪🇸 Versión en Español

Un prototipo básico de aplicación web de gestión corporativa (*Enterprise*) diseñada para la clasificación, registro y seguimiento de la recogida de residuos en múltiples puntos verdes (*deixalleries*) de varios municipios de Cataluña.

**Nota: Este proyecto se presenta como una muestra de desarrollo histórico y estable, enfocado en ilustrar bases sólidas de arquitectura backend, modelado de bases de datos relacionales e integración de herramientas de terceros bajo una interfaz modular estructurada con componentes temporales.**

Desarrollada bajo el paradigma de Programación Orientada a Objetos (POO) en **PHP**, la plataforma permite a los administradores y operarios municipales registrar entradas de residuos, generar albaranes oficiales, exportar datos analíticos y mantener un control estricto sobre los flujos de materiales (asimilables, especiales y RAEEs).

### 🛠️ Aspectos Técnicos Destacados y Arquitectura

*   **Capa de Dominio Orientada a Objetos:** El backend cuenta con una arquitectura de clases modular (`Administracio`, `Municipis`, `Deixalles`, `Usuaris`, `Raes`, etc.) que mapea con precisión las entidades físicas del negocio en objetos PHP reutilizables.
*   **Capa de Acceso a Datos Segura:** Centralizada en una clase de gestión de base de datos dedicada (`DB.php`) encargada de administrar las conexiones, configuraciones y consultas de manera eficiente.
*   **Generación Automatizada de Reportes:** Integración de la librería `FPDF` para renderizar dinámicamente albaranes y justificantes físicos oficiales (`albaran.php`) durante las descargas de residuos.
*   **Motor de Exportación Analítica:** Implementación de `PHPExcel` para compilar los históricos y registros administrativos directamente en hojas de cálculo nativas (`excel.php`) para auditorías municipales.
*   **Interfaz Dinámica y Accesibilidad:** Uso de Bootstrap y jQuery para el filtrado dinámico de datos en tiempo real (`search.js`), combinado con módulos específicos de accesibilidad (`accessibility.js`) para garantizar el cumplimiento de estándares de diseño inclusivo.

### 🔒 Notas de Seguridad y Evolución
Al tratarse de un prototipo clásico e histórico, las consultas a la base de datos se gestionan mediante sentencias SQL directas. En un entorno de producción actual, esta arquitectura se refactorizaría utilizando **PDO (PHP Data Objects) y Sentencias Preparadas** para mitigar por completo vulnerabilidades de Inyección SQL (SQLi) y garantizar la sanitización de datos.

### 🚀 Tecnologías Utilizadas

*   **Núcleo Backend:** PHP y Diseño de Software Orientado a Objetos (POO)
*   **IDE y Entorno:** NetBeans
*   **Base de Datos:** MySQL / MariaDB (Modelo Relacional)
*   **Frontend y Utilidades:** Bootstrap, jQuery, componentes visuales temporales (Placeholders)
*   **Librerías:** PHPExcel 1.8 (Exportación de datos), FPDF 1.81 (Generación de PDF)

---

## <a name="diagrams-section"></a>📸 Architecture & Diagrams / Arquitectura y Diagramas

Below are the relational and structure models defining the platform's database schema / A continuación se muestran los modelos relacionales que definen el esquema de la base de datos de la plataforma:

### Database Blueprint / Diseño de la Base de Datos
<p align="center">
  <img src="https://raw.githubusercontent.com/kevinmc37/Proyecto-Punto-Verde/refs/heads/main/Deixalleria/diagrama.png" max-width="100%" width="900" alt="Database Diagram">
</p>

### Relational Entity Model / Modelo Entidad-Relación
<p align="center">
  <img src="https://raw.githubusercontent.com/kevinmc37/Proyecto-Punto-Verde/refs/heads/main/Deixalleria/model.png" max-width="100%" width="900" alt="Entity Relation Model">
</p>

*The schema implements clean foreign key relationships ensuring strict cascading and data integrity across towns, users, and classified waste categories.*  
*El esquema implementa relaciones limpias mediante claves foráneas garantizando la integridad referencial y operaciones en cascada entre municipios, usuarios y las categorías de residuos clasificadas.*
