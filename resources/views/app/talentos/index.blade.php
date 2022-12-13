@extends('layout.app')

@section('title', 'Talentos')
@section('page-title', 'Talentos')
@section('page-subtitle', 'Lista de Talentos')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header border-0 pt-5">
				<h3 class="card-title ">
					Talentos
				</h3>
				<div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Da clic para crear un nuevo talento">
					<button class="openModal btn btn-sm btn-light btn-active-primary">
					<span class="svg-icon svg-icon-3">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
						<rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
						</svg>
					</span>Nuevo Talento</button>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="table" class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
						<thead>
							<tr class="fw-bold text-muted">
								<th>ID</th>
								<th>Nombre</th>
								<th>Apodo</th>
								<th>Portada</th>
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
            	<x-forms.input mb="mb-3" placeholder="Apodo" name="apodo" />
            	<x-forms.input mb="mb-3" label="Portada" placeholder="portada" type="file" name="imagen" />
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
	var modalContainer, modal, theForm, openModal, theFormTitle, checker;
	checker = false;
	theForm = document.getElementById('form');
	theFormTitle = theForm.querySelector('.modal-title');
	theFormMethod = theForm.querySelector('input[name="_method"]');
	openModal = document.querySelector('.openModal');
	KTUtil.onDOMContentLoaded(function() {
		modalContainer = document.getElementById('modal');
		modal = new bootstrap.Modal(modalContainer, {
			keyboard: false,
			backdrop: 'static'
		});
		openModal.addEventListener('click', (evt) => {
			theForm.action = '{{route("talentos.store")}}';
			theForm.reset();
			theFormTitle.innerHTML = 'Nuevo Talento';
			theFormMethod.value = 'POST';
			checker = true;
			modal.show();
		});
		TTValidate.init(theForm, {					
			'nombre': {
				validators: {
					notEmpty: {message: 'Debes de ingresar un nombre.'},
					stringLength: {max:255,message: 'El campo debe tener máximo 255 caracteres.'}
				}
			},
			'apodo': {
				validators: {
					// notEmpty: {message: 'Debes de ingresar un apodo.'},
					stringLength: {max:255,message: 'El campo debe tener máximo 255 caracteres.'}
				}
			},
			'imagen': {
				validators: {
					callback: (inp) => {
						if (checker && inp.value == '') {
							return {
					            valid: false,    // or false
					            message: 'Debes ingresar una imagen'
					        };
						}
						return {valid:true};
					} ,
					file: {extension: "png,jpg,jpeg", message: "El archivo debe de ser una imagen (jpg o png)."}
				}
			},
		}, null, () => {
			checker = false;
			modal.hide();
			table_table.ajax.reload();
		});
	});
</script>

<x-datatable id="table" :route="route('talentos.index')">
	[{data: 'id', name: 'id'},
	{data: 'nombre', name: 'nombre'},
	{data: 'apodo', name: 'apodo'},
	{render: function(data, type, row, meta) {
		return `<img src="${row['portada']}" class="w-40px h-auto">`;
	}},
	{data: 'creacion', name: 'creacion'},
	{render: function(data, type, row, meta) {
		return `<div class="d-flex align-items-start">
			<button tt-id="${row['id']}" class="update btn btn-icon btn-bg-light btn-active-color-warning btn-sm me-1">
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
		TTModalForm.init('{{route('talentos.update', ['talento' => 'content'])}}', modal, modalContainer, '.update', '{{route('talentos.show', ['talento' => 'content'])}}', 'Editar Talento');
	</x-slot>
</x-datatable>
@endpush