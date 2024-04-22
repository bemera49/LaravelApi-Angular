Aplicación de Ejemplo: Laravel API y Angular Frontend
Este repositorio contiene el código fuente de una aplicación web que utiliza Laravel para desarrollar una API RESTful en el backend y Angular en el frontend. La combinación de estas dos tecnologías permite crear una aplicación web moderna y escalable.

Requisitos
PHP >= 7.3
Composer
Node.js >= 10.x
npm >= 6.x
MySQL >= 5.7
Configuración del Backend (Laravel API)
Clona este repositorio en tu máquina local.
Navega a la carpeta backend desde la línea de comandos.
Copia el archivo .env.example a .env y configura los detalles de la base de datos.
Ejecuta composer install para instalar las dependencias de PHP.
Ejecuta php artisan key:generate para generar una nueva clave de aplicación.
Ejecuta php artisan migrate para migrar la base de datos.
Opcionalmente, puedes ejecutar php artisan db:seed para poblar la base de datos con datos de prueba.
Configuración del Frontend (Angular)
Navega a la carpeta frontend desde la línea de comandos.
Ejecuta npm install para instalar las dependencias de Node.js.
Si es necesario, ajusta la configuración de la API en src/environments/environment.ts.
Ejecuta ng serve para iniciar el servidor de desarrollo de Angular.
Uso
Una vez que el backend y el frontend estén configurados y en ejecución, puedes acceder a la aplicación visitando http://localhost:4200 en tu navegador web.

Contribuir
Si deseas contribuir a este proyecto, ¡eres bienvenido! Siéntete libre de abrir un issue o enviar un pull request.

Licencia
Este proyecto está bajo la licencia MIT. Para más detalles, consulta el archivo LICENSE
