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
                    </thead>
                    <tbody>
                    @foreach ($usuarios as $u)
                    <tr>
                        <td>{{$u->name}}</td>
                        <td>{{$u->email}}</td>
                        <td><form method="POST" action="{{ route('lista.del') }}" onsubmit="return confirm('¿Eliminar solo del chequeo diario {{$u->name}}?');">
                        @csrf
                            <input type="hidden" name="usuario" value="1">
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
                    </tr>
                    @endforeach
                    </tbody>
                    <tfoot><td><a class="btn" href="{{ url('/formulario') }}"><button type="submit" class="btn btn-success"> Agregar </button></a></td><td></td><td></td><td></td><td></td></tfoot>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
