<footer class="py-3 mt-auto bg-white border-top">
    <div class="container-fluid px-4">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2 small">

            {{-- Información del sistema --}}
            <div class="text-muted text-center text-md-start">
                <span class="fw-semibold text-dark">SisVenta</span>
                <span class="mx-1">©</span>
                {{ date('Y') }}
                <span class="mx-1">|</span>
                Sistema de gestión de ventas
            </div>

            {{-- Información técnica --}}
            <div class="text-muted text-center">
                <span>Laravel v.{{ app()->version() }}</span>
                <span class="mx-1">·</span>
                <span>PHP v.{{ phpversion() }}</span>
            </div>

        </div>
    </div>
</footer>