<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Hecho</title>
</head>
<body>
    <h1>Hola {{ $user->nombre }} {{ $user->apellidos }}</h1>
    <p>
        El pago de la clase {{ $infoClase->idClase }} : <br>
        Id Clase : {{ $infoClase->idClase }}  <br>
        Alumno : {{ $infoClase->nombre }} <br> <!-- falta apeellidos del alumno segun db -->
        Materia : {{ $infoClase->materiaNombre }} <br>
        Tema : 1.1 {{ $infoClase->temaNombre }} <br> <!-- falta numero de tema segun db -->
        Hora : {{ $infoClase->hora }} <br>
        Fecha : {{ $infoClase->fecha }} <br>
        Pago : {{ $infoClase->pagoProfesor }}
    </p>
</body>
</html>