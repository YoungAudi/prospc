@extends('layout.app')

@section('title', 'Prospectos')
@section('page-title', 'Prospectos')
@section('page-subtitle', 'Lista de prospectos')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header border-0 pt-5">
				<h3 class="card-title ">
					Prospectos
				</h3>
				<div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Da clic para crear un nuevo prospecto">
					<button class="openModal btn btn-sm btn-light btn-active-primary">
					<span class="svg-icon svg-icon-3">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
						<rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
						</svg>
					</span>Nuevo Prospecto</button>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="table" class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
						<thead>
							<tr class="fw-bold text-muted">
								<th>ID</th>
								<th>Nombre</th>
								<th>Área</th>
								<th>Empresa</th>
								<th>Teléfono</th>
								<th>Email</th>
								<th>Estado</th>
								<th>Ciudad</th>
								<th>Fecha de creación</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('modals')
<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <form class="modal-content" id="form" action="#">
            <div class="modal-header">
                <h3 class="modal-title"></h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-circle fs-2x"></i>
                </div>
            </div>
            <div class="modal-body">
            	@method('POST')
            	<x-forms.input mb="mb-3" placeholder="Nombre" name="nombre" />
            	<x-forms.input mb="mb-3" placeholder="Área" name="area" />
            	<x-forms.input mb="mb-3" placeholder="Empresa" name="empresa" />
            	<x-forms.input mb="mb-3" placeholder="Teléfono" name="telefono" />
            	<x-forms.input mb="mb-3" placeholder="Email" type="email" name="email" />
            	<x-forms.input mb="mb-3" placeholder="Estado" name="estado" />
            	<x-forms.input mb="mb-3" placeholder="Ciudad" name="ciudad" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <x-forms.submit text="Enviar" />
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modalEvento" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" id="formEvento" action="#">
            <div class="modal-header">
                <h3 class="modal-title">Crear Evento</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-circle fs-2x"></i>
                </div>
            </div>
            <div class="modal-body">
            	@method('POST')
            	<x-forms.input mb="mb-3" placeholder="Nombre del evento" name="nombre" />
            	<x-forms.input mb="mb-3" placeholder="Descripción" name="descripcion" />
            	<x-forms.input mb="mb-3" label="Fecha" placeholder="Fecha" type="date" name="fecha" />
            	<x-forms.select mb="mb-3" :select2="false" placeholder="Tipo de evento" name="tipo" :options="['publico' => 'Público', 'privado' => 'Privado']"/>
            	<input type="hidden" name="prospecto_id" id="prospecto_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <x-forms.submit text="Enviar" />
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
	var modalContainer, modalEventoContainer, modal, theForm, openModal, theFormTitle, modalEvento, formEvento, prospecto_id;
	prospecto_id = document.getElementById('prospecto_id');
	theForm = document.getElementById('form');
	formEvento = document.getElementById('formEvento');
	theFormTitle = theForm.querySelector('.modal-title');
	theFormMethod = theForm.querySelector('input[name="_method"]');
	openModal = document.querySelector('.openModal');
	KTUtil.onDOMContentLoaded(function() {
		modalEventoContainer = document.getElementById('modalEvento');
		modalEvento = new bootstrap.Modal(modalEventoContainer, {
			keyboard: false,
			backdrop: 'static'
		});

		modalContainer = document.getElementById('modal');
		modal = new bootstrap.Modal(modalContainer, {
			keyboard: false,
			backdrop: 'static'
		});
		openModal.addEventListener('click', (evt) => {
			theForm.action = '{{route("prospectos.store")}}';
			theForm.reset();
			theFormTitle.innerHTML = 'Nuevo Prospecto';
			theFormMethod.value = 'POST';
			modal.show();
		});
		TTValidate(theForm, {					
			'nombre': {
				validators: {
					notEmpty: {message: 'Debes de ingresar un nombre.'},
					stringLength: {max:255,message: 'El campo debe tener máximo 255 caracteres.'}
				}
			},
			'area': {
				validators: {
					stringLength: {max:255,message: 'El campo debe tener máximo 255 caracteres.'}
				}
			},
			'empresa': {
				validators: {
					stringLength: {max:255,message: 'El campo debe tener máximo 255 caracteres.'}
				}
			},
			'email': {
				validators: {
					// notEmpty: {message: 'Debes de ingresar un email.'},
					stringLength: {max:255,message: 'El campo debe tener máximo 255 caracteres.'},
					emailAddress: {message: 'El campo debe ser un email valido.'},
				}
			},
			'estado': {
				validators: {
					notEmpty: {message: 'Debes de ingresar un estado.'},
					stringLength: {max:255,message: 'El campo debe tener máximo 255 caracteres.'}
				}
			},
			'ciudad': {
				validators: {
					notEmpty: {message: 'Debes de ingresar una ciudad.'},
					stringLength: {max:255,message: 'El campo debe tener máximo 255 caracteres.'}
				}
			},
			'telefono': {
				validators: {
					stringLength: {max:14,message: 'El campo debe tener máximo 14 caracteres.'}
				}
			},
		}, null, () => {
			modal.hide();
			table_table.ajax.reload();
		});

		TTValidate(formEvento, {					
			'nombre': {
				validators: {
					notEmpty: {message: 'Debes de ingresar un nombre.'},
					stringLength: {max:255,message: 'El campo debe tener máximo 255 caracteres.'}
				}
			},
			'descripcion': {
				validators: {
					// notEmpty: {message: 'Debes de ingresar una descripción.'},
					stringLength: {max:255,message: 'El campo debe tener máximo 255 caracteres.'},
				}
			},
			'tipo': {
				validators: {
					notEmpty: {message: 'Debes de seleccionar el tipo de evento.'},
				}
			},
			'fecha': {
				validators: {
					notEmpty: {message: 'Debes de ingresar una fecha.'}
				}
			},
		}, null, () => {
			modalEvento.hide();
			// table_table.ajax.reload();
		});
	});
