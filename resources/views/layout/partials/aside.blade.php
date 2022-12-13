<!--begin:Menu item-->
<div class="menu-item @if(Route::is('prospectos.index')) here show @endif py-2">
	<a class="menu-link menu-center" href="{{route('prospectos.index')}}">
		<span class="menu-icon me-0">
			<i class="fonticon-stats fs-1"></i>
		</span><span class="menu-title">Prospectos</span>
	</a>
</div>
<div class="menu-item @if(Route::is('eventos.index')) here show @endif py-2">
	<a class="menu-link menu-center" href="{{route('eventos.index')}}">
		<span class="menu-icon me-0">
			<i class="fonticon-layers fs-1"></i>
		</span><span class="menu-title">Eventos</span>
	</a>
</div>
<div class="menu-item @if(Route::is('talentos.index')) here show @endif py-2">
	<a class="menu-link menu-center" href="{{route('talentos.index')}}">
		<span class="menu-icon me-0">
			<i class="fonticon-layers fs-1"></i>
		</span><span class="menu-title">Talentos</span>
	</a>
</div>
<div class="menu-item @if(Route::is('propuestas.index')) here show @endif py-2">
	<a class="menu-link menu-center" href="{{route('propuestas.index')}}">
		<span class="menu-icon me-0">
			<i class="fonticon-app-store fs-1"></i>
		</span><span class="menu-title">Propuestas</span>
	</a>
</div>
{{-- <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2">
	<span class="menu-link menu-center">
		<span class="menu-icon me-0">
			<i class="fonticon-app-store fs-1"></i>
		</span><span class="menu-title">Propuestas</span>
	</span>
	<div class="menu-sub menu-sub-dropdown menu-sub-indention px-2 py-4 w-250px">
		<div class="menu-item">
			<div class="menu-content">
				<span class="menu-section fs-5 fw-bolder ps-1 py-1">Propuestas</span>
			</div>
		</div>
		<div class="menu-item">
			<a class="menu-link" href="#link">
				<span class="menu-icon">
					<i class="bi bi-list fs-3"></i>
				</span><span class="menu-title">Lista</span>
			</a>
		</div>
		<div class="menu-item">
			<a class="menu-link" href="#link">
				<span class="menu-icon">
					<i class="bi bi-plus fs-3"></i>
				</span><span class="menu-title">Crear</span>
			</a>
		</div>
	</div>
</div> --}}
<div class="menu-item @if(Route::is('usuarios.index')) here show @endif py-2">
	<a class="menu-link menu-center" href="{{route('usuarios.index')}}">
		<span class="menu-icon me-0">
			<i class="fonticon-user fs-1"></i>
		</span><span class="menu-title">Usuarios</span>
	</a>
</div>