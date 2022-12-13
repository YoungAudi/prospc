@extends('layout.auth')

@section('title', 'Ingresar')

@section('content')
<form class="form w-100 md-pt-10" novalidate="novalidate" id="login_form" tt-redirect-url="{{route('prospectos.index')}}" action="{{route('auth.login.process')}}">
	<div class="text-center mb-11 mt-4">
		<h1 class="text-dark fw-bolder mb-3">Inicia Sesión</h1>
		<div class="text-gray-500 fw-semibold fs-6">Accede con tus credenciales</div>
	</div>
	<x-forms.input mb="mb-3" placeholder="Correo/Usuario" name="email" />
	<x-forms.input mb="mb-3" type="password" placeholder="Contraseña" name="password" />
	<div class="d-grid">
		<x-forms.submit text="Ingresa" classes="btn-sm" />
	</div>
</form>
@endsection

@push('js')
<script>
KTUtil.onDOMContentLoaded(function() {
	TTValidate.init(document.querySelector('#login_form'), {					
		'email': {
			validators: {
				notEmpty: {
					message: 'El email/usuario no puede estar vacio'
				}
			}
		},
		'password': {
			validators: {
				notEmpty: {
					message: 'La contraseña no puede estar vacia'
				}
			}
		} 
	});
});
</script>
@endpush