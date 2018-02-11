# Comando Artisan para crear un recurso de vistas blade e agregarle un controlador y un modelo

El comando `php artisan make:resource-view categories` creará una carpeta llamada __categories__. Dentro de la misma también se crearán los siguientes archivos: 

* __index.blade.php__
* __create.blade.php__
* __show.blade.php__
* __edit.blade.php__

### Cada una de las vistas blade tendrá el siguiente código
![Texto alternativo](https://image.ibb.co/m6n6Y7/Screen_Shot_02_10_18_at_06_09_PM.png "Título alternativo")

### Funcionalidades adicionales del comando

__El comando `php artisan make:resource-view` acepta las siguientes opciones__

1. __-m__, __--model__    Crea el modelo para el recurso
2. __-r__, __--resource__ Crea el controlador del recurso
3. __-p__, __--path__     Agrega las rutas para el recurso en el archivo de rutas web.php

## Crear un nuevo recurso y además agregarle el controlador y el modelo.

Para agregar un nuevo recurso junto con su controlador y modelo, sólo tenemos que ejecutar el siguiente comando:

`php artisan make:resource-view categories --model --resource --path`

También podemos ejecutar `php artisan make:resource-view posts -m -r -p` y sería el mismo resultado.

## El comando nos generará lo siguiente

![Texto alternativo](https://image.ibb.co/h5Qofn/Screen_Shot_02_10_18_at_05_35_PM.png "Título alternativo")

Y además nos agregará a nuestro archivo de rutas las siguientes líneas de código:

`// Path resource for categories `

`Route::resource('categories', 'CategoryController');
`

