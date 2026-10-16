@extends('layouts.app')

@section('title', 'Editar Rol')

@push('css')
@vite('resources/css/role/edit.css')
@endpush

@section('content')

<div class="role-edit-page">

<div class="container-fluid px-4">

    {{-- =====================================================
         ENCABEZADO
    ====================================================== --}}
    <div class="role-edit-header">

        <div class="role-edit-heading">

            <div class="role-edit-icon">
                <i class="fa-solid fa-user-shield"></i>
            </div>

            <div>
                <div class="role-edit-title-row">
                    <h1>Editar rol</h1>

                    <span class="role-edit-badge">
                        <i class="fa-solid fa-shield-halved"></i>
                        Seguridad
                    </span>
                </div>

                <p>
                    Actualiza la información y administra los permisos
                    asignados a este rol.
                </p>
            </div>

        </div>

        <a
            href="{{ route('roles.index') }}"
            class="btn-back"
        >
            <i class="fa-solid fa-arrow-left"></i>
            <span>Volver a roles</span>
        </a>

    </div>


    {{-- =====================================================
         NAVEGACIÓN EN BOTONES
    ====================================================== --}}
    <div class="page-navigation">

        <a
            href="{{ route('panel') }}"
            class="navigation-button"
        >
            <i class="fa-solid fa-house"></i>
            <span>Inicio</span>
        </a>

        <span class="navigation-separator">/</span>

        <a
            href="{{ route('roles.index') }}"
            class="navigation-button"
        >
            <i class="fa-solid fa-user-shield"></i>
            <span>Roles</span>
        </a>

        <span class="navigation-separator">/</span>

        <span class="navigation-current">
            <i class="fa-solid fa-pen-to-square"></i>
            Editar rol
        </span>

    </div>


    {{-- =====================================================
         FORMULARIO
    ====================================================== --}}
    <form
        action="{{ route('roles.update', ['role' => $role]) }}"
        method="POST"
        id="roleEditForm"
    >

        @method('PATCH')
        @csrf


        <div class="row g-4">

            {{-- =================================================
                 INFORMACIÓN DEL ROL
            ================================================== --}}
            <div class="col-lg-5">

                <div class="role-card">

                    <div class="role-card-header">

                        <div class="role-card-icon">
                            <i class="fa-solid fa-id-badge"></i>
                        </div>

                        <div>
                            <h2>Información del rol</h2>
                            <p>
                                Modifica los datos principales del rol.
                            </p>
                        </div>

                    </div>


                    <div class="role-card-body">

                        <div class="form-group">

                            <label for="name">
                                Nombre del rol
                                <span>*</span>
                            </label>

                            <div class="input-box">

                                <i class="fa-solid fa-user-tag"></i>

                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="form-control-custom @error('name') is-invalid @enderror"
                                    value="{{ old('name', $role->name) }}"
                                    placeholder="Ej. Vendedor"
                                    maxlength="50"
                                    autocomplete="off"
                                >

                            </div>

                            @error('name')
                                <div class="field-error">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror

                            <div class="field-footer">

                                <small>
                                    Usa un nombre claro y fácil de identificar.
                                </small>

                                <span class="name-counter">
                                    <strong id="nameCounter">0</strong>/50
                                </span>

                            </div>

                        </div>


                        {{-- Información --}}
                        <div class="role-note">

                            <div class="role-note-icon">
                                <i class="fa-solid fa-circle-info"></i>
                            </div>

                            <div>
                                <strong>Información</strong>

                                <p>
                                    Los permisos determinan las acciones
                                    que los usuarios con este rol pueden
                                    realizar dentro del sistema.
                                </p>
                            </div>

                        </div>


                        {{-- Rol actual --}}
                        <div class="current-role">

                            <div class="current-role-icon">
                                <i class="fa-solid fa-user-check"></i>
                            </div>

                            <div>
                                <span>Rol que estás editando</span>
                                <strong>{{ $role->name }}</strong>
                            </div>

                        </div>


                        <div class="role-tip">

                            <i class="fa-solid fa-lightbulb"></i>

                            <span>
                                Revisa los permisos antes de guardar los
                                cambios para mantener un control adecuado
                                de acceso.
                            </span>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 PERMISOS
            ================================================== --}}
            <div class="col-lg-7">

                <div class="role-card permissions-card">

                    <div class="role-card-header permissions-header">

                        <div class="role-card-heading">

                            <div class="role-card-icon">
                                <i class="fa-solid fa-key"></i>
                            </div>

                            <div>
                                <h2>Permisos del rol</h2>
                                <p>
                                    Selecciona las acciones permitidas.
                                </p>
                            </div>

                        </div>

                        <div class="permission-counter">

                            <strong id="permissionCounter">0</strong>

                            <span>seleccionados</span>

                        </div>

                    </div>


                    {{-- Barra de herramientas --}}
                    <div class="permissions-toolbar">

                        <div class="search-permissions">

                            <i class="fa-solid fa-magnifying-glass"></i>

                            <input
                                type="text"
                                id="permissionSearch"
                                placeholder="Buscar permiso..."
                                autocomplete="off"
                            >

                        </div>


                        <button
                            type="button"
                            id="selectAll"
                            class="permission-btn"
                        >
                            <i class="fa-solid fa-check-double"></i>
                            <span>Todos</span>
                        </button>


                        <button
                            type="button"
                            id="clearAll"
                            class="permission-btn clear"
                        >
                            <i class="fa-solid fa-eraser"></i>
                            <span>Limpiar</span>
                        </button>

                    </div>


                    {{-- Resumen --}}
                    <div class="permission-summary">

                        <div class="summary-header">

                            <div>
                                <span>Asignación de permisos</span>
                                <small id="permissionStatus">
                                    Selecciona los permisos necesarios.
                                </small>
                            </div>

                            <strong>
                                <span id="permissionCounterSmall">0</span>
                                /
                                {{ $permisos->count() }}
                            </strong>

                        </div>

                        <div class="permission-progress">
                            <div
                                id="permissionProgress"
                                class="permission-progress-bar"
                            ></div>
                        </div>

                    </div>


                    {{-- Lista --}}
                    <div class="permissions-list">

                        @forelse ($permisos as $item)

                            <label
                                class="permission-item"
                                data-permission="{{ strtolower($item->name) }}"
                                for="permission-{{ $item->id }}"
                            >

                                <input
                                    type="checkbox"
                                    name="permission[]"
                                    id="permission-{{ $item->id }}"
                                    class="permission-checkbox"
                                    value="{{ $item->id }}"
                                    {{ in_array(
                                        $item->id,
                                        old(
                                            'permission',
                                            $role->permissions->pluck('id')->toArray()
                                        )
                                    ) ? 'checked' : '' }}
                                >

                                <span class="permission-check">
                                    <i class="fa-solid fa-check"></i>
                                </span>

                                <span class="permission-info">

                                    <strong>
                                        {{ $item->name }}
                                    </strong>

                                    <small>
                                        Permiso del sistema
                                    </small>

                                </span>

                                <span class="permission-arrow">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </span>

                            </label>

                        @empty

                            <div class="empty-permissions">

                                <div class="empty-permissions-icon">
                                    <i class="fa-solid fa-shield-halved"></i>
                                </div>

                                <h3>No hay permisos disponibles</h3>

                                <p>
                                    Actualmente no existen permisos
                                    registrados para asignar al rol.
                                </p>

                            </div>

                        @endforelse

                    </div>


                    @error('permission')

                        <div class="permission-error">

                            <i class="fa-solid fa-circle-exclamation"></i>

                            <span>{{ $message }}</span>

                        </div>

                    @enderror

                </div>

            </div>

        </div>


        {{-- =====================================================
             ACCIONES
        ====================================================== --}}
        <div class="role-edit-actions">

            <a
                href="{{ route('roles.index') }}"
                class="btn-cancel"
            >
                <i class="fa-solid fa-xmark"></i>
                <span>Cancelar</span>
            </a>


            <button
                type="reset"
                class="btn-reset"
                id="resetForm"
            >
                <i class="fa-solid fa-rotate-left"></i>
                <span>Reiniciar cambios</span>
            </button>


            <button
                type="submit"
                class="btn-update"
                id="submitButton"
            >
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Actualizar rol</span>
            </button>

        </div>

    </form>

</div>

</div>

@endsection

@push('js')
@vite('resources/js/role/edit.js')
@endpush
