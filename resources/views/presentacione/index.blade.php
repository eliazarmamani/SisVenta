@extends('layouts.app')

@section('title', 'Presentaciones')

@push('css-datatable')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet">
@endpush

@push('css')
    @vite('resources/css/presentacione/index.css')
@endpush

@section('content')
{{-- MENSAJES DE SESIÓN --}}
@if (session('success'))
    <div
        id="presentacion-success-message"
        data-message="{{ session('success') }}"
        style="display: none;">
    </div>
@endif

@if (session('error'))
    <div
        id="presentacion-error-message"
        data-message="{{ session('error') }}"
        style="display: none;">
    </div>
@endif
<div class="container-fluid px-4 presentaciones-page">

    {{-- ENCABEZADO --}}
    <div class="page-header">

        <div class="page-header-info">

            <div class="page-header-icon">
                <i class="fas fa-box-open"></i>
            </div>

            <div>
                <h1>Presentaciones</h1>
                <p>Gestiona las unidades de presentación de tus productos.</p>
            </div>

        </div>

        @can('crear-presentacione')
            <a href="{{ route('presentaciones.create') }}" class="btn btn-primary btn-nueva">
                <i class="fas fa-plus"></i>
                Nueva presentación
            </a>
        @endcan

    </div>


    {{-- BREADCRUMB --}}
    <div class="page-breadcrumb">

        <ol class="breadcrumb">

            <li class="breadcrumb-item">
                <a href="{{ route('panel') }}">
                    <i class="fas fa-home"></i>
                    Inicio
                </a>
            </li>

            <li class="breadcrumb-item active">
                Presentaciones
            </li>

        </ol>

    </div>


    {{-- TARJETA --}}
    <div class="card presentaciones-card">

        {{-- CABECERA --}}
        <div class="card-header presentaciones-card-header">

            <div class="table-heading">

                <div class="table-heading-icon">
                    <i class="fas fa-list"></i>
                </div>

                <div>
                    <h2>Lista de presentaciones</h2>
                    <p>Presentaciones registradas en el sistema</p>
                </div>

            </div>

        </div>


        {{-- CONTENIDO --}}
        <div class="card-body presentaciones-card-body">

            <div class="table-responsive">

                <table id="datatablesSimple" class="table presentaciones-table">

                    <thead>
                        <tr>
                            <th>Presentación</th>
                            <th>Sigla</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($presentaciones as $item)

                            <tr>

                                {{-- NOMBRE --}}
                                <td>

                                    <div class="presentation-info">

                                        <div class="presentation-avatar">
                                            <i class="fas fa-box"></i>
                                        </div>

                                        <div class="presentation-data">

                                            <span class="presentation-name">
                                                {{ $item->caracteristica->nombre }}
                                            </span>

                                            <span class="presentation-id">
                                                Registro #{{ $item->id }}
                                            </span>

                                        </div>

                                    </div>

                                </td>


                                {{-- SIGLA --}}
                                <td>

                                    <span class="sigla-badge">
                                        {{ $item->sigla }}
                                    </span>

                                </td>


                                {{-- DESCRIPCIÓN --}}
                                <td>

                                    <span class="description-text">
                                        {{ $item->caracteristica->descripcion ?: 'Sin descripción' }}
                                    </span>

                                </td>


                                {{-- ESTADO --}}
                                <td>

                                    @if ($item->caracteristica->estado == 1)

                                        <span class="status-badge status-active">
                                            <span class="status-dot"></span>
                                            Activo
                                        </span>

                                    @else

                                        <span class="status-badge status-inactive">
                                            <span class="status-dot"></span>
                                            Eliminado
                                        </span>

                                    @endif

                                </td>


                                {{-- ACCIONES --}}
                                <td>

                                    <div class="action-buttons">

                                        @can('editar-presentacione')

                                            <a
                                                href="{{ route('presentaciones.edit', ['presentacione' => $item]) }}"
                                                class="action-btn action-edit"
                                                title="Editar presentación"
                                            >
                                                <i class="fas fa-pen"></i>
                                                <span>Editar</span>
                                            </a>

                                        @endcan


                                        @can('eliminar-presentacione')

                                            @if ($item->caracteristica->estado == 1)

                                                <button
                                                    type="button"
                                                    class="action-btn action-delete"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#confirmModal-{{ $item->id }}"
                                                    title="Eliminar presentación"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                    <span>Eliminar</span>
                                                </button>

                                            @else

                                                <button
                                                    type="button"
                                                    class="action-btn action-restore"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#confirmModal-{{ $item->id }}"
                                                    title="Restaurar presentación"
                                                >
                                                    <i class="fas fa-rotate-left"></i>
                                                    <span>Restaurar</span>
                                                </button>

                                            @endif

                                        @endcan

                                    </div>

                                </td>

                            </tr>


                            {{-- MODAL --}}
                            <div
                                class="modal fade"
                                id="confirmModal-{{ $item->id }}"
                                tabindex="-1"
                                aria-hidden="true"
                            >

                                <div class="modal-dialog modal-dialog-centered">

                                    <div class="modal-content confirmation-modal">

                                        <div class="modal-header">

                                            <div class="confirmation-heading">

                                                <div class="confirmation-icon
                                                    {{ $item->caracteristica->estado == 1
                                                        ? 'icon-danger'
                                                        : 'icon-success' }}">

                                                    <i class="fas
                                                        {{ $item->caracteristica->estado == 1
                                                            ? 'fa-trash'
                                                            : 'fa-rotate-left' }}">
                                                    </i>

                                                </div>

                                                <div>
                                                    <h5>
                                                        {{ $item->caracteristica->estado == 1
                                                            ? 'Eliminar presentación'
                                                            : 'Restaurar presentación' }}
                                                    </h5>

                                                    <span>
                                                        Confirmación de acción
                                                    </span>
                                                </div>

                                            </div>

                                            <button
                                                type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal"
                                            ></button>

                                        </div>


                                        <div class="modal-body">

                                            <p class="confirmation-text">

                                                {{ $item->caracteristica->estado == 1
                                                    ? '¿Estás seguro de que deseas eliminar esta presentación?'
                                                    : '¿Deseas restaurar esta presentación?' }}

                                            </p>


                                            <div class="selected-item">

                                                <div class="selected-item-icon">
                                                    <i class="fas fa-box"></i>
                                                </div>

                                                <div>

                                                    <strong>
                                                        {{ $item->caracteristica->nombre }}
                                                    </strong>

                                                    <span>
                                                        Sigla: {{ $item->sigla }}
                                                    </span>

                                                </div>

                                            </div>


                                            @if ($item->caracteristica->estado == 1)

                                                <div class="modal-warning">
                                                    <i class="fas fa-circle-info"></i>

                                                    <span>
                                                        La presentación quedará inactiva,
                                                        pero podrás restaurarla posteriormente.
                                                    </span>
                                                </div>

                                            @else

                                                <div class="modal-success">
                                                    <i class="fas fa-circle-check"></i>

                                                    <span>
                                                        La presentación volverá a estar disponible
                                                        en el sistema.
                                                    </span>
                                                </div>

                                            @endif

                                        </div>


                                        <div class="modal-footer">

                                            <button
                                                type="button"
                                                class="btn btn-light btn-cancel"
                                                data-bs-dismiss="modal"
                                            >
                                                Cancelar
                                            </button>

                                            <form
                                                action="{{ route('presentaciones.destroy', ['presentacione' => $item->id]) }}"
                                                method="POST"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                @if ($item->caracteristica->estado == 1)

                                                    <button
                                                        type="submit"
                                                        class="btn btn-danger btn-confirm"
                                                    >
                                                        <i class="fas fa-trash"></i>
                                                        Eliminar
                                                    </button>

                                                @else

                                                    <button
                                                        type="submit"
                                                        class="btn btn-success btn-confirm"
                                                    >
                                                        <i class="fas fa-rotate-left"></i>
                                                        Restaurar
                                                    </button>

                                                @endif

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @empty

                            <tr>

                                <td colspan="5">

                                    <div class="empty-state">

                                        <div class="empty-state-icon">
                                            <i class="fas fa-box-open"></i>
                                        </div>

                                        <h3>No hay presentaciones</h3>

                                        <p>
                                            Aún no existen presentaciones registradas.
                                        </p>

                                        @can('crear-presentacione')

                                            <a
                                                href="{{ route('presentaciones.create') }}"
                                                class="btn btn-primary"
                                            >
                                                <i class="fas fa-plus"></i>
                                                Nueva presentación
                                            </a>

                                        @endcan

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection


@push('js')

    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite('resources/js/presentacione/index.js')

@endpush