@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-sm border-light">
        <div class="card-header bg-primary text-white">
          <h4 class="mb-0">Editar Evento</h4>
        </div>

        <div class="card-body">
          <form action="{{ route('eventos.update', $evento->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Datos básicos del evento -->
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

            <!-- Lugar (fijo) -->
            <div class="mb-3">
              <label for="lugar_id" class="form-label">Lugar</label>
              <select name="lugar_id" id="lugar_id" class="form-select" disabled>
                <option value="">-- Selecciona un lugar --</option>
                @foreach($lugares as $lugar)
                {{-- @dd($lugares) --}}
                  <option value="{{ $lugar->id }}" data-imagen="{{ asset('storage/' . $lugar->imagen) }}" {{ $lugar->id == $evento->lugar ? 'selected' : '' }}>
                    {{ $lugar->nombre }}
                  </option>
                @endforeach
              </select>
              <!-- Input hidden para enviar el valor del lugar -->
              <input type="hidden" id=id_lugar name="id_lugar" value="{{ $evento->lugar }}">
            </div>
            <div id="imagenLugar" class="mb-3 text-center">
              <img id="previewImagenLugar" src="{{ asset('storage/' . optional($evento->lugar)->imagen) }}" class="img-fluid" style="max-width: 300px;">
            </div>

            <div class="mb-3">
              <label for="capacidad" class="form-label">Capacidad</label>
              <input type="number" name="capacidad" id="capacidad" class="form-control" value="{{ old('capacidad', $evento->capacidad) }}" required>
            </div>

            <div class="mb-3">
              <label for="imagen" class="form-label">Imagen del Evento</label>
              <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
              @if ($evento->imagen)
                <div class="mt-2">
                  <img src="{{ asset('storage/' . $evento->imagen) }}" alt="Imagen del evento" class="img-thumbnail" width="200">
                </div>
              @endif
            </div>

            <div class="mb-3">
              <label for="estado" class="form-label">Estado</label>
              <select name="estado" id="estado" class="form-select" required>
                <option value="activo" {{ $evento->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                <option value="finalizado" {{ $evento->estado == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                <option value="cancelado" {{ $evento->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
              </select>
            </div>

            <hr>

            <!-- Tipos de Entradas -->
            <h5>Tipos de Entradas</h5>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Tipo de Entrada</th>
                  <th>Precio</th>
                  <th>Stock</th>
                  <th>Posición</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody id="tiposEntradaContainer">
                @foreach($evento->tiposEntrada as $index => $entrada)
                <tr>
                  <td>
                    <input type="text" name="tipos_entrada[{{ $index }}][nombre]" class="form-control" value="{{ old("tipos_entrada.$index.nombre", $entrada->nombre) }}" required>
                  </td>
                  <td>
                    <input type="number" name="tipos_entrada[{{ $index }}][precio]" class="form-control" value="{{ old("tipos_entrada.$index.precio", $entrada->precio) }}" required>
                  </td>
                  <td>
                    <input type="number" name="tipos_entrada[{{ $index }}][stock]" class="form-control" value="{{ old("tipos_entrada.$index.stock", $entrada->stock) }}" required>
                  </td>
                  <td>
                    <select name="tipos_entrada[{{ $index }}][posicion_id]" class="form-control" required data-selected="{{ $entrada->posicion_id }}">
                      <option value="">Selecciona una posición</option>
                      <!-- Se cargarán las opciones vía JavaScript -->
                    </select>
                  </td>
                  <td>
                    <button type="button" class="btn btn-danger btn-sm eliminarEntrada">Eliminar</button>
                  </td>
                </tr>
                @endforeach
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

<!-- Script para manejar los tipos de entrada y cargar posiciones -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const container = document.getElementById('tiposEntradaContainer');
  const btnAgregar = document.getElementById('agregarEntrada');
  let rowIndex = {{ $evento->tiposEntrada->count() }};
  let posicionesDisponibles = []; // Almacenará las posiciones según el lugar fijo

  // Función para crear una nueva fila de entrada
  function crearFilaEntrada() {
    const row = document.createElement('tr');
    let opciones = '<option value="">Selecciona una posición</option>';
    if (posicionesDisponibles.length > 0) {
      posicionesDisponibles.forEach(posicion => {
        opciones += `<option value="${posicion.id}">${posicion.posicion}</option>`;
      });
    }
    row.innerHTML = `
      <td><input type="text" name="tipos_entrada[${rowIndex}][nombre]" class="form-control" required></td>
      <td><input type="number" name="tipos_entrada[${rowIndex}][precio]" class="form-control" required></td>
      <td><input type="number" name="tipos_entrada[${rowIndex}][stock]" class="form-control" required></td>
      <td>
        <select name="tipos_entrada[${rowIndex}][posicion_id]" class="form-control" required>
          ${opciones}
        </select>
      </td>
      <td><button type="button" class="btn btn-danger btn-sm eliminarEntrada">Eliminar</button></td>
    `;
    container.appendChild(row);
    rowIndex++;

    row.querySelector('.eliminarEntrada').addEventListener('click', function() {
      row.remove();
    });
  }

  btnAgregar.addEventListener('click', function() {
    crearFilaEntrada();
  });

  // Función para cargar las posiciones basadas en el lugar fijo
  function cargarPosiciones() {
    const lugarId = document.getElementById('id_lugar').value;
    // console.log("El lugar seleccionad", lugarId);
    if (lugarId) {
        
      fetch(`/lugares/${lugarId}/posiciones`)
        .then(response => response.json())
        .then(data => {
          posicionesDisponibles = data;
          // Actualizar todos los selects de posición existentes
          const selects = document.querySelectorAll('select[name$="[posicion_id]"]');
          selects.forEach(select => {
            // Conservamos el valor seleccionado (almacenado en data-selected, si lo tiene)
            const valorSeleccionado = select.dataset.selected ? select.dataset.selected : "";
            select.innerHTML = '<option value="">Selecciona una posición</option>';
            data.forEach(posicion => {
              const option = document.createElement('option');
              option.value = posicion.id;
              option.textContent = posicion.posicion;
              if(valorSeleccionado == posicion.id) {
                option.selected = true;
              }
              select.appendChild(option);
            });
          });
        })
        .catch(error => {
          console.error('Error al obtener posiciones:', error);
        });
    } else {
      posicionesDisponibles = [];
      const selects = document.querySelectorAll('select[name$="[posicion_id]"]');
      selects.forEach(select => {
        select.innerHTML = '<option value="">Selecciona una posición</option>';
      });
    }
  }

  // Cargar las posiciones al iniciar (ya que lugar_id es fijo)
  cargarPosiciones();
});
</script>
@endsection
