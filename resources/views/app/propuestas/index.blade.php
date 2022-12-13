@extends('layout.app')

@section('title', 'Propuestas')
@section('page-title', 'Propuestas')
@section('page-subtitle', 'Lista de Propuestas')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header border-0 pt-5">
				<h3 class="card-title ">
					Propuestas
				</h3>
				<div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Da clic para crear un nuevo Propuesta">
					<button class="openModal btn btn-sm btn-light btn-active-primary">
					<span class="svg-icon svg-icon-3">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
						<rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
						</svg>
					</span>Nuevo Propuesta</button>
				</div>
			</div>
			<div class="card-body">
				<div>
					<x-forms.select classes="form-select-sm" mb="mb-3" :select2="false" label="Mes del evento" placeholder="Mes del evento" name="mes_evento" :options="['01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '4' => 'Abril', '5' => 'Mayo', '6' => 'Junio', '7' => 'Julio', '8' => 'Agosto', '9' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre']"/>
				</div>
				<div>
					<x-forms.select classes="form-select-sm" mb="mb-3" :select2="false" label="Estado de la propuesta" placeholder="Estado de la propuesta" name="estado_propuesta" :options="['pendiente' => 'Pendiente', 'enviada' => 'Enviada', 'aceptada' => 'Aceptada', 'rechazada' => 'Rechazada']"/>
				</div>
				<div class="table-responsive">
					<table id="table" class="table table-striped table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
						<thead>
							<tr class="fw-bold text-muted">
								<th colspan="1" rowspan="2">Folio</th>
								<th colspan="1" rowspan="2">Mes</th>
								<th colspan="3">Datos Prospecto</th>
								<th colspan="2">Contacto</th>
								<th colspan="11">Datos Propuesta</th>
								<th colspan="1" rowspan="2">Acciones</th>
							</tr>
							<tr class="fw-bold text-muted">
								<th>Estado</th>
								<th>Ciudad</th>
								<th>Prospecto</th>
								<th>Teléfono</th>
								<th>Email</th>
								<th>Nombre</th>
								<th>Tipo show</th>
								<th>Duración</th>
								<th>Costo del show</th>
								<th>Observaciones</th>
								<th>Evento</th>
								<th>Talento</th>
								<th>Estado</th>
								<th>Archivo</th>
								<th>Fecha cotización</th>
								<th>Creadó en</th>
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
    <div class="modal-dialog modal-fullscreen">
        <form  class="modal-content" id="form" action="#">
            <div class="modal-header">
                <h3 class="modal-title"></h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-circle fs-2x"></i>
                </div>
            </div>
            <div class="modal-body">
            	@method('POST')
            	<div class="row flex-wrap gy-2">
            		<div class="col-12 col-md-6">
            			<x-forms.input mb="mb-3" label="Nombre de la propuesta" placeholder="Nombre de la propuesta" name="nombre" />
            		</div>
            		<div class="col-12 col-md-6">
            			<x-forms.input mb="mb-3" label="Descripción de la propuesta" placeholder="Descripción" name="descripcion" />
            		</div>
            		<div class="col-12 col-md-6">
            			<x-forms.input mb="mb-3" label="Tipo de show" placeholder="Tipo de show" name="tipo_show" />
            		</div>
            		<div class="col-12 col-md-6">
            			<x-forms.input mb="mb-3" label="Duración del evento" placeholder="Duración del evento" name="duracion" />
            		</div>
            		<div class="col-12 col-md-6">
            			<x-forms.input mb="mb-3" label="Costo del show" placeholder="Costo del show" type="text" name="costo" />
            		</div>
            		<div class="col-12 col-md-6">
            			<x-forms.input mb="mb-3" label="Observaciones" placeholder="Observaciones" name="observaciones" />
            		</div>
            		<div class="col-12 col-md-6">
            			<x-forms.input mb="mb-3" label="Fecha valida de la propuesta" placeholder="Fecha valido" type="date" name="fecha_valido" />
            		</div>
            		<div class="col-12 col-md-6">
            			<x-forms.input mb="mb-3" label="Fecha de cotización" placeholder="Fecha cotización" type="date" name="fecha_cotizacion" />
            		</div>
            		<div class="col-12 col-md-6">
            			<x-forms.select mb="mb-3" label="Evento" :select2="false" placeholder="Selecciona el evento" name="evento_id" :options="$eventos"/>
            		</div>
            		<div class="col-12 col-md-6">
            			<x-forms.select mb="mb-3" label="Talento" :select2="false" placeholder="Selecciona el talento" name="talento_id" :options="$talentos"/>
            		</div>
            		<div class="col-10">
            			<h3>Necesidades</h3>
            		</div>
            		<div class="col-2 d-flex justify-content-end">
            			<button id="addNeed" type="button" class="btn btn-sm btn-success btn-icon">
							<span class="svg-icon svg-icon-3">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
								<rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
								</svg>
							</span>
						</button>
            		</div>
            		<div class="col-12" id="necesidades">
            		</div>
            	</div>
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
	var modalContainer, modal, theForm, openModal, theFormTitle, checker, mesEvento, estadoPropuesta;
	var loadNeed, loadNeeds, addNeed, necesidadesContainer, necesidades, reloadNecesidades;
	// var loadAdjunto, loadAdjuntos, addAdjunto, adjuntosContainer, adjuntos, reloadAdjuntos;
	necesidades = [];
	// adjuntos = [];
	checker = false;
	theForm = document.getElementById('form');
	theFormTitle = theForm.querySelector('.modal-title');
	theFormMethod = theForm.querySelector('input[name="_method"]');
	openModal = document.querySelector('.openModal');
	KTUtil.onDOMContentLoaded(function() {

		$('select[name="evento_id"]').select2({
		    dropdownParent: $('#modal .modal-content')
		});
		$('select[name="talento_id"]').select2({
		    dropdownParent: $('#modal .modal-content')
		});

		mesEvento = document.querySelector('select[name="mes_evento"]');
		mesEvento.addEventListener('change', (evt) => {
			table_table.ajax.reload();
		});
		estadoPropuesta = document.querySelector('select[name="estado_propuesta"]');
		estadoPropuesta.addEventListener('change', (evt) => {
			table_table.ajax.reload();
		});
		// needs
		addNeed = document.getElementById('addNeed');
		necesidadesContainer = document.getElementById('necesidades');
		loadNeed = function (tipo, nombre, index, id = undefined) {
			let ids = '';
			if (id) {
				ids = `<input class="idsx" type="hidden" name="ids[]" value="${id}">`;
			}
			return `<div class="row">
            	${ids}
            	<div class="col-5">
	            	<div class="fv-row elc_tipo[] mb-3">
						<input value="${tipo}" placeholder="Tipo de necesidad" name="tipo[]" autocomplete="off" class="fca tipox form-control bg-transparent" />
					</div>
            	</div>
   				<div class="col-5">
            		<div class="fv-row elc_nombres[] mb-3">
						<input value="${nombre}" placeholder="Descripción" name="nombres[]" autocomplete="off" class="fca nombresx form-control bg-transparent" />
					</div>
            	</div>
            	<div class="col-2">
            		<button type="button" for-index="${index}" class="removeNeed btn btn-sm btn-danger">X</button>
            	</div>
            </div>`;
		}
		reloadNecesidades = function()
		{
			let tipos = document.querySelectorAll('.tipox');
			let nombres = document.querySelectorAll('.nombresx');
			let ids = document.querySelectorAll('.idsx');
			necesidades = [];
			for (var i = 0; i < tipos.length; i++) {
				if (ids[i]) {
					necesidades.push({tipo: tipos[i].value, nombre: nombres[i].value, id: ids[i].value});
				} else {
					necesidades.push({tipo: tipos[i].value, nombre: nombres[i].value});
				}
			}
		}
		loadNeeds = function()
		{
			let text = '';
			for (var i = 0; i < necesidades.length; i++) {
				if (necesidades[i].id) {
					text+= loadNeed(necesidades[i].tipo, necesidades[i].nombre, i, necesidades[i].id);
				} else {
					text+= loadNeed(necesidades[i].tipo, necesidades[i].nombre, i);
				}
			}
			necesidadesContainer.innerHTML = text;
			let removeNeeds = document.querySelectorAll('.removeNeed');
			for (var i = 0; i < removeNeeds.length; i++) {
				removeNeeds[i].addEventListener('click', (evt) => {
					let index = evt.currentTarget.getAttribute('for-index');
					reloadNecesidades();
					necesidades.splice(index,1);
					loadNeeds();
				});
			}
		}
		addNeed.addEventListener('click', (evt) => {
			reloadNecesidades();
			necesidades.push({tipo: '', nombre: ''});
			loadNeeds();
		});


		modalContainer = document.getElementById('modal');
		modal = new bootstrap.Modal(modalContainer, {
			keyboard: false,
			backdrop: 'static'
		});
		openModal.addEventListener('click', (evt) => {
			theForm.action = '{{route("propuestas.store")}}';
			theForm.reset();
			theFormTitle.innerHTML = 'Nueva Propuesta';
			theFormMethod.value = 'POST';
			checker = true;
			modal.show();
		});
		TTValidate(theForm, {					
			'nombre': {
				validators: {
					notEmpty: {message: 'Debes de ingresar un nombre.'},
					stringLength: {max:255,message: 'El campo debe tener máximo 255 caracteres.'}
				}
			},
			'descripcion': {
				validators: {
					notEmpty: {message: 'Debes de ingresar una descripción.'},
					stringLength: {max:255,message: 'El campo debe tener máximo 255 caracteres.'},
				}
			},
			'observaciones': {
				validators: {
					// notEmpty: {message: 'Debes de ingresar una observación.'},
					stringLength: {max:255,message: 'El campo debe tener máximo 255 caracteres.'},
				}
			},
			'tipo_show': {
				validators: {
					// notEmpty: {message: 'Debes de ingresar una observación.'},
					stringLength: {max:255,message: 'El campo debe tener máximo 255 caracteres.'},
				}
			},
			'duracion': {
				validators: {
					// notEmpty: {message: 'Debes de ingresar una observación.'},
					stringLength: {max:255,message: 'El campo debe tener máximo 255 caracteres.'},
				}
			},
			'fecha_valido': {
				validators: {
					notEmpty: {message: 'Debes seleccionar la fecha hasta la que es valida la propuesta'}
				}
			},
			'fecha_cotizacion': {
				validators: {
					notEmpty: {message: 'Debes seleccionar la fecha hasta en que se realizó la cotización'}
				}
			},
			'costo': {
				validators: {
					notEmpty: {message: 'Debes ingresar el costo del show.'}
				}
			},
			'evento_id': {
				validators: {
					notEmpty: {message: 'Debes de seleccionar el evento.'},
				}
			},
			'talento_id': {
				validators: {
					notEmpty: {message: 'Debes de seleccionar el talento.'},
				}
			},
		}, null, () => {
			checker = false;
			modal.hide();
			table_table.ajax.reload();
		});
	});
