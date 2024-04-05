# Techneek

## Desarrollo

### Uso

Podemos usar un solo comando para servir nuestro proyecto. El comando sería

``` bash
docker-compose up --build
```

Sin embargo, necesitamos tener estos pre-requisitos:

- Un dump de la base de datos. Ubicar en un archivo llamado `dump.sql`.
- Un archivo con variables de entorno `.env` correctamente configurado

### Deuda técnica

1. Se encuentran hardcodeadas las url `https://techneek.com/sistema` en muchos lados y/o archivos JS. Se recomienda compilar con Vite y extraer a variables de entorno
2. Re-ordenar el sitio y la manera de servir los assets (JS, archivos basura innecesarios)
3. Compilar archivos desde Vite / Node.
4. Generar dependencias externas (vendor, node modules, google calendar / vendor) almacenadas en el repo
5. Agregar documentación de la configuración de contenedores, variables de entorno `.env.example` y despliegue. Explicar variables del `.env`
6. Pipelines de infra y despliegue

> Opcional: Agregar variables de entorno desde docker-compose para desarrollo

## Despliegue