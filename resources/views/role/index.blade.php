@extends('layouts.app')

@section('title', 'Roles')

@push('css-datatable') <link
     href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css"
     rel="stylesheet"
     type="text/css"
 >
@endpush

@push('css')
@vite('resources/css/role/index.css')
@endpush

@section('content')
@if(session('success')) 
<div id="role-alert" data-type="success" data-message="{{ session('success') }}" hidden >
</div> 
@endif @if(session('error')) 
<div id="role-alert" data-type="error" data-message="{{ session('error') }}" hidden >
</div> 
@endif

<div class="role-page">

<div class="container-fluid px-4">

    {{-- =====================================================
        ENCABEZADO
    ====================================================== --}}
    <div class="role-header">

        <div class="role-header-content">

            <div class="role-header-icon">
                <i class="fa-solid fa-shield-halved"></i>
            </div>

            <div class="role-header-text">

                <div class="role-header-title">
                    <h1>Roles</h1>

                    <span class="role-header-badge">
                        <i class="fa-solid fa-lock"></i>
                        Seguridad
                    </span>
                </div>

                <p>
                    Administra los perfiles de acceso y controla las
                    funciones disponibles para cada usuario.
                </p>

            </div>

        </div>

        @can('crear-role')
            <a href="{{ route('roles.create') }}" class="btn-role-primary">
                <i class="fa-solid fa-plus"></i>
                <span>Nuevo rol</span>
            </a>
        @endcan

    </div>


    {{-- =====================================================
        NAVEGACIÓN
    ====================================================== --}}
    <div class="role-navigation">

        <a href="{{ route('panel') }}" class="btn-role-inicio">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Inicio</span>
        </a>

        <div class="role-navigation-current">
            <i class="fa-solid fa-chevron-right"></i>
            <span>Gestión de roles</span>
        </div>

    </div>


    {{-- =====================================================
        RESUMEN
    ====================================================== --}}
    <div class="role-summary">

        <div class="summary-card">

            <div class="summary-icon summary-icon-blue">
                <i class="fa-solid fa-user-shield"></i>
            </div>

            <div class="summary-content">
                <span class="summary-label">Roles registrados</span>
                <strong>{{ $roles->count() }}</strong>
                <small>Perfiles disponibles</small>
            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon summary-icon-green">
                <i class="fa-solid fa-circle-check"></i>
            </div>

            <div class="summary-content">
                <span class="summary-label">Estado</span>
                <strong class="summary-status">Activos</strong>
                <small>Control operativo</small>
            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon summary-icon-purple">
                <i class="fa-solid fa-key"></i>
            </div>

            <div class="summary-content">
                <span class="summary-label">Control de acceso</span>
                <strong class="summary-status">Habilitado</strong>
                <small>Permisos protegidos</small>
            </div>

        </div>

    </div>


    {{-- =====================================================
        TABLA PRINCIPAL
    ====================================================== --}}
    <div class="role-card">

        <div class="role-card-header">

            <div class="role-card-heading">

                <div class="role-card-heading-icon">
                    <i class="fa-solid fa-list-check"></i>
                </div>

                <div>
                    <h5>Roles del sistema</h5>

                    <p>
                        Gestiona los perfiles y permisos de acceso.
                    </p>
                </div>

            </div>

            <div class="role-card-info">
                <i class="fa-solid fa-circle-info"></i>
                <span>Los permisos se administran desde cada rol.</span>
            </div>

        </div>


        <div class="role-card-body">

            <div class="table-responsive">

                <table id="datatablesSimple" class="role-table">

                    <thead>
                        <tr>
                            <th>ROL</th>
                            <th>IDENTIFICADOR</th>
                            <th>ESTADO</th>
                            <th class="text-center">ACCIONES</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($roles as $item)

                            <tr>

                                {{-- ROL --}}
                                <td>

                                    <div class="role-data">

                                        <div class="role-avatar">
                                            <i class="fa-solid fa-user-shield"></i>
                                        </div>

                                        <div class="role-data-text">

                                            <span class="role-data-name">
                                                {{ $item->name }}
                                            </span>

                                            <small>
                                                Perfil de acceso del sistema
                                            </small>

                                        </div>

                                    </div>

                                </td>


                                {{-- IDENTIFICADOR --}}
                                <td>

                                    <span class="role-id">
                                        #{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}
                                    </span>

                                </td>


                                {{-- ESTADO --}}
                                <td>

                                    <span class="role-status">
                                        <span class="role-status-dot"></span>
                                        Activo
                                    </span>

                                </td>


                                {{-- ACCIONES --}}
                                <td>

                                    <div class="role-actions">

                                        @can('editar-role')

                                            <a
                                                href="{{ route('roles.edit', ['role' => $item]) }}"
                                                class="role-action role-action-edit"
                                                title="Editar rol"
                                            >
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                <span>Editar</span>
                                            </a>

                                        @endcan


                                        @can('eliminar-role')

                                            <button
                                                type="button"
                                                class="role-action role-action-delete"
                                                data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-{{ $item->id }}"
                                                title="Eliminar rol"
                                            >
                                                <i class="fa-solid fa-trash-can"></i>
                                                <span>Eliminar</span>
                                            </button>

                                        @endcan

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="role-empty-cell">

                                    <div class="role-empty">

                                        <div class="role-empty-icon">
                                            <i class="fa-solid fa-user-shield"></i>
                                        </div>

                                        <h5>No hay roles registrados</h5>

                                        <p>
                                            Crea el primer rol para comenzar
                                            a administrar los accesos.
                                        </p>

                                        @can('crear-role')

                                            <a
                                                href="{{ route('roles.create') }}"
                                                class="btn-role-empty"
                                            >
                                                <i class="fa-solid fa-plus"></i>
                                                Crear primer rol
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


    {{-- =====================================================
        MODALES
    ====================================================== --}}
    @foreach ($roles as $item)

        <div
            class="modal fade"
            id="confirmModal-{{ $item->id }}"
            tabindex="-1"
            aria-hidden="true"
        >

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content role-delete-modal">

                    <div class="modal-header">

                        <div class="delete-modal-icon">
                            <i class="fa-solid fa-trash-can"></i>
                        </div>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Cerrar"
                        ></button>

                    </div>

                    <div class="modal-body">

                        <h4>Eliminar rol</h4>

                        <p class="delete-description">
                            ¿Estás seguro de que deseas eliminar este rol?
                            Esta acción no podrá deshacerse.
                        </p>

                        <div class="delete-role-box">

                            <div class="delete-role-avatar">
                                <i class="fa-solid fa-user-shield"></i>
                            </div>

                            <div>
                                <span>Rol seleccionado</span>
                                <strong>{{ $item->name }}</strong>
                            </div>

                        </div>

                        <div class="delete-warning">

                            <i class="fa-solid fa-triangle-exclamation"></i>

                            <div>
                                <strong>Atención</strong>

                                <span>
                                    Verifica que este rol no sea necesario
                                    para los usuarios antes de eliminarlo.
                                </span>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn-delete-cancel"
                            data-bs-dismiss="modal"
                        >
                            Cancelar
                        </button>

                        <form
                            action="{{ route('roles.destroy', ['role' => $item->id]) }}"
                            method="POST"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn-delete-confirm"
                            >
                                <i class="fa-solid fa-trash-can"></i>
                                Eliminar rol
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    @endforeach

</div>

</div>

@endsection

@push('js')

    <script
        src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"
        type="text/javascript"
    ></script>

    <script
        src="https://cdn.jsdelivr.net/npm/sweetalert2@11"
        type="text/javascript"
    ></script>

    @vite('resources/js/role/index.js')

@endpush
