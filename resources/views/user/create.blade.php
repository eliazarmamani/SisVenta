@extends('layouts.app')

@section('title', 'Crear Usuario')

@push('css')
    @vite('resources/css/user/create.css')
@endpush

@section('content')

<div class="user-create-page">

    <div class="container-fluid px-4">

        {{-- Encabezado --}}
        <div class="page-header">
            <div>
                <h1>Crear Usuario</h1>
                <p>Registra un nuevo usuario para acceder al sistema.</p>
            </div>

            <div class="page-icon">
                <i class="fas fa-user-plus"></i>
            </div>
        </div>

        {{-- Breadcrumb --}}
        <ol class="breadcrumb user-breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('panel') }}">
                    <i class="fas fa-home"></i>
                    Inicio
                </a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('users.index') }}">
                    Usuarios
                </a>
            </li>

            <li class="breadcrumb-item active">
                Crear Usuario
            </li>
        </ol>

        {{-- Card principal --}}
        <div class="user-card">

            <div class="user-card-header">
                <div class="header-icon">
                    <i class="fas fa-user-shield"></i>
                </div>

                <div>
                    <h2>Información del usuario</h2>
                    <p>
                        Complete los datos necesarios para crear la cuenta.
                    </p>
                </div>
            </div>

            <form action="{{ route('users.store') }}" method="POST" id="userCreateForm">
                @csrf

                <div class="user-card-body">

                    {{-- Empleado --}}
                    <div class="form-group-custom">
                        <label for="empleado_id">
                            <i class="fas fa-id-card"></i>
                            Empleado
                            <span>*</span>
                        </label>

                        <select
                            name="empleado_id"
                            id="empleado_id"
                            class="form-control-custom @error('empleado_id') is-invalid @enderror"
                        >
                            <option value="" selected disabled>
                                Seleccione un empleado
                            </option>

                            @foreach ($empleados as $item)
                                <option
                                    value="{{ $item->id }}"
                                    @selected(old('empleado_id') == $item->id)
                                >
                                    {{ $item->razon_social }}
                                </option>
                            @endforeach
                        </select>

                        <small class="field-help">
                            Seleccione el empleado asociado a esta cuenta.
                        </small>

                        @error('empleado_id')
                            <small class="field-error">
                                <i class="fas fa-circle-exclamation"></i>
                                {{ $message }}
                            </small>
                        @enderror
                    </div>


                    {{-- Nombre --}}
                    <div class="form-group-custom">
                        <label for="name">
                            <i class="fas fa-user"></i>
                            Nombres
                            <span>*</span>
                        </label>

                        <input
                            type="text"
                            name="name"
                            id="name"
                            autocomplete="off"
                            class="form-control-custom @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="Ingrese el nombre del usuario"
                        >

                        <small class="field-help">
                            Escriba el nombre que utilizará el usuario.
                        </small>

                        @error('name')
                            <small class="field-error">
                                <i class="fas fa-circle-exclamation"></i>
                                {{ $message }}
                            </small>
                        @enderror
                    </div>


                    {{-- Email --}}
                    <div class="form-group-custom">
                        <label for="email">
                            <i class="fas fa-envelope"></i>
                            Correo electrónico
                            <span>*</span>
                        </label>

                        <input
                            type="email"
                            name="email"
                            id="email"
                            autocomplete="off"
                            class="form-control-custom @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            placeholder="ejemplo@correo.com"
                        >

                        <small class="field-help">
                            Utilice un correo electrónico válido para iniciar sesión.
                        </small>

                        @error('email')
                            <small class="field-error">
                                <i class="fas fa-circle-exclamation"></i>
                                {{ $message }}
                            </small>
                        @enderror
                    </div>


                    {{-- Contraseña --}}
                    <div class="form-group-custom">
                        <label for="password">
                            <i class="fas fa-lock"></i>
                            Contraseña
                            <span>*</span>
                        </label>

                        <div class="password-wrapper">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control-custom @error('password') is-invalid @enderror"
                                placeholder="Ingrese una contraseña segura"
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                data-target="password"
                                aria-label="Mostrar contraseña"
                            >
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>

                        <div class="password-strength">
                            <div class="strength-bar">
                                <span id="strengthBar"></span>
                            </div>

                            <small id="strengthText">
                                Seguridad de contraseña
                            </small>
                        </div>

                        @error('password')
                            <small class="field-error">
                                <i class="fas fa-circle-exclamation"></i>
                                {{ $message }}
                            </small>
                        @enderror
                    </div>


                    {{-- Confirmar contraseña --}}
                    <div class="form-group-custom">
                        <label for="password_confirm">
                            <i class="fas fa-lock"></i>
                            Confirmar contraseña
                            <span>*</span>
                        </label>

                        <div class="password-wrapper">
                            <input
                                type="password"
                                name="password_confirm"
                                id="password_confirm"
                                class="form-control-custom @error('password_confirm') is-invalid @enderror"
                                placeholder="Repita la contraseña"
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                data-target="password_confirm"
                                aria-label="Mostrar contraseña"
                            >
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>

                        <small id="passwordMatch" class="field-help">
                            Vuelva a escribir la contraseña para confirmarla.
                        </small>

                        @error('password_confirm')
                            <small class="field-error">
                                <i class="fas fa-circle-exclamation"></i>
                                {{ $message }}
                            </small>
                        @enderror
                    </div>


                    {{-- Rol --}}
                    <div class="form-group-custom">
                        <label for="role">
                            <i class="fas fa-user-shield"></i>
                            Rol del usuario
                            <span>*</span>
                        </label>

                        <select
                            name="role"
                            id="role"
                            class="form-control-custom @error('role') is-invalid @enderror"
                        >
                            <option value="" selected disabled>
                                Seleccione un rol
                            </option>

                            @foreach ($roles as $item)
                                <option
                                    value="{{ $item->name }}"
                                    @selected(old('role') == $item->name)
                                >
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>

                        <small class="field-help">
                            El rol determina los permisos que tendrá el usuario.
                        </small>

                        @error('role')
                            <small class="field-error">
                                <i class="fas fa-circle-exclamation"></i>
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                </div>


                {{-- Footer --}}
                <div class="user-card-footer">

                    <a
                        href="{{ route('users.index') }}"
                        class="btn-secondary-custom"
                    >
                        <i class="fas fa-arrow-left"></i>
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="btn-primary-custom"
                        id="saveUserBtn"
                    >
                        <i class="fas fa-user-plus"></i>
                        Crear Usuario
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

@push('js')
    @vite('resources/js/user/create.js')
@endpush