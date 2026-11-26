@extends('layouts.admin')

@section('contenido')
<h1 class="mb-4">Recursos Humanos</h1>
<div class="card mb-4">
    <div class="card-header text-primary">Listado de Empleados - Ferretería La Bendición</div>
    <div class="card-body">
        @if ($empleados->isEmpty())
            <p class="text-muted mb-0">No hay empleados registrados.</p>
        @else
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        @foreach (array_keys((array) $empleados->first()) as $columna)
                            <th>{{ $columna }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($empleados as $empleado)
                        <tr>
                            @foreach ((array) $empleado as $valor)
                                <td>{{ $valor }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection