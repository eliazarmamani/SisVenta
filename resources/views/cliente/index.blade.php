@extends('layouts.app')

@section('title', 'Clientes')

@push('css-datatable')
    <link
        href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css"
        rel="stylesheet"
        type="text/css"
    >
@endpush

@push('css')
    @vite('resources/css/cliente/index.css')
@endpush

@section('content')

<div class="cliente-page">

    <div class="container-fluid px-4">

        {{-- =====================================================
             ENCABEZADO
        ====================================================== --}}
        <div class="page-header">

            <div class="page-header-info">

                <h1>
                    <i class="fas fa-users"></i>
                    Clientes
                </h1>

                <p>
                    Gestiona los clientes registrados en el sistema
                </p>

            </div>

            @can('crear-cliente')
                <a
                    href="{{ route('clientes.create') }}"
                    class="btn btn-primary btn-add"
                >
                    <i class="fas fa-plus"></i>
                    Añadir cliente
                </a>
            @endcan

        </div>


        {{-- =====================================================
             BREADCRUMB
        ====================================================== --}}
        <ol class="breadcrumb custom-breadcrumb">

            <li class="breadcrumb-item">
                <a href="{{ route('panel') }}">
                    <i class="fas fa-home"></i>
                    Inicio
                </a>
            </li>

            <li class="breadcrumb-item active">
                Clientes
            </li>

        </ol>


        {{-- =====================================================
             TABLA
        ====================================================== --}}
        <div class="card cliente-card">

            {{-- HEADER DE TABLA --}}
            <div class="card-header">

                <div class="table-title">

                    <div class="table-icon">
                        <i class="fas fa-users"></i>
                    </div>

                    <div>
                        <h5>Lista de clientes</h5>

                        <span>
                            Clientes registrados en el sistema
                        </span>
                    </div>

                </div>

            </div>


            {{-- CUERPO --}}
            <div class="card-body">

                <div class="table-responsive">

                    <table
                        id="datatablesSimple"
                        class="table cliente-table"
                    >

                        <thead>

                            <tr>
                                <th>Cliente</th>
                                <th>Dirección</th>
                                <th>Documento</th>
                                <th>Tipo de persona</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($clientes as $item)

                                <tr>

                                    {{-- CLIENTE --}}
                                    <td>

                                        <div class="cliente-info">

                                            <div class="cliente-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>

                                            <div>

                                                <span class="cliente-nombre">
                                                    {{ $item->persona->razon_social }}
                                                </span>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- DIRECCIÓN --}}
                                    <td>

                                        <span class="cliente-direccion">
                                            {{ $item->persona->direccion ?: 'Sin dirección registrada' }}
                                        </span>

                                    </td>


                                    {{-- DOCUMENTO --}}
                                    <td>

                                        <div class="documento-info">

                                            <span class="documento-tipo">
                                                {{ $item->persona->documento->nombre }}
                                            </span>

                                            <span class="documento-numero">
                                                {{ $item->persona->numero_documento }}
                                            </span>

                                        </div>

                                    </td>


                                    {{-- TIPO DE PERSONA --}}
                                    <td>

                                        <span class="tipo-persona">
                                            {{ $item->persona->tipo->value }}
                                        </span>

                                    </td>


                                    {{-- ESTADO --}}
                                    <td>

                                        @if ($item->persona->estado == 1)

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


                                    {{-- ACCIONES --}}
                                    <td>

                                        <div class="action-buttons">

                                            {{-- EDITAR --}}
                                            @can('editar-cliente')

                                                <a
                                                    href="{{ route('clientes.edit', ['cliente' => $item]) }}"
                                                    class="action-btn edit"
                                                    title="Editar cliente"
                                                >
                                                    <i class="fas fa-pen"></i>
                                                </a>

                                            @endcan


                                            {{-- ELIMINAR / RESTAURAR --}}
                                            @can('eliminar-cliente')

                                                @if ($item->persona->estado == 1)

                                                    <button
                                                        type="button"
                                                        class="action-btn delete"
                                                        title="Eliminar cliente"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#confirmModal-{{ $item->id }}"
                                                    >
                                                        <i class="fas fa-trash"></i>
                                                    </button>

                                                @else

                                                    <button
                                                        type="button"
                                                        class="action-btn restore"
                                                        title="Restaurar cliente"
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


                                {{-- =================================================
                                     MODAL DE CONFIRMACIÓN
                                ================================================== --}}
                                <div
                                    class="modal fade"
                                    id="confirmModal-{{ $item->id }}"
                                    tabindex="-1"
                                    aria-hidden="true"
                                >

                                    <div class="modal-dialog modal-dialog-centered">

                                        <div class="modal-content confirmation-modal">

                                            {{-- MODAL HEADER --}}
                                            <div class="modal-header">

                                                <div class="modal-title-container">

                                                    <div class="modal-icon">
                                                        <i class="fas fa-circle-question"></i>
                                                    </div>

                                                    <div>

                                                        <h5>
                                                            Confirmar acción
                                                        </h5>

                                                        <span>
                                                            Verifica la operación antes de continuar
                                                        </span>

                                                    </div>

                                                </div>

                                                <button
                                                    type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Cerrar"
                                                ></button>

                                            </div>


                                            {{-- MODAL BODY --}}
                                            <div class="modal-body">

                                                <p>

                                                    {{
                                                        $item->persona->estado == 1
                                                        ? '¿Estás seguro de que deseas eliminar este cliente?'
                                                        : '¿Estás seguro de que deseas restaurar este cliente?'
                                                    }}

                                                </p>


                                                <div class="cliente-confirmado">

                                                    <div class="cliente-confirmado-icon">
                                                        <i class="fas fa-user"></i>
                                                    </div>

                                                    <div>

                                                        <strong>
                                                            {{ $item->persona->razon_social }}
                                                        </strong>

                                                        <span>
                                                            {{ $item->persona->numero_documento }}
                                                        </span>

                                                    </div>

                                                </div>

                                            </div>


                                            {{-- MODAL FOOTER --}}
                                            <div class="modal-footer">

                                                <button
                                                    type="button"
                                                    class="btn btn-secondary"
                                                    data-bs-dismiss="modal"
                                                >
                                                    Cancelar
                                                </button>


                                                <form
                                                    action="{{ route('clientes.destroy', ['cliente' => $item->persona->id]) }}"
                                                    method="POST"
                                                >

                                                    @method('DELETE')

                                                    @csrf

                                                    <button
                                                        type="submit"
                                                        class="btn {{ $item->persona->estado == 1 ? 'btn-danger' : 'btn-success' }}"
                                                    >

                                                        <i
                                                            class="fas {{ $item->persona->estado == 1 ? 'fa-trash' : 'fa-rotate' }}"
                                                        ></i>

                                                        {{
                                                            $item->persona->estado == 1
                                                            ? 'Eliminar'
                                                            : 'Restaurar'
                                                        }}

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


{{-- =========================================================
     NOTIFICACIONES
========================================================= --}}

@if (session('success'))

    <div
        id="notification-data"
        data-type="success"
        data-message="{{ session('success') }}"
    ></div>

@endif


@if (session('error'))

    <div
        id="notification-data"
        data-type="error"
        data-message="{{ session('error') }}"
    ></div>

@endif

@endsection


@push('js')

    <script
        src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"
        type="text/javascript"
    ></script>

    <script
        src="https://cdn.jsdelivr.net/npm/sweetalert2@11"
    ></script>

    @vite('resources/js/cliente/index.js')

@endpush