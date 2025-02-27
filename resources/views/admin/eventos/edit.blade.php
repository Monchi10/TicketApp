@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Editar Evento</h1>

        <form action="{{ route('eventos.update', $evento->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Evento</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $evento->nombre) }}" required>
            </div>

            <div class="mb-3">
                <label for="artista" class="form-label">Artista</label>
                <input type="text" name="artista" id="artista" class="form-control" value="{{ old('artista', $evento->artista) }}" required>
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha', $evento->fecha) }}" required>
            </div>

            <div class="mb-3">
                <label for="hora" class="form-label">Hora</label>
                <input type="time" name="hora" id="hora" class="form-control" value="{{ old('hora', $evento->hora) }}" required>
            </div>

            <div class="mb-3">
                <label for="lugar" class="form-label">Lugar</label>
                <input type="text" name="lugar" id="lugar" class="form-control" value="{{ old('lugar', $evento->lugar) }}" required>
            </div>

            <div class="mb-3">
                <label for="capacidad" class="form-label">Capacidad</label>
                <input type="number" name="capacidad" id="capacidad" class="form-control" value="{{ old('capacidad', $evento->capacidad) }}" required>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select name="estado" id="estado" class="form-control">
                    <option value="activo" {{ $evento->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="finalizado" {{ $evento->estado == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                    <option value="cancelado" {{ $evento->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen del Evento</label>
                <input type="file" name="imagen" id="imagen" class="form-control">
                @if ($evento->imagen)
                    <p class="mt-2">Imagen actual:</p>
                    <img src="{{ asset('storage/' . $evento->imagen) }}" alt="Imagen del evento" class="img-thumbnail" width="200">
                @endif
            </div>

            <hr>

            <h3>Tipos de Entrada</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="tiposEntradaContainer">
                    @foreach($evento->tiposEntrada as $entrada)
                        <tr>
                            <td><input type="text" name="tipos_entrada[{{ $loop->index }}][nombre]" class="form-control" value="{{ $entrada->nombre }}" required></td>
                            <td><input type="number" name="tipos_entrada[{{ $loop->index }}][precio]" class="form-control" value="{{ $entrada->precio }}" required></td>
                            <td><input type="number" name="tipos_entrada[{{ $loop->index }}][stock]" class="form-control" value="{{ $entrada->stock }}" required></td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm eliminarFila">Eliminar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="button" class="btn btn-success btn-sm" id="agregarEntrada">Agregar Entrada</button>

            <hr>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Guardar Evento</button>
                <a href="{{ route('eventos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let index = {{ $evento->tiposEntrada->count() }};
    
            document.getElementById("agregarEntrada").addEventListener("click", function() {
                let container = document.getElementById("tiposEntradaContainer");
                let nuevaFila = document.createElement("tr");
    
                nuevaFila.innerHTML = `
                    <td><input type="text" name="tipos_entrada[${index}][nombre]" class="form-control" required></td>
                    <td><input type="number" name="tipos_entrada[${index}][precio]" class="form-control" required></td>
                    <td><input type="number" name="tipos_entrada[${index}][stock]" class="form-control" required></td>
                    <td><button type="button" class="btn btn-danger btn-sm eliminarFila">Eliminar</button></td>
                `;
    
                container.appendChild(nuevaFila);
                index++;
            });
    
            document.getElementById("tiposEntradaContainer").addEventListener("click", function(event) {
                if (event.target.classList.contains("eliminarFila")) {
                    event.target.closest("tr").remove();
                }
            });
        });
    </script>
    
@endsection
