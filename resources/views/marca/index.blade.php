@extends('layouts.app')

@section('title', 'Marcas')

@push('css-datatable')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@push('css')
    @vite('resources/css/marca/index.css')
@endpush

@section('content')
{{-- Notificaciones --}}
@if (session('success'))
    <div
        id="notification-data"
        data-type="success"
        data-message="{{ session('success') }}">
    </div>
@endif

@if (session('error'))
    <div
        id="notification-data"
        data-type="error"
        data-message="{{ session('error') }}">
    </div>
@endif

<div class="marca-page">

    <div class="container-fluid px-4">

        {{-- Encabezado --}}
        <div class="page-header">
            <div>
                <h1>
                    <i class="fas fa-tags"></i>
                    Marcas
                </h1>
                <p>Gestiona las marcas registradas en el sistema</p>
            </div>

            @can('crear-marca')
                <a href="{{ route('marcas.create') }}" class="btn btn-primary btn-add">
                    <i class="fas fa-plus"></i>
                    Añadir marca
                </a>
            @endcan
        </div>

        {{-- Breadcrumb --}}
        <ol class="breadcrumb custom-breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('panel') }}">
                    <i class="fas fa-home"></i>
                    Inicio
                </a>
            </li>
            <li class="breadcrumb-item active">Marcas</li>
        </ol>

        {{-- Tabla --}}
        <div class="card marca-card">

            <div class="card-header">
                <div class="table-title">
                    <div class="table-icon">
                        <i class="fas fa-tags"></i>
                    </div>

                    <div>
                        <h5>Lista de marcas</h5>
                        <span>Marcas registradas en el sistema</span>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table id="datatablesSimple" class="table marca-table">

                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($marcas as $item)

                                <tr>

                                    <td>
                                        <div class="marca-name">
                                            <div class="marca-avatar">
                                                <i class="fas fa-tag"></i>
                                            </div>

                                            <span>
                                                {{ $item->caracteristica->nombre }}
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="descripcion">
                                            {{ $item->caracteristica->descripcion ?: 'Sin descripción' }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($item->caracteristica->estado == 1)
                                            <span class="status-badge activo">
                                                <span class="status-dot"></span>
                                                Activo
                                            </span>
                                        @else
                                            <span class="status-badge eliminado">
                                                <span class="status-dot"></span>
                                                Eliminado
                                            </span>
                                        @endif
                                    </td>

                                    <td>

                                        <div class="action-buttons">

                                            {{-- Editar --}}
                                            @can('editar-marca')
                                                <a
                                                    href="{{ route('marcas.edit', ['marca' => $item]) }}"
                                                    class="action-btn edit"
                                                    title="Editar marca"
                                                >
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                            @endcan

                                            {{-- Eliminar / Restaurar --}}
                                            @can('eliminar-marca')

                                                @if ($item->caracteristica->estado == 1)

                                                    <button
                                                        type="button"
                                                        class="action-btn delete btn-confirmar"
                                                        title="Eliminar marca"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#confirmModal-{{ $item->id }}"
                                                    >
                                                        <i class="fas fa-trash"></i>
                                                    </button>

                                                @else

                                                    <button
                                                        type="button"
                                                        class="action-btn restore btn-confirmar"
                                                        title="Restaurar marca"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#confirmModal-{{ $item->id }}"
                                                    >
                                                        <i class="fas fa-rotate"></i>
                                                    </button>

                                                @endif

                                            @endcan

                                        </div>

                                    </td>

                                </tr>

                                {{-- Modal --}}
                                <div
                                    class="modal fade"
                                    id="confirmModal-{{ $item->id }}"
                                    tabindex="-1"
                                    aria-hidden="true"
                                >

                                    <div class="modal-dialog modal-dialog-centered">

                                        <div class="modal-content confirmation-modal">

                                            <div class="modal-header">

                                                <div class="modal-title-container">

                                                    <div class="modal-icon">
                                                        <i class="fas fa-circle-question"></i>
                                                    </div>

                                                    <div>
                                                        <h5>Confirmar acción</h5>
                                                        <span>Verifica antes de continuar</span>
                                                    </div>

                                                </div>

                                                <button
                                                    type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Close"
                                                ></button>

                                            </div>

                                            <div class="modal-body">

                                                <p>
                                                    {{
                                                        $item->caracteristica->estado == 1
                                                        ? '¿Estás seguro de que deseas eliminar esta marca?'
                                                        : '¿Estás seguro de que deseas restaurar esta marca?'
                                                    }}
                                                </p>

                                                <div class="marca-confirmada">
                                                    <i class="fas fa-tag"></i>
                                                    <strong>
                                                        {{ $item->caracteristica->nombre }}
                                                    </strong>
                                                </div>

                                            </div>

                                            <div class="modal-footer">

                                                <button
                                                    type="button"
                                                    class="btn btn-secondary"
                                                    data-bs-dismiss="modal"
                                                >
                                                    Cancelar
                                                </button>

                                                <form
                                                    action="{{ route('marcas.destroy', ['marca' => $item->id]) }}"
                                                    method="POST"
                                                >

                                                    @method('DELETE')
                                                    @csrf

                                                    <button
                                                        type="submit"
                                                        class="btn {{ $item->caracteristica->estado == 1 ? 'btn-danger' : 'btn-success' }}"
                                                    >
                                                        <i class="fas {{ $item->caracteristica->estado == 1 ? 'fa-trash' : 'fa-rotate' }}"></i>

                                                        {{ $item->caracteristica->estado == 1 ? 'Eliminar' : 'Restaurar' }}
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

    @vite('resources/js/marca/index.js')
@endpush