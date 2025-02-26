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
                                <label for="lugar" class="form-label">Lugar</label>
                                <input type="text" name="lugar" id="lugar" class="form-control" placeholder="Lugar del evento" required>
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
@endsection
