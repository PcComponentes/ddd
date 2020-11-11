# DDD Mini Framework.
Pequeño framework para desarrollar aplicaciones mediante una arquitectura ES (event sourcing) + DDD (Domain Driven Design) + CQRS (command query responsability segregation), centrada en la parte de escritura.


## 1. Teoría
A continuación, se explicarán los conceptos fundamentales de cómo diseñar una aplicación usando este framework, principios que son recomendables de seguir, aunque no obligatorios.

### 1.1 Arquitectura hexagonal
El diseño de la aplicación deberá seguir las recomendaciones de la arquitectura hexagonal mediante tres capas principales, aplicación, dominio e infraestructura. Y dos capas auxiliares, para utilidades y puntos de acceso.

```
├─ Application
├─ Domain
├─ Infrastructure
├─ EntryPoint
└─ Util
```
El diseño estará repartido en:
- ```Aplication``` contendrá los comandos, handlers, cuyo objetivo es convertir peticiones externas, en peticiones a tu capa de dominio.
- ```Domain``` contendrá la lógica de negocio repartida en modelos y servicios de dominio.
- ```Infrastructure``` contendrá la implementación en tecnologías o servicios externos concretos de las dependencias de tu capa de dominio, como por ejemplo, los repositorios (para mongo, mysql, postgresql, etc).
- ```Util``` contendrá utilidades genéricas propensas a ser usadas en cualquier capa.
- ```EntryPoint``` estarán todos los puntos de acceso a los servicios de tu aplicación, como pueden ser comandos de consola, y controladores para peticiones vía API HTTP, etc.

Y las normas son:
- ```Entrypoint``` gestiona el problema de la inyección de dependencias con recursos como los contenedores de dependencias, el cual se encargará de inyectar las instancias de infrastructura a servicios de dominio; y éstos, a los de aplicación.
 - ```EntryPoint``` sólo puede usar clases de la capa de aplicación.
- ```Aplication``` sólo puede usar clases de la capa de dominio.
- ```Domain``` es totalmente independiente, y no conoce a nada que esté fuera (excepto utilidades).

Las herramientas que se proporcionan en este mini framework, ayudan en algunos de estos puntos.

### 1.2 Event Sourcing
La capa de dominio se compone de modelos (o entidades) mutables y ricos, con servicios e interfaces de repositorio que los persisten vía peticiones CRUD a una tabla concreta de dicho modelo. Event sourcing va mas allá, y consiste en persistir en una única tabla todos los eventos que ocurran en tu dominio de negocio. Los modelos se montarán ejecutando secuencialmente dichos eventos.

Este modelo, se le suele conocer como agregado raíz, y puede estar compuesto por otros pequeños modelos, conocidos como agregados, que no puede ser gestionados de forma independiente fuera de este agregado raíz.
Todas las operaciones realizadas sobre el modelo generarán un evento. La idea es invertir este proceso, y que sea el evento mismo, el que ejecute la operación sobre un modelo.

### 1.3 Asincronidad: Escritura VS Lectura
Los eventos persistidos no son una forma eficiente de realizar operaciones de lectura sobre los datos de tu negocio, así que esta arquitectura prácticamente obliga a realizar CQRS desde el principio. Se recomienda tener el sistema de escritura totalmente independiente del sistema de lectura; y la comunicación entre estos dos sistemas, basada totalmente en una cola de mensajería consumida de forma asíncrona.

En resumen, el sistema de escritura carga sus modelos leyendo eventos persistidos, y sus operaciones persiste y lanza nuevos eventos a un sistema de mensajería (rabbitMQ por ejemplo). Asíncronamente, los jobs (cron o worker) del sistema de lectura consumirá esos eventos con la intención de generar y persistir sus propios modelos de lectura, también conocidos como proyecciones. Estas proyecciones suelen ser persistidas en bases de datos orientadas a búsquedas complejas, como mongo, o elastic search.

Desde que se lanza el evento, hasta que una proyección se lo aplica, va a pasar un margen de tiempo, donde el sistema de lectura tenga los datos desincronizados. A este problema se le conoce como consistencia eventual, y uno de las muchas tareas del programador es reducir este margen al mínimo, y gestionar conscientemente esta inevitable casuística cuando diseñe soluciones.

También puede ser interesante que el sistema de escritura tenga sus propios consumidores de la cola de eventos, para desacoplar tareas y generar comandos que se ejecutarán igualmente de forma asíncrona. Todo es cuestión de cómo diseñes tu aplicación.

Esta librería no trae utilidades significativas orientadas al sistema de lectura.

## 2. Comenzando
Este es un pequeño tutorial para conocer poco a poco las partes que componen esta librería.
 
---POR HACER---
