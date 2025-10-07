@extends('app')

@section('titulo')
    Editar Participantes
@endsection

@section('btn')
    <a href="{{ route('participantes.index') }}" class="btn btn-primary">Regresar</a>
@endsection

@section('contenido')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-6">
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-warning text-dark py-3">
                            <h4 class="mb-0">
                                <i class="fas fa-edit me-2"></i>Editar Participante
                            </h4>
                        </div>
                        <div class="card-body p-4">

                            <!-- Mostrar errores de validación -->
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <strong><i class="fas fa-exclamation-triangle me-2"></i>Error:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('participantes.update', $item) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="nombre" class="form-label">
                                        <i class="fas fa-user me-1"></i>Nombre Completo
                                    </label>
                                    <input class="form-control @error('nombre_participante') is-invalid @enderror" 
                                           type="text" 
                                           name="nombre_participante"
                                           value="{{ old('nombre_participante', $item->nombre_participante) }}"
                                           required>
                                    @error('nombre_participante')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="telefono" class="form-label">
                                        <i class="fas fa-phone me-1"></i>Teléfono
                                    </label>
                                    <input class="form-control @error('telefono') is-invalid @enderror" 
                                           type="text" 
                                           name="telefono" 
                                           value="{{ old('telefono', $item->telefono) }}"
                                           required>
                                    @error('telefono')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="correo" class="form-label">
                                        <i class="fas fa-envelope me-1"></i>Correo Electrónico
                                    </label>
                                    <input class="form-control @error('correo_electronico') is-invalid @enderror" 
                                           type="email" 
                                           name="correo_electronico"
                                           value="{{ old('correo_electronico', $item->correo_electronico) }}"
                                           required>
                                    @error('correo_electronico')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="ponente" class="form-label">
                                        <i class="fas fa-microphone me-1"></i>Tipo de Participación
                                    </label>
                                    <select class="form-control @error('ponente') is-invalid @enderror" 
                                            name="ponente"
                                            required>
                                        <option value="0" {{ old('ponente', $item->ponente) == 0 ? 'selected' : '' }}>
                                            No ponente
                                        </option>
                                        <option value="1" {{ old('ponente', $item->ponente) == 1 ? 'selected' : '' }}>
                                            Ponente
                                        </option>
                                    </select>
                                    @error('ponente')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <hr>

                                <div class="d-grid gap-2">
                                    <button class="btn btn-warning btn-lg" type="submit">
                                        <i class="fas fa-save me-2"></i>Guardar Cambios
                                    </button>
                                    <a href="{{ route('participantes.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i>Cancelar
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection