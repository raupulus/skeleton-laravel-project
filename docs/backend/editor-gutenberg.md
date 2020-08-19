# Editor Gutenberg de Wordpress

Este editor se encuentra en el siguiente repositorio:
https://github.com/VanOns/laraberg

## ¿Por qué este editor?

Buscaba una solución visual y sencilla a la creación y edición de contenido que
no distara demasiado de wordpress por ser tan conocido.

## Assets para utilizar el editor.

```html
<link rel="stylesheet" href="{{asset('vendor/laraberg/css/laraberg.css')}}" />
<script src="{{ asset('vendor/laraberg/js/laraberg.js') }}"></script>
```

## Dependencias necesarias para el editor

```html
<script src="https://unpkg.com/react@16.8.6/umd/react.production.min.js"></script>
<script src="https://unpkg.com/react-dom@16.8.6/umd/react-dom.production.min.js"></script>
```


## Inicializar el editor con y sin datos

```html
<textarea id="[id_here]" name="[name_here]" hidden></textarea>
<textarea id="[id_here]" name="[name_here]" hidden>{{$model->getRawContent()}}</textarea>
```
