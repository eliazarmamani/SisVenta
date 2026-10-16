@extends('layouts.app')

@section('title', 'Categorías')

@push('css-datatable') <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet">
@endpush

@push('css')
@vite('resources/css/categoria/index.css')
@endpush

@section('content')
@if (session('success'))
    <div id="categoria-success" data-message="{{ session('success') }}" hidden></div>
@endif

@if (session('error'))
    <div id="categoria-error" data-message="{{ session('error') }}" hidden></div>
@endif

<div class="categoria-page">
    <div class="container-fluid px-4">

    {{-- Encabezado --}}
    <div class="page-header">
        <div>
            <span class="page-kicker">GESTIÓN</span>
            <h1>Categorías</h1>
            <p>Administra las categorías de productos del sistema.</p>
        </div>

        @can('crear-categoria')
            <a href="{{ route('categorias.create') }}" class="btn btn-primary btn-add">
                <i class="fa-solid fa-plus"></i>
                <span>Nueva categoría</span>
            </a>
        @endcan
    </div>

    {{-- Breadcrumb --}}
    <x-breadcrumb.template>
        <x-breadcrumb.item :href="route('panel')" content="Inicio" />
        <x-breadcrumb.item active="true" content="Categorías" />
    </x-breadcrumb.template>

    {{-- Tabla --}}
    <div class="categoria-card">

        <div class="card-header-custom">
            <div class="header-title">
                <div class="header-icon">
                    <i class="fa-solid fa-tags"></i>
                </div>

                <div>
                    <h5>Categorías registradas</h5>
                    <span>Listado general de categorías</span>
                </div>
            </div>
        </div>

        <div class="card-body-custom">

            <div class="table-responsive">

                <table id="datatablesSimple" class="categoria-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($categorias as $categoria)

                            <tr>

                                {{-- Nombre --}}
                                <td>
                                    <div class="categoria-name">
                                        <div class="categoria-icon">
                                            <i class="fa-solid fa-tag"></i>
                                        </div>

                                        <div>
                                            <span class="name">
                                                {{ $categoria->caracteristica->nombre }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Descripción --}}
                                <td>
                                    <span class="descripcion">
                                        {{ $categoria->caracteristica->descripcion ?: 'Sin descripción' }}
                                    </span>
                                </td>

                                {{-- Estado --}}
                                <td>
                                    @if ($categoria->caracteristica->estado)
                                        <span class="status-badge active">
                                            <span class="status-dot"></span>
                                            Activo
                                        </span>
                                    @else
                                        <span class="status-badge inactive">
                                            <span class="status-dot"></span>
                                            Eliminado
                                        </span>
                                    @endif
                                </td>

                                {{-- Acciones --}}
                                <td>
                                    <div class="actions">

                                        @can('editar-categoria')
                                            <a
                                                href="{{ route('categorias.edit', ['categoria' => $categoria]) }}"
                                                class="action-btn edit"
                                                title="Editar categoría"
                                            >
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                        @endcan

                                        @can('eliminar-categoria')

                                            @if ($categoria->caracteristica->estado == 1)

                                                <button
                                                    type="button"
                                                    class="action-btn delete btn-modal-confirmar"
                                                    title="Eliminar categoría"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#confirmModal-{{ $categoria->id }}"
                                                >
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>

                                            @else

                                                <button
                                                    type="button"
                                                    class="action-btn restore btn-modal-confirmar"
                                                    title="Restaurar categoría"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#confirmModal-{{ $categoria->id }}"
                                                >
                                                    <i class="fa-solid fa-rotate"></i>
                                                </button>

                                            @endif

                                        @endcan

                                    </div>
                                </td>

                            </tr>

                            {{-- Modal --}}
                            <div
                                class="modal fade categoria-modal"
                                id="confirmModal-{{ $categoria->id }}"
                                tabindex="-1"
                                aria-hidden="true"
                            >
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">

                                        <div class="modal-header">

                                            <div class="modal-title-wrapper">

                                                <div class="modal-icon
                                                    {{ $categoria->caracteristica->estado ? 'danger' : 'restore' }}">
                                                    <i class="fa-solid
                                                        {{ $categoria->caracteristica->estado
                                                            ? 'fa-trash'
                                                            : 'fa-rotate' }}">
                                                    </i>
                                                </div>

                                                <div>
                                                    <h5>
                                                        {{ $categoria->caracteristica->estado
                                                            ? 'Eliminar categoría'
                                                            : 'Restaurar categoría' }}
                                                    </h5>

                                                    <span>Confirmación de acción</span>
                                                </div>

                                            </div>

                                            <button
                                                type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal"
                                                aria-label="Cerrar"
                                            ></button>

                                        </div>

                                        <div class="modal-body">

                                            <p>
                                                {{ $categoria->caracteristica->estado
                                                    ? '¿Estás seguro de que deseas eliminar esta categoría?'
                                                    : '¿Estás seguro de que deseas restaurar esta categoría?' }}
                                            </p>

                                            <div class="categoria-preview">
                                                <i class="fa-solid fa-tag"></i>
                                                <strong>
                                                    {{ $categoria->caracteristica->nombre }}
                                                </strong>
                                            </div>

                                        </div>

                                        <div class="modal-footer">

                                            <button
                                                type="button"
                                                class="btn btn-light"
                                                data-bs-dismiss="modal"
                                            >
                                                Cancelar
                                            </button>

                                            <form
                                                action="{{ route('categorias.destroy', ['categoria' => $categoria->id]) }}"
                                                method="POST"
                                            >
                                                @method('DELETE')
                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="btn {{ $categoria->caracteristica->estado ? 'btn-danger' : 'btn-success' }}"
                                                >
                                                    <i class="fa-solid
                                                        {{ $categoria->caracteristica->estado
                                                            ? 'fa-trash'
                                                            : 'fa-rotate' }}">
                                                    </i>

                                                    {{ $categoria->caracteristica->estado
                                                        ? 'Eliminar'
                                                        : 'Restaurar' }}
                                                </button>
                                            </form>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        @endforeach

                    </tbody>
                </table>

            </div>

        </div>
    </div>

</div>

</div>

@endsection

@push('js') 

<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@vite('resources/js/categoria/index.js')
@endpush