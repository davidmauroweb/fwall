@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Lista de Usuarios') }}</div>
                <div class="card-body">
                <table class="table table-sn table-hover">
                    <thead>
                        <th>clientId</th>
                        <th>Mail</th>
                        <th><i class="bi bi-person-dash-fill"></i></th>
                        <th><i class="bi bi-person-x-fill"></i></th>
                        <th><i class="bi bi-list-check"></i></th>
                        <th><i class="bi bi-key-fill"></i></th>
                    </thead>
                    <tbody>
                    @foreach ($usuarios as $u)
                    <tr>
                        <td>{{$u->name}}</td>
                        <td>{{$u->email}}</td>
                        <td><form method="POST" action="{{ route('lista.del') }}" onsubmit="return confirm('¿Eliminar solo los registros {{$u->name}}?');">
                        @csrf
                            <input type="hidden" name="registro" value="1">
                            <input type="hidden" name="us" value="{{$u->name}}">
                            <button class="btn btn-warning btn-sm" type="submit"><i class="bi bi-person-dash-fill"></i></button>
                        </form></td>
                        <td><form method="POST" action="{{ route('lista.del') }}" onsubmit="return confirm('¿Eliminar por completo {{$u->name}}?');">
                        @csrf
                            <input type="hidden" name="todo" value="1">
                            <input type="hidden" name="us" value="{{$u->name}}">
                            <button class="btn btn-danger btn-sm" type="submit"><i class="bi bi-person-x-fill"></i></button>
                        </form></td>
                        <td><form method="POST" action="{{ route('home.show2') }}">
                        @csrf
                            <input type="hidden" name="clientId" id="clientId" value="{{$u->name}}">
                            <button class="btn btn-secondary btn-sm" type="submit"><i class="bi bi-list-check"></i></button></form>
                        </td>
                        <td>
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#us{{$u->id}}">
                            <i class="bi bi-key-fill"></i>
                            </button>

                            <!-- Modal -->
                                <div class="modal fade" id="us{{$u->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form  method="POST" action="{{ route('lista.clave') }}">
                                        @csrf
                                        <input type="hidden" name="usr" value="{{$u->id}}">
                                        <input type="hidden" name="name" value="{{$u->name}}">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Cambio Clave {{$u->name}}</h5>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Clave') }}</label>
                                                <div class="col-md-6">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                </div>
                                        </div>

                                        <div class="row mb-3">
                                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Repetir Clave') }}</label>

                                                <div class="col-md-6">
                                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                                </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary btn-sm">Cambiar</button>
                                    </div>
                                    </div>
                                    </form>
                                </div>
                                </div>
                            <!-- Modal -->

                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                    <tfoot><td><a class="btn" href="{{ url('/formulario') }}"><button type="submit" class="btn btn-success"> Agregar </button></a></td><td></td><td></td><td></td><td></td></tfoot>
                </table>
                <h5>Top 6 Clientes con mas actividad</h5>
                <table class="table table-sn table-hover">
                        <thead><th>clientId</th><th>Total</th></thead>
                        <tbody>
                        @foreach ($top as $t)
                        <tr><td>{{$t->userId}}</td><td>{{$t->total}}</td></tr>
                        @endforeach
                        </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
