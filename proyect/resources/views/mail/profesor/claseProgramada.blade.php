<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Clase Programada</title>
</head>
<body>
    <h1>Hola {{ $user->nombre }} {{ $user->apellidos }}</h1>
    <p>
        Tienes una nueva clase programada : <br>
        Id Clase : {{ $infoClase->idClase }}  <br>
        Alumno : {{ $infoClase->nombre }} <br> <!-- falta apeellidos del alumno segun db -->
        Materia : {{ $infoClase->materiaNombre }} <br>
        Tema : 1.1 {{ $infoClase->temaNombre }} <br> <!-- falta numero de tema segun db -->
        Hora : {{ $infoClase->hora }} <br>
        Fecha : {{ $infoClase->fecha }} <br>
        <a href="{{ $infoClase->meets }}">Liga Meets</a> <br>
        <a href="https://techneektutor.com/sistema/clases/ficha/alumno/{{$infoClase->idClase}}">Ficha de la Clase</a> <br>
    </p>
</body>
</html>