# API Rest Backend en Laravel para el Sistema de Predicción de Animalitos

Este proyecto es una API Rest desarrollada en Laravel que sirve como el núcleo backend para un sistema de predicción de resultados de "Animalitos". Su principal objetivo es orquestar y gestionar las solicitudes provenientes del frontend, así como procesar los resultados históricos para realizar cálculos estadísticos, analíticos y probabilísticos que permitan generar predicciones para los próximos sorteos.

## Características principales

- **Gestión de solicitudes**: Manejo eficiente de las solicitudes provenientes del frontend.
- **Procesamiento de datos históricos**: Análisis de resultados previos para extraer patrones y tendencias.
- **Cálculos estadísticos y probabilísticos**: Generación de predicciones basadas en datos históricos.
- **Arquitectura escalable**: Construido sobre Laravel, lo que garantiza una estructura modular y mantenible.

## Requisitos previos

Asegúrate de tener instalados los siguientes componentes antes de comenzar:

- PHP >= 8.0
- Composer
- MySQL o cualquier otra base de datos compatible
- Node.js y npm (para la gestión de dependencias del frontend si es necesario)

## Instalación

1. Clona este repositorio:

   ```bash
   git clone https://github.com/Alexis79Bck/animalitos-predictions-system.git
   cd animalitos-predictions-system/backend-api
   ```

2. Instala las dependencias de PHP usando Composer:

   ```bash
   composer install
   ```

3. Configura el archivo `.env`:

   - Copia el archivo de ejemplo:
     ```bash
     cp .env.example .env
     ```
   - Configura las variables de entorno, como la conexión a la base de datos.

4. Genera la clave de la aplicación:

   ```bash
   php artisan key:generate
   ```

5. Ejecuta las migraciones para crear las tablas necesarias en la base de datos:

   ```bash
   php artisan migrate
   ```

6. (Opcional) Si necesitas datos de prueba, ejecuta los seeders:

   ```bash
   php artisan db:seed
   ```

7. Inicia el servidor de desarrollo:

   ```bash
   php artisan serve
   ```

   La API estará disponible en `http://localhost:8000`.

## Estructura del proyecto

- `app/`: Contiene los controladores, modelos y lógica de negocio.
- `routes/`: Define las rutas de la API.
- `database/`: Incluye migraciones, seeders y datos de prueba.
- `config/`: Archivos de configuración del proyecto.
- `tests/`: Pruebas unitarias y funcionales.

## Endpoints principales

A continuación, se describen algunos de los endpoints más importantes de la API:

- **GET /api/predictions**: Obtiene las predicciones para el próximo sorteo.
- **POST /api/results**: Registra los resultados de un sorteo.
- **GET /api/history**: Recupera los datos históricos de sorteos.

Consulta la documentación completa de la API para más detalles sobre los endpoints y sus parámetros.

## Pruebas

Ejecuta las pruebas para asegurarte de que todo funciona correctamente:

```bash
php artisan test
```

## Contribuciones

Si deseas contribuir a este proyecto, por favor sigue estos pasos:

1. Haz un fork del repositorio.
2. Crea una nueva rama para tu funcionalidad o corrección de errores:
   ```bash
   git checkout -b feature/nueva-funcionalidad
   ```
3. Realiza tus cambios y haz commit:
   ```bash
   git commit -m "Descripción de los cambios"
   ```
4. Envía tus cambios al repositorio remoto:
   ```bash
   git push origin feature/nueva-funcionalidad
   ```
5. Abre un Pull Request en GitHub.

## Licencia

Este proyecto está licenciado bajo la Licencia Apache 2.0. Consulta el archivo `LICENSE` para más detalles.
