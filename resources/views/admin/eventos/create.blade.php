@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-light">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Crear Evento</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('eventos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Evento</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del evento" required>
                        </div>

                        <div class="mb-3">
                            <label for="artista" class="form-label">Artista</label>
                            <input type="text" name="artista" id="artista" class="form-control" placeholder="Nombre del artista" required>
                        </div>

                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" name="fecha" id="fecha" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="hora" class="form-label">Hora</label>
                            <input type="time" name="hora" id="hora" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="lugar_id" class="form-label">Lugar</label>
                            <select name="lugar_id" id="lugar_id" class="form-select" required>
                                <option value="">-- Selecciona un lugar --</option>
                                @foreach($lugares as $lugar)
                                    <option value="{{ $lugar->id }}" data-imagen="{{ asset('storage/' . $lugar->imagen) }}">
                                        {{ $lugar->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div id="imagenLugar" class="mb-3 text-center">
                            <img id="previewImagenLugar" src="" class="img-fluid" style="max-width: 300px; display: none;">
                        </div>

                        <div class="mb-3">
                            <label for="capacidad" class="form-label">Capacidad</label>
                            <input type="number" name="capacidad" id="capacidad" class="form-control" placeholder="Capacidad máxima" required>
                        </div>

                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen del Evento</label>
                            <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select name="estado" id="estado" class="form-select" required>
                                <option value="activo">Activo</option>
                                <option value="finalizado">Finalizado</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>

                        <hr>

                        <h5>Tipos de Entradas</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tipo de Entrada</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tiposEntradaContainer">
                                <!-- Se agregarán dinámicamente las filas -->
                            </tbody>
                        </table>

                        <button type="button" class="btn btn-primary mb-3" id="agregarEntrada">Agregar Entrada</button>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success">Guardar Evento</button>
                            <a href="{{ route('eventos.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('tiposEntradaContainer');
        const btnAgregar = document.getElementById('agregarEntrada');
        let rowIndex = 0; // Índice para cada nueva fila

        btnAgregar.addEventListener('click', function() {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><input type="text" name="tipos_entrada[${rowIndex}][nombre]" class="form-control" required></td>
                <td><input type="number" name="tipos_entrada[${rowIndex}][precio]" class="form-control" required></td>
                <td><input type="number" name="tipos_entrada[${rowIndex}][stock]" class="form-control" required></td>
                <td><button type="button" class="btn btn-danger btn-sm eliminarEntrada">Eliminar</button></td>
            `;
            container.appendChild(row);
            rowIndex++;

            // Agregar el listener para eliminar la fila
            row.querySelector('.eliminarEntrada').addEventListener('click', function() {
                row.remove();
            });
        });
    });

    document.getElementById('lugar_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const imageUrl = selectedOption.getAttribute('data-imagen');
    const preview = document.getElementById('previewImagenLugar');
    
    if (imageUrl) {
        preview.src = imageUrl;
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
});
</script>

@endsection
