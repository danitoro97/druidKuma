# Instrucciones de instalación y despliegue

## En local
1. Crear un sitio virtual
2. El documentroot debe ser la carpeta web
3. Configurar variables de entorno en Apache con  SetEnv VARIABLE_NAME variable_value



## En la nube

En Heroku
1. Crear nueva app
2. Conectamos con github
3. Enlazar tu repositorio git con heroku (en nuestro repositorio git)
	heroku apps
	heroku git:remote --app nombre aplicacion
4. Configurar variables de entorno
