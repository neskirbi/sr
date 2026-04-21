<!DOCTYPE html>
<html lang="en">
<head>
  @include('administradores.header')
  <title>{{GetBrand()}} | Operadores</title>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
@include('toast.toasts')  
<div class="wrapper">

  @include('administradores.navigations.navigation')
  @include('administradores.sidebars.sidebar')

  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        
        <!-- Tarjeta principal -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-users text-info" aria-hidden="true"></i> 
                  <strong>Gestión de Operadores</strong>
                </h3>
                <div class="card-tools">
                  <span class="badge badge-info p-2">
                    <i class="fas fa-user-check"></i> Total: {{ $operadores->count() }}
                  </span>
                </div>
              </div>
              
              <div class="card-body">
                
                <!-- === LISTADO DE OPERADORES EXISTENTES === -->
                @foreach($operadores as $operador)
                <div class="card mb-4 shadow-sm">
                  <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <i class="fas fa-user-circle fa-2x text-info mr-2"></i>
                        <strong class="text-dark">{{ $operador->nombres }} {{ $operador->apellidos }}</strong>
                      </div>
                      <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalEliminar{{ $operador->id }}">
                        <i class="fas fa-trash-alt"></i> Eliminar
                      </button>
                    </div>
                  </div>
                  
                  <div class="card-body">
                    <form action="{{ url('administracion\operadores') }}/{{ $operador->id }}" method="post">
                      @csrf
                      @method('put')
                      
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label><i class="fas fa-user"></i> Nombre(s)</label>
                            <input type="text" class="form-control" name="nombres" value="{{ $operador->nombres }}" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label><i class="fas fa-user-tag"></i> Apellidos</label>
                            <input type="text" class="form-control" name="apellidos" value="{{ $operador->apellidos }}" required>
                          </div>
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label><i class="fas fa-envelope"></i> Correo electrónico</label>
                            <input type="email" class="form-control" name="mail" value="{{ $operador->mail }}" required>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label><i class="fas fa-phone"></i> Teléfono</label>
                            <input type="tel" class="form-control" name="telefono" value="{{ $operador->telefono ?? '' }}" placeholder="Ej: 5512345678" required>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label><i class="fas fa-key"></i> Contraseña temporal</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text" style="cursor:pointer; background:#f59e0b; color:white;" onclick="GenerarPass('{{ $operador->id }}');">
                                  <i class="fas fa-sync-alt"></i>
                                </span>
                              </div>
                              <input type="text" class="form-control" id="temp_{{ $operador->id }}" name="temp" value="{{ $operador->temp }}" readonly>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col-12 text-right">
                          <button type="submit" class="btn btn-info">
                            <i class="fas fa-save"></i> Actualizar operador
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>

                <!-- MODAL DE CONFIRMACIÓN PARA ELIMINAR (cada operador) -->
                <div class="modal fade" id="modalEliminar{{ $operador->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEliminarLabel{{ $operador->id }}" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="modalEliminarLabel{{ $operador->id }}">
                          <i class="fas fa-exclamation-triangle"></i> Confirmar eliminación
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="text-center mb-3">
                          <i class="fas fa-user-slash fa-4x text-danger"></i>
                        </div>
                        <p class="text-center">
                          ¿Estás seguro de que deseas eliminar al operador?
                        </p>
                        <div class="alert alert-info text-center">
                          <strong>{{ $operador->nombres }} {{ $operador->apellidos }}</strong><br>
                          <small>{{ $operador->mail }}</small>
                        </div>
                        <p class="text-danger text-center small">
                          <i class="fas fa-info-circle"></i> Esta acción no se puede deshacer.
                        </p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                          <i class="fas fa-times"></i> Cancelar
                        </button>
                        <form action="{{ url('administracion\operadores') }}/{{ $operador->id }}" method="post" style="display:inline;">
                          @csrf
                          @method('delete')
                          <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Sí, eliminar
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach

                <!-- === FORMULARIO PARA AGREGAR NUEVO OPERADOR === -->
                <div class="card card-info mt-4">
                  <div class="card-header">
                    <h3 class="card-title">
                      <i class="fas fa-user-plus"></i> <strong>Agregar nuevo operador</strong>
                    </h3>
                  </div>
                  <div class="card-body">
                    <form action="{{ url('administracion\operadores') }}" method="post">
                      @csrf
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label><i class="fas fa-user"></i> Nombre(s)</label>
                            <input type="text" class="form-control" name="nombres" placeholder="Ej: Juan Carlos" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label><i class="fas fa-user-tag"></i> Apellidos</label>
                            <input type="text" class="form-control" name="apellidos" placeholder="Ej: Pérez González" required>
                          </div>
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label><i class="fas fa-envelope"></i> Correo electrónico</label>
                            <input type="email" class="form-control" name="mail" placeholder="operador@ejemplo.com" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label><i class="fas fa-phone"></i> Teléfono</label>
                            <input type="tel" class="form-control" name="telefono" placeholder="Ej: 5512345678" required>
                          </div>
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col-12 text-right">
                          <button type="submit" class="btn btn-info">
                            <i class="fas fa-save"></i> Guardar operador
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>

      </div>
    </section>
  </div>

  <footer class="main-footer"></footer>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);

 
</script>
@include('footer')
</body>
</html>