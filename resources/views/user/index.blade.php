@extends('layouts.app')

@section('title', 'Usuarios')

@push('css-datatable') <link
     href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css"
     rel="stylesheet"
     type="text/css">
@endpush

@push('css')
@vite('resources/css/user/index.css')
@endpush

@section('content')
@if(session('success')) 
<div id="user-alert" data-type="success" data-message="{{ session('success') }}" hidden >
</div> 
@endif @if(session('error'))
<div id="user-alert" data-type="error" data-message="{{ session('error') }}" hidden >
</div> 
 @endif

<div class="users-page">

<div class="container-fluid px-4">

    {{-- ENCABEZADO --}}
    <div class="users-header">

        <div class="users-title">

            <div class="users-title-icon">
                <i class="fa-solid fa-users"></i>
            </div>

            <div>
                <h1>Usuarios</h1>
                <p>Administración de usuarios del sistema</p>
            </div>

        </div>

        @can('crear-user')
            <a href="{{ route('users.create') }}" class="btn-add-user">
                <i class="fa-solid fa-user-plus"></i>
                Nuevo usuario
            </a>
        @endcan

    </div>


    {{-- BREADCRUMB --}}
    <div class="users-breadcrumb">

        <a href="{{ route('panel') }}">
            <i class="fa-solid fa-house"></i>
            Inicio
        </a>

        <i class="fa-solid fa-chevron-right"></i>

        <span>Usuarios</span>

    </div>


    {{-- CONTENEDOR --}}
    <div class="users-card">

        {{-- CABECERA --}}
        <div class="users-card-header">

            <div class="users-card-title">

                <div class="users-card-icon">
                    <i class="fa-solid fa-user-gear"></i>
                </div>

                <div>
                    <h2>Lista de usuarios</h2>
                    <p>Usuarios registrados en SisVenta</p>
                </div>

            </div>

            <div class="users-count">
                <strong>{{ $users->count() }}</strong>
                <span>usuarios</span>
            </div>

        </div>


        {{-- TABLA --}}
        <div class="users-table-container">

            <table id="datatablesSimple" class="users-table">

                <thead>

                    <tr>
                        <th>Empleado</th>
                        <th>Alias</th>
                        <th>Correo electrónico</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach ($users as $item)

                        <tr>

                            {{-- EMPLEADO --}}
                            <td>

                                <div class="employee-info">

                                    <div class="employee-avatar">
                                        <i class="fa-solid fa-user"></i>
                                    </div>

                                    <div class="employee-data">

                                        <strong>
                                            {{ $item->empleado->razon_social }}
                                        </strong>

                                        <span>
                                            Empleado
                                        </span>

                                    </div>

                                </div>

                            </td>


                            {{-- ALIAS --}}
                            <td>

                                <span class="user-alias">
                                    {{ $item->name }}
                                </span>

                            </td>


                            {{-- EMAIL --}}
                            <td>

                                <div class="email-info">

                                    <i class="fa-regular fa-envelope"></i>

                                    <span>
                                        {{ $item->email }}
                                    </span>

                                </div>

                            </td>


                            {{-- ROL --}}
                            <td>

                                @php
                                    $role = $item->getRoleNames()->first();
                                @endphp

                                <span class="role-badge">

                                    <i class="fa-solid fa-shield-halved"></i>

                                    {{ $role ?? 'Sin rol' }}

                                </span>

                            </td>


                            {{-- ESTADO --}}
                            <td>

                                @if ($item->estado == 1)

                                    <span class="status-badge status-active">

                                        <span class="status-dot"></span>

                                        Activo

                                    </span>

                                @else

                                    <span class="status-badge status-inactive">

                                        <span class="status-dot"></span>

                                        Inactivo

                                    </span>

                                @endif

                            </td>


                            {{-- ACCIONES --}}
                            <td>

                                <div class="user-actions">

                                    @can('editar-user')

                                        <a
                                            href="{{ route('users.edit', ['user' => $item]) }}"
                                            class="action-btn action-edit"
                                            title="Editar usuario"
                                        >
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                    @endcan


                                    @can('eliminar-user')

                                        @if ($item->estado == 1)

                                            <button
                                                type="button"
                                                title="Desactivar usuario"
                                                class="action-btn action-delete"
                                                data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-{{ $item->id }}"
                                            >
                                                <i class="fa-solid fa-user-slash"></i>
                                            </button>

                                        @else

                                            <button
                                                type="button"
                                                title="Restaurar usuario"
                                                class="action-btn action-restore"
                                                data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-{{ $item->id }}"
                                            >
                                                <i class="fa-solid fa-rotate-right"></i>
                                            </button>

                                        @endif

                                    @endcan

                                </div>

                            </td>

                        </tr>


                        {{-- MODAL --}}
                        <div
                            class="modal fade user-modal"
                            id="confirmModal-{{ $item->id }}"
                            tabindex="-1"
                            aria-hidden="true"
                        >

                            <div class="modal-dialog modal-dialog-centered">

                                <div class="modal-content">

                                    <div class="modal-header">

                                        <div class="modal-title-container">

                                            <div class="modal-icon
                                                {{ $item->estado == 1
                                                    ? 'modal-icon-danger'
                                                    : 'modal-icon-success' }}"
                                            >

                                                @if ($item->estado == 1)
                                                    <i class="fa-solid fa-user-slash"></i>
                                                @else
                                                    <i class="fa-solid fa-user-check"></i>
                                                @endif

                                            </div>

                                            <div>

                                                <h5>Confirmar acción</h5>

                                                <span>
                                                    Gestión de usuario
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

                                        <p class="modal-question">

                                            {{ $item->estado == 1
                                                ? '¿Estás seguro de que deseas desactivar este usuario?'
                                                : '¿Estás seguro de que deseas restaurar este usuario?' }}

                                        </p>


                                        <div class="modal-user-info">

                                            <div class="modal-user-avatar">
                                                <i class="fa-solid fa-user"></i>
                                            </div>

                                            <div>

                                                <strong>
                                                    {{ $item->name }}
                                                </strong>

                                                <span>
                                                    {{ $item->email }}
                                                </span>

                                            </div>

                                        </div>

                                    </div>


                                    <div class="modal-footer">

                                        <button
                                            type="button"
                                            class="btn-modal-cancel"
                                            data-bs-dismiss="modal"
                                        >
                                            Cancelar
                                        </button>

                                        <form
                                            action="{{ route('users.destroy', ['user' => $item->id]) }}"
                                            method="POST"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="{{ $item->estado == 1
                                                    ? 'btn-modal-danger'
                                                    : 'btn-modal-success' }}"
                                            >

                                                @if ($item->estado == 1)

                                                    <i class="fa-solid fa-user-slash"></i>
                                                    Desactivar

                                                @else

                                                    <i class="fa-solid fa-rotate-right"></i>
                                                    Restaurar

                                                @endif

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

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" 
        type="text/javascript" >
</script> 
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" 
        type="text/javascript" >
</script>

@vite('resources/js/user/index.js')

@endpush
    