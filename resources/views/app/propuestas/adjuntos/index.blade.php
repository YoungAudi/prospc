@extends('layout.app')

@section('title', 'Adjuntos de Propuesta')
@section('page-title', 'Propuestas')
@section('page-subtitle', 'Lista de adjuntos de propuesta '.$propuesta->nombre)

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header border-0 pt-5">
				<h3 class="card-title ">
					Adjuntos de la propuesta {{$propuesta->nombre}}
				</h3>
				<div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Da clic para crear un nuevo adjunto a la propuesta">
					<button class="openModal btn btn-sm btn-light btn-active-primary">
					<span class="svg-icon svg-icon-3">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
						<rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
						</svg>
					</span>Nuevo Adjunto</button>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="table" class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
						<thead>
							<tr class="fw-bold text-muted">
								<th>Nombre</th>
								<th>Archivo</th>
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
<div class="modal fade" tabindex="-1" id="modal">
    <div class="modal-dialog">
        <form  class="modal-content" id="form" action="#">
            <div class="modal-header">
                <h3 class="modal-title">Agregar Adjunto</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-circle fs-2x"></i>
                </div>
            </div>
            <div class="modal-body">
            	@method('POST')
            	<div class="row flex-wrap gy-2">
            		<div class="col-12">
            			<x-forms.input mb="mb-3" label="Nombre del adjunto" placeholder="Nombre del adjunto" name="nombre" />
            		</div>
            		<div class="col-12">
            			<x-forms.input mb="mb-3" label="Archivo" placeholder="" name="archivo" type="file" />
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
			theForm.reset();
			modal.show();
		});
		TTValidate.init(theForm, {					
			'nombre': {
				validators: {
					notEmpty: {message: 'Debes de ingresar un nombre.'},
					stringLength: {max:255,message: 'El campo debe tener máximo 255 caracteres.'}
				}
			},
			'archivo': {
				validators: {
					notEmpty: {message: 'Debes de ingresar una descripción.'},
					file: {extension: 'pdf',message: 'El archivo debe de ser un pdf.'},
				}
			},
		}, null, () => {
			modal.hide();
			table_table.ajax.reload();
		});
	});
</script>

<x-datatable id="table" :route="route('propuestas.adjuntos.index', ['propuesta' => $propuesta->id])">
	[{data: 'nombre', name: 'nombre'},
	{render: function(d,t,row,meta) {
		return `<a href="${row['file']}" class="text-primary" target="_blank">Archivo</a>`
	}},
	{data: 'creacion', name: 'creacion'},
	{render: function(data, type, row, meta) {
		return `<div class="d-flex align-items-start">
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
	</x-slot>
</x-datatable>
@endpush