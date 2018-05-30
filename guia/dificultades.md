# Dificultades encontradas

Al añadir la funcionalidad (R38) Añadir img a su plantilla , para que el usuario pudisese dibujar sobre esa imagen.
Me encontre con un problema de seguridad CORS por el cual no podia manipular las imagenes subida por el usuario.
Dropbox tiene dos tipos de enlaces preview y direct con este ultimo no tengo problamos de CORS pero no es un enlace
permanente , con lo cual tengo que almacenar la imagen con un enlace de tipo preview y a la hora de añadirlo al canvas
de dibujo convertirlo a un enlace direct.
