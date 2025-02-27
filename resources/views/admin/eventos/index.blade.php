@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Lista de Eventos</h2>
        <a href="{{ route('eventos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Crear Nuevo Evento
        </a>
    </div>

    <!-- Campo de búsqueda -->
    <div class="mb-3">
        <input type="text" id="buscador" class="form-control" placeholder="Buscar evento por nombre o fecha...">
    </div>

    <div class="card shadow-sm border-light">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaEventos">
                    @foreach($eventos as $evento)
                        <tr>
                            <td>
                                <a href="{{ route('eventos.show', $evento->id) }}" class="text-decoration-none">
                                    {{ $evento->nombre }}
                                </a>
                            </td>
                            <td>{{ $evento->fecha }}</td>
                            <td>
                                <a href="{{ route('eventos.edit', $evento->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('eventos.destroy', $evento->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este evento?');">
                                        <i class="fas fa-trash-alt"></i> Eliminar
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

<script>
    document.getElementById('buscador').addEventListener('keyup', function() {
        let filtro = this.value.toLowerCase();
        let filas = document.querySelectorAll('#tablaEventos tr');

        filas.forEach(fila => {
            let nombre = fila.children[0].textContent.toLowerCase();
            let fecha = fila.children[1].textContent.toLowerCase();
            if (nombre.includes(filtro) || fecha.includes(filtro)) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    });
</script>
@endsection