</script>

<x-datatable id="table" :route="route('prospectos.index')">
	[{data: 'id', name: 'id'},
	{data: 'nombre', name: 'nombre'},
	{data: 'area', name: 'area'},
	{data: 'empresa', name: 'empresa'},
	{data: 'telefono', name: 'telefono'},
	{data: 'email', name: 'email'},
	{data: 'estado', name: 'estado'},
	{data: 'ciudad', name: 'ciudad'},
	{data: 'creacion', name: 'creacion'},
	{render: function(data, type, row, meta) {
		return `<div class="d-flex align-items-start">
			<button for-id="${row['id']}" class="text-nowrap eventos btn btn-warning btn-sm me-1">
				Crear Evento
			</button>
			<button tt-id="${row['id']}" class="ms-2 update btn btn-icon btn-bg-light btn-active-color-warning btn-sm me-1">
				<span class="svg-icon svg-icon-3">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />
						<path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
					</svg>
				</span>
			</button>
			<form class="ms-2 eliminar" action="${row['deleteRoute']}">
				<input type="hidden" name="_method" value="DELETE">
				<button type="submit" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm">
					<span class="svg-icon svg-icon-3">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
							<path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
							<path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
						</svg>
					</span>
				</button>
			</form>
		</div>`;
	}}]
	<x-slot name="callback">
		TTConfirm.init('.eliminar', () => {table_table.ajax.reload();})
		TTModalForm.init('{{route('prospectos.update', ['prospecto' => 'content'])}}', modal, modalContainer, '.update', '{{route('prospectos.show', ['prospecto' => 'content'])}}', 'Editar Prospecto');
		let eventos = document.querySelectorAll('.eventos');
		for (var i = 0; i < eventos.length; i++) {
			eventos[i].addEventListener('click', (evt) => {
				formEvento.action = '{{route("eventos.store")}}';
				formEvento.reset();
				prospecto_id.value = evt.currentTarget.getAttribute('for-id');
				modalEvento.show();
			});
		}
	</x-slot>
</x-datatable>
@endpush