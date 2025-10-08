@extends('app')

@section('titulo')
    Resultado del Registro
@endsection

@section('contenido')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-body text-center p-5">
                        
                        @if(isset($exito) && $exito)
                            <div class="mb-4">
                                <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                            </div>
                            <h3 class="text-success mb-3">¡Registro Exitoso!</h3>
                            <p class="text-muted mb-4">
                                El participante ha sido registrado correctamente en el sistema.
                            </p>
                        @else           
                            <div class="mb-4">
                                <i class="fas fa-times-circle text-danger" style="font-size: 5rem;"></i>
                            </div>
                            <h3 class="text-danger mb-3">Error en el Registro</h3>
                            <p class="text-muted mb-4">
                                {{ $error ?? 'No se pudo completar el registro. Por favor, intente nuevamente.' }}
                            </p>
                        @endif

                        <div class="d-grid gap-2">
                            <a href="{{ route('participantes.create') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus me-2"></i>Registrar Nuevo Participante
                            </a>
                            <a href="{{ route('participantes.index') }}" class="btn btn-secondary">
                                <i class="fas fa-list me-2"></i>Ver Lista de Participantes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection