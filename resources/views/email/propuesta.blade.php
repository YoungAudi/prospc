@component('mail::message')
# Hola {{$prospecto->nombre}}
## Esta es la propuesta ({{$propuesta->nombre}}) para el evento {{$evento->nombre}}.
### Se te anexo la propuesta (propuesta.pdf) @if($propuesta->adjuntos->count() > 0) y otros adjuntos adicionales @endif .
@endcomponent