</script>

<x-datatable id="table" :route="route('propuestas.index')">
	[{data: 'folio', name: 'folio'},
	{data: 'mes', name: 'mes'},
	{data: 'estadox', name: 'evento.prospecto.estado'},
	{data: 'ciudad', name: 'evento.prospecto.ciudad'},
	{data: 'prospecto', name: 'evento.prospecto.nombre'},
	{data: 'telefono', name: 'evento.prospecto.telefono'},
	{data: 'email', name: 'evento.prospecto.email'},
	{data: 'nombre', name: 'nombre'},
	{data: 'tipo_show', name: 'tipo_show'},
	{data: 'duracion', name: 'duracion'},
	{data: 'costo', name: 'costo'},
	{data: 'observaciones', name: 'observaciones'},
	{data: 'evento', name: 'evento.nombre'},
	{data: 'talento', name: 'talento.nombre'},
	{data: 'estado', name: 'estado'},
	{render: function(d,t,row,meta) {
		return `<a href="${row['file']}" class="text-danger" target="_blank">PDF Propuesta</a>`
	}},
	{data: 'fecha_cotizacion', name: 'fecha_cotizacion'},
	{data: 'creacion', name: 'creacion'},
	{render: function(data, type, row, meta) {

		let actions = `<form class="me-3 enviars" action="${row['enviarRoute']}">
				<button type="submit" class="btn btn-warning btn-sm">
					Enviar
				</button>
			</form>`;
		if (row['estado'] == 'enviada') {
			actions += `<form class="me-3 aceptars" action="${row['aceptarRoute']}">
				<button type="submit" class="btn btn-success btn-sm">
					Aceptar
				</button>
			</form><form class="me-3 rechazars" action="${row['rechazarRoute']}">
				<button type="submit" class="btn btn-danger btn-sm">
					Rechazar
				</button>
			</form>`;
		}

		return `<div class="d-flex align-items-start">
			${actions}
			<a class="btn btn-info btn-sm me-1" href="${row['adjuntosRoute']}">
				Adjuntos
			</a>
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
		TTConfirm.init('.enviars', () => {table_table.ajax.reload();})
		TTConfirm.init('.aceptars', () => {table_table.ajax.reload();})
		TTConfirm.init('.rechazars', () => {table_table.ajax.reload();})
		TTModalForm.init('{{route('propuestas.update', ['propuesta' => 'content'])}}', modal, modalContainer, '.update', '{{route('propuestas.show', ['propuesta' => 'content'])}}', 'Editar Propuesta', 'tt-id', false);
	</x-slot>
	<x-slot name="data">
		d.fecha = mesEvento.value;
		d.estado = estadoPropuesta.value;
	</x-slot>
</x-datatable>
@endpush