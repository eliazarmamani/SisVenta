@extends('layouts.app')

@section('title', 'Crear rol')


{{-- =========================================================
    CSS DEL MÓDULO
========================================================= --}}
@push('css')
    @vite('resources/css/role/create.css')
@endpush


@section('content')

<div class="role-create-page">

    <div class="container-fluid px-4">


        {{-- =====================================================
            ENCABEZADO
        ====================================================== --}}
        <div class="page-header">

            <div class="page-title">

                <div class="page-title-icon">
                    <i class="fa-solid fa-user-shield"></i>
                </div>

                <div>

                    <div class="page-title-row">

                        <h1>
                            Crear rol
                        </h1>

                        <span class="page-title-badge">
                            <i class="fa-solid fa-shield-halved"></i>
                            Seguridad
                        </span>

                    </div>

                    <p>
                        Define un nuevo rol y asigna los permisos
                        correspondientes.
                    </p>

                </div>

            </div>


            {{-- BOTÓN VOLVER --}}
            <a
                href="{{ route('roles.index') }}"
                class="btn-back"
            >
                <i class="fa-solid fa-arrow-left"></i>
                <span>Volver a roles</span>
            </a>

        </div>


        {{-- =====================================================
            NAVEGACIÓN
        ====================================================== --}}
        <div class="page-navigation">

            <a
                href="{{ route('panel') }}"
                class="navigation-button"
            >
                <i class="fa-solid fa-house"></i>
                <span>Inicio</span>
            </a>

            <span class="navigation-separator">
                /
            </span>

            <a
                href="{{ route('roles.index') }}"
                class="navigation-button"
            >
                <i class="fa-solid fa-user-shield"></i>
                <span>Roles</span>
            </a>

            <span class="navigation-separator">
                /
            </span>

            <span class="navigation-current">
                Crear rol
            </span>

        </div>


        {{-- =====================================================
            FORMULARIO
        ====================================================== --}}
        <form
            action="{{ route('roles.store') }}"
            method="POST"
            id="roleCreateForm"
        >

            @csrf


            <div class="row g-4">


                {{-- =================================================
                    INFORMACIÓN DEL ROL
                ================================================== --}}
                <div class="col-lg-5">

                    <div class="role-card">

                        {{-- CABECERA --}}
                        <div class="card-header-custom">

                            <div class="header-icon">
                                <i class="fa-solid fa-id-badge"></i>
                            </div>

                            <div>

                                <h2>
                                    Información del rol
                                </h2>

                                <p>
                                    Ingresa los datos principales del nuevo rol.
                                </p>

                            </div>

                        </div>


                        {{-- CUERPO --}}
                        <div class="card-body-custom">

                            <div class="form-group-custom">

                                <label for="name">

                                    Nombre del rol

                                    <span>
                                        *
                                    </span>

                                </label>


                                <div class="input-wrapper">

                                    <i class="fa-solid fa-user-tag"></i>

                                    <input
                                        autocomplete="off"
                                        type="text"
                                        name="name"
                                        id="name"
                                        class="form-control-custom @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}"
                                        placeholder="Ej. Vendedor"
                                        maxlength="50"
                                    >

                                </div>


                                @error('name')

                                    <div class="error-message">

                                        <i class="fa-solid fa-circle-exclamation"></i>

                                        {{ $message }}

                                    </div>

                                @enderror


                                <small class="input-help">
                                    Utiliza un nombre claro y fácil de identificar.
                                </small>

                            </div>


                            {{-- INFORMACIÓN --}}
                            <div class="role-info-box">

                                <div class="info-icon">
                                    <i class="fa-solid fa-lightbulb"></i>
                                </div>

                                <div>

                                    <strong>
                                        ¿Qué es un rol?
                                    </strong>

                                    <p>
                                        Un rol agrupa diferentes permisos que determinan
                                        las acciones que un usuario puede realizar dentro
                                        del sistema.
                                    </p>

                                </div>

                            </div>


                            {{-- CONSEJO --}}
                            <div class="role-tip">

                                <i class="fa-solid fa-circle-info"></i>

                                <span>
                                    Después de crear el rol podrás modificar sus permisos.
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


                        {{-- CABECERA --}}
                        <div class="card-header-custom permissions-header">

                            <div class="header-icon">
                                <i class="fa-solid fa-key"></i>
                            </div>

                            <div class="permissions-title">

                                <div>

                                    <h2>
                                        Permisos del rol
                                    </h2>

                                    <p>
                                        Selecciona las acciones que podrá realizar este rol.
                                    </p>

                                </div>


                                <div class="permission-counter">

                                    <strong id="selectedCount">
                                        0
                                    </strong>

                                    <small>
                                        seleccionados
                                    </small>

                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                            HERRAMIENTAS
                        ================================================== --}}
                        <div class="permissions-toolbar">


                            {{-- BUSCAR --}}
                            <div class="search-permissions">

                                <i class="fa-solid fa-search"></i>

                                <input
                                    type="text"
                                    id="permissionSearch"
                                    placeholder="Buscar permiso..."
                                    autocomplete="off"
                                >

                            </div>


                            {{-- SELECCIONAR --}}
                            <button
                                type="button"
                                id="selectAll"
                                class="permission-action"
                            >

                                <i class="fa-solid fa-check-double"></i>

                                <span>
                                    Seleccionar todos
                                </span>

                            </button>


                            {{-- LIMPIAR --}}
                            <button
                                type="button"
                                id="clearAll"
                                class="permission-action clear"
                            >

                                <i class="fa-solid fa-eraser"></i>

                                <span>
                                    Limpiar
                                </span>

                            </button>

                        </div>


                        {{-- =================================================
                            LISTA DE PERMISOS
                        ================================================== --}}
                        <div class="permissions-container">

                            @forelse ($permisos as $item)

                                <label
                                    class="permission-item"
                                    data-permission="{{ strtolower($item->name) }}"
                                >

                                    <input
                                        type="checkbox"
                                        name="permission[]"
                                        value="{{ $item->id }}"
                                        class="permission-checkbox"
                                        {{ in_array($item->id, old('permission', [])) ? 'checked' : '' }}
                                    >

                                    <span class="custom-check">

                                        <i class="fa-solid fa-check"></i>

                                    </span>

                                    <span class="permission-content">

                                        <strong>
                                            {{ $item->name }}
                                        </strong>

                                        <small>
                                            Permiso del sistema
                                        </small>

                                    </span>

                                </label>

                            @empty

                                <div class="empty-permissions">

                                    <div class="empty-permissions-icon">
                                        <i class="fa-solid fa-shield-halved"></i>
                                    </div>

                                    <h3>
                                        No hay permisos disponibles
                                    </h3>

                                    <p>
                                        Actualmente no existen permisos registrados
                                        para asignar al rol.
                                    </p>

                                </div>

                            @endforelse

                        </div>


                        {{-- ERROR PERMISOS --}}
                        @error('permission')

                            <div class="permission-error">

                                <i class="fa-solid fa-circle-exclamation"></i>

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                </div>

            </div>


            {{-- =====================================================
                ACCIONES
            ====================================================== --}}
            <div class="form-actions">


                {{-- CANCELAR --}}
                <a
                    href="{{ route('roles.index') }}"
                    class="btn-cancel"
                >

                    <i class="fa-solid fa-xmark"></i>

                    <span>
                        Cancelar
                    </span>

                </a>


                {{-- GUARDAR --}}
                <button
                    type="submit"
                    class="btn-save"
                    id="saveRole"
                >

                    <i class="fa-solid fa-floppy-disk"></i>

                    <span>
                        Guardar rol
                    </span>

                </button>

            </div>

        </form>

    </div>

</div>

@endsection


{{-- =========================================================
    JAVASCRIPT
========================================================= --}}
@push('js')

    @vite('resources/js/role/create.js')

@endpush