@extends('app')

@section('titulo')
    Registrar Participantes
@endsection

@section('btn')
    <a href="{{ route('participantes.index') }}" class="btn btn-primary">Regresar</a>
@endsection

@section('contenido')
    <section id="registro" class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-primary text-white text-center py-4">
                            <h3 class="mb-0">
                                <i class="fas fa-clipboard-list me-2"></i>Formulario de Registro
                            </h3>
                        </div>
                        <div class="card-body p-4">

                            <form action="{{route('participantes.store')}}" method="POST">
                                @csrf
                                
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">
                                        <i class="fas fa-user me-1"></i>Nombre Completo
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('nombre_participante') is-invalid @enderror" 
                                           name="nombre_participante" 
                                           value="{{ old('nombre_participante') }}"
                                           required>
                                    @error('nombre_participante')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="telefono" class="form-label">
                                        <i class="fas fa-phone me-1"></i>Teléfono
                                    </label>
                                    <input type="tel" 
                                           class="form-control @error('telefono') is-invalid @enderror" 
                                           name="telefono" 
                                           value="{{ old('telefono') }}"
                                           required>
                                    @error('telefono')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="correo" class="form-label">
                                        <i class="fas fa-envelope me-1"></i>Correo Electrónico
                                    </label>
                                    <input type="email" 
                                           class="form-control @error('correo_electronico') is-invalid @enderror" 
                                           id="correo" 
                                           name="correo_electronico" 
                                           value="{{ old('correo_electronico') }}"
                                           required>
                                    @error('correo_electronico')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-microphone me-1"></i>Tipo de Participación
                                    </label>
                                    <select class="form-select @error('ponente') is-invalid @enderror" 
                                            id="ponente" 
                                            name="ponente" 
                                            required>
                                        <option value="" {{ old('ponente') === null ? 'selected' : '' }} disabled>
                                            Seleccione una opción
                                        </option>
                                        <option value="1" {{ old('ponente') == '1' ? 'selected' : '' }}>
                                            Ponente
                                        </option>
                                        <option value="0" {{ old('ponente') == '0' ? 'selected' : '' }}>
                                            No ponente
                                        </option>
                                    </select>
                                    @error('ponente')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-check-circle me-2"></i>Registrar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection