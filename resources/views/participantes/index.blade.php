@extends('app')

@section('titulo')
    Listado de participantes
@endsection

@section('btn')
    <a href="{{ route('participantes.create') }}" class="btn btn-primary">Nuevo</a>
@endsection

@section('contenido')
    <section id="participantes" class="py-5 bg-light">
        <div class="container">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-dark text-white py-4">
                    <h3 class="mb-0 text-center">
                        <i class="fas fa-users me-2"></i>Lista de Participantes
                    </h3>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table id="tablaParticipantes" class="table table-hover table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nombre Completo</th>
                                    <th>Teléfono</th>
                                    <th>Correo</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Datos dinámicos -->
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item->nombre_participante }}</td>
                                        <td>{{ $item->telefono }}</td>
                                        <td>{{ $item->correo_electronico }}</td>
                                        <td>
                                            @if ($item->ponente)
                                                <span class="badge bg-primary">Ponente</span>
                                            @else
                                                <span class="badge bg-dark">No ponente</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('participantes.edit', $item) }}"
                                                class="btn btn-sm btn-warning">Editar</a>
                                            <form action="{{ route('participantes.destroy', $item) }}" method="POST"
                                                class="d-inline formEliminar">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('¿Está seguro de eliminar este participante?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection