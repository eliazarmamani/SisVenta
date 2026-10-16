@extends('layouts.app')

@section('title', 'Empleados')

@push('css-datatable')
    <link
        href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css"
        rel="stylesheet"
        type="text/css"
    >
@endpush

@push('css')
    @vite('resources/css/empleado/index.css')
@endpush

@section('content')

{{-- =========================================================
     MENSAJES DEL SISTEMA
     ========================================================= --}}

@if(session('success'))
    <div
        id="empleado-alert"
        data-type="success"
        data-message="{{ session('success') }}"
        hidden
    ></div>
@endif

@if(session('error'))
    <div
        id="empleado-alert"
        data-type="error"
        data-message="{{ session('error') }}"
        hidden
    ></div>
@endif


<div class="empleados-page">

    <div class="container-fluid px-4">

        {{-- =====================================================
             ENCABEZADO
             ===================================================== --}}

        <div class="empleados-header">

            <div class="empleados-heading">

                <span class="empleados-eyebrow">
                    <i class="fas fa-users"></i>
                    Gestión del personal
                </span>

                <h1>Empleados</h1>

                <p>
                    Administra los empleados y la información de tu equipo de trabajo.
                </p>

            </div>

            @can('crear-empleado')

                <a
                    href="{{ route('empleados.create') }}"
                    class="empleados-btn-nuevo"
                >
                    <i class="fas fa-user-plus"></i>
                    <span>Nuevo empleado</span>
                </a>

            @endcan

        </div>


        {{-- =====================================================
             BREADCRUMB
             ===================================================== --}}

        <div class="empleados-breadcrumb">

            <x-breadcrumb.template>

                <x-breadcrumb.item
                    :href="route('panel')"
                    content="Inicio"
                />

                <x-breadcrumb.item
                    active="true"
                    content="Empleados"
                />

            </x-breadcrumb.template>

        </div>


        {{-- =====================================================
             RESUMEN
             ===================================================== --}}

        <div class="empleados-summary">

            <div class="summary-card">

                <div class="summary-icon">
                    <i class="fas fa-users"></i>
                </div>

                <div class="summary-info">

                    <span>Total de empleados</span>

                    <strong>
                        {{ $empleados->count() }}
                    </strong>

                </div>

            </div>


            <div class="summary-card">

                <div class="summary-icon summary-icon-secondary">
                    <i class="fas fa-briefcase"></i>
                </div>

                <div class="summary-info">

                    <span>Personal registrado</span>

                    <strong>
                        {{ $empleados->count() }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- =====================================================
             TABLA
             ===================================================== --}}

        <div class="card empleados-card">

            <div class="empleados-card-header">

                <div class="card-title-area">

                    <div class="card-title-icon">
                        <i class="fas fa-id-badge"></i>
                    </div>

                    <div>

                        <h5>Lista de empleados</h5>

                        <span>
                            Información del personal registrado
                        </span>

                    </div>

                </div>


                <div class="table-total">

                    <span>Total</span>

                    <strong>
                        {{ $empleados->count() }}
                    </strong>

                </div>

            </div>


            <div class="card-body empleados-table-wrapper">

                <table
                    id="datatablesSimple"
                    class="empleados-table"
                >

                    <thead>

                        <tr>

                            <th>Empleado</th>

                            <th>Cargo</th>

                            <th class="text-center">
                                Acciones
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($empleados as $item)

                            <tr>

                                {{-- EMPLEADO --}}
                                <td>

                                    <div class="empleado-info">

                                        <div class="empleado-avatar">
                                            <i class="fas fa-user"></i>
                                        </div>

                                        <div class="empleado-name">

                                            <strong>
                                                {{ $item->razon_social }}
                                            </strong>

                                            <span>
                                                Personal registrado
                                            </span>

                                        </div>

                                    </div>

                                </td>


                                {{-- CARGO --}}
                                <td>

                                    <div class="cargo-badge">

                                        <i class="fas fa-briefcase"></i>

                                        <span>
                                            {{ $item->cargo }}
                                        </span>

                                    </div>

                                </td>


                                {{-- ACCIONES --}}
                                <td>

                                    <div class="empleado-actions">

                                        @can('editar-empleado')

                                            <a
                                                href="{{ route('empleados.edit', ['empleado' => $item]) }}"
                                                class="action-btn action-edit"
                                                title="Editar empleado"
                                                aria-label="Editar empleado"
                                            >
                                                <i class="fas fa-pen"></i>
                                            </a>

                                        @endcan


                                        @can('eliminar-empleado')

                                            <button
                                                type="button"
                                                class="action-btn action-delete"
                                                title="Eliminar empleado"
                                                aria-label="Eliminar empleado"
                                                data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-{{ $item->id }}"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>

                                        @endcan

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="3">

                                    <div class="empleados-empty">

                                        <div class="empty-icon">
                                            <i class="fas fa-users-slash"></i>
                                        </div>

                                        <h5>
                                            No hay empleados registrados
                                        </h5>

                                        <p>
                                            Todavía no se ha registrado ningún empleado.
                                        </p>

                                        @can('crear-empleado')

                                            <a
                                                href="{{ route('empleados.create') }}"
                                                class="btn btn-primary"
                                            >
                                                <i class="fas fa-user-plus"></i>
                                                Registrar empleado
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


        {{-- =====================================================
             MODALES DE ELIMINACIÓN
             FUERA DE LA TABLA
             ===================================================== --}}

        @foreach ($empleados as $item)

            <div
                class="modal fade empleado-modal"
                id="confirmModal-{{ $item->id }}"
                tabindex="-1"
                aria-hidden="true"
            >

                <div class="modal-dialog modal-dialog-centered">

                    <div class="modal-content">

                        <div class="modal-header">

                            <div class="modal-title-area">

                                <div class="modal-icon">
                                    <i class="fas fa-trash"></i>
                                </div>

                                <div>

                                    <h5>
                                        Eliminar empleado
                                    </h5>

                                    <span>
                                        Confirmación requerida
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


                        <div class="modal-body">

                            <p>
                                ¿Estás seguro de que deseas eliminar a
                                <strong>
                                    {{ $item->razon_social }}
                                </strong>?
                            </p>

                            <div class="modal-warning">

                                <i class="fas fa-circle-exclamation"></i>

                                <span>
                                    Esta acción eliminará el registro
                                    del empleado.
                                </span>

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
                                action="{{ route('empleados.destroy', ['empleado' => $item->id]) }}"
                                method="POST"
                                class="delete-empleado-form"
                            >

                                @csrf

                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger"
                                >
                                    <i class="fas fa-trash me-1"></i>
                                    Eliminar
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        @endforeach


        {{-- =====================================================
             IMPORTACIÓN DE EMPLEADOS
             ===================================================== --}}

        <div class="card import-card">

            <div class="import-header">

                <div class="import-title">

                    <div class="import-icon">
                        <i class="fas fa-file-excel"></i>
                    </div>

                    <div>

                        <h5>
                            Importar empleados
                        </h5>

                        <span>
                            Registra varios empleados mediante un archivo Excel.
                        </span>

                    </div>

                </div>

            </div>


            <div class="import-body">

                <form
                    action="{{ route('import.excel-empleados') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    id="importEmpleadoForm"
                >

                    @csrf

                    <div class="row align-items-end g-3">

                        <div class="col-lg-9">

                            <label
                                for="file"
                                class="form-label"
                            >
                                Archivo Excel
                            </label>

                            <input
                                type="file"
                                name="file"
                                id="file"
                                class="form-control"
                                accept=".xlsx,.xls,.csv"
                                required
                            >

                            <small class="form-text">
                                Formatos permitidos:
                                XLSX, XLS y CSV.
                            </small>

                        </div>


                        <div class="col-lg-3">

                            <button
                                type="submit"
                                class="btn btn-success import-btn"
                            >

                                <i class="fas fa-file-import"></i>

                                <span>
                                    Importar empleados
                                </span>

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection


{{-- =========================================================
     JAVASCRIPT
     ========================================================= --}}

@push('js')

    <script
        src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"
        type="text/javascript"
    ></script>

    <script
        src="https://cdn.jsdelivr.net/npm/sweetalert2@11"
        type="text/javascript"
    ></script>

    @vite('resources/js/empleado/index.js')

@endpush