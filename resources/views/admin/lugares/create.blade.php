@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-light">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Crear Lugar</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('lugares.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Lugar</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: Estadio Nacional" required>
                        </div>

                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen del Lugar</label>
                            <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
                        </div>

                        <hr>
                        <h5>Posiciones del Lugar</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tipo de Entrada</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="posicionesContainer">
                                <!-- Aquí se agregarán dinámicamente las filas -->
                            </tbody>
                        </table>

                        <button type="button" class="btn btn-primary mb-3" id="agregarPosicion">Agregar Posición</button>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success">Guardar Lugar</button>
                            <a href="{{ route('lugares.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('posicionesContainer');
        const btnAgregar = document.getElementById('agregarPosicion');
        let rowIndex = 0; // Índice para cada nueva fila

        btnAgregar.addEventListener('click', function() {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><input type="text" name="posiciones[]" class="form-control" placeholder="Ej: Tribuna, Campo, etc." required></td>
                <td><button type="button" class="btn btn-danger btn-sm eliminarPosicion">Eliminar</button></td>
            `;
            container.appendChild(row);
            rowIndex++;

            // Agregar evento para eliminar fila
            row.querySelector('.eliminarPosicion').addEventListener('click', function() {
                row.remove();
            });
        });
    });
</script>
@endsection
