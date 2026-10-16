@extends('layouts.app')

@section('title', 'Editar Usuario')

@push('css')
    @vite('resources/css/user/edit.css')
@endpush

@section('content')

<div class="user-edit-page">

    <div class="container-fluid px-4">

        {{-- Encabezado --}}
        <div class="page-header">

            <div>
                <h1>Editar Usuario</h1>

                <p>
                    Actualiza la información y configuración de la cuenta.
                </p>
            </div>

            <div class="page-icon">
                <i class="fas fa-user-pen"></i>
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
                Editar Usuario
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
                        Modifique los datos que desea actualizar de la cuenta.
                    </p>
                </div>

            </div>


            <form
                action="{{ route('users.update', ['user' => $user]) }}"
                method="POST"
                id="userEditForm"
            >

                @method('PATCH')
                @csrf


                <div class="user-card-body">


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
                            value="{{ old('name', $user->name) }}"
                            placeholder="Ingrese el nombre del usuario"
                        >

                        <small class="field-help">
                            Modifique el nombre que utilizará el usuario.
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
                            value="{{ old('email', $user->email) }}"
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
                            Nueva contraseña
                        </label>

                        <div class="password-wrapper">

                            <input
                                type="password"
                                name="password"
                                id="password"
                                autocomplete="new-password"
                                class="form-control-custom @error('password') is-invalid @enderror"
                                placeholder="Dejar vacío para conservar la actual"
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
                        </label>

                        <div class="password-wrapper">

                            <input
                                type="password"
                                name="password_confirm"
                                id="password_confirm"
                                autocomplete="new-password"
                                class="form-control-custom @error('password_confirm') is-invalid @enderror"
                                placeholder="Repita la nueva contraseña"
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
                            Complete este campo solamente si cambia la contraseña.
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

                            @foreach ($roles as $item)

                                <option
                                    value="{{ $item->name }}"
                                    @selected(
                                        old(
                                            'role',
                                            $user->roles->pluck('name')->first()
                                        ) == $item->name
                                    )
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
                        id="updateUserBtn"
                    >
                        <i class="fas fa-save"></i>
                        Actualizar Usuario
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

@push('js')
    @vite('resources/js/user/edit.js')
@endpush
