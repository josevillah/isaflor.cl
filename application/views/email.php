<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
</head>

<style>
    body{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .container{
        width: 50%;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        display: flex;
        flex-direction: column;
    }

    .container h1{
        text-align: center;
        font-size: 40px;
    }

    .container p{
        margin: 10px 0;
        font-weight: bold;
        font-size: 20px;
    }

    .container p span{
        font-weight: normal;
        font-size: 18px;
    }

    p.mensaje{
        font-size: 18px;
        font-weight: normal;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
</style>

<body>
    <div class="container">
        <h1>Contacto.</h1>
        <p>Nombre: <span>José Villa</span></p>
        <p>Correo: <span>web@isaflor.cl</span></p>
        <p>Mensaje:</p>
        <p class="mensaje">
            Esto es un mensaje de prueba
        </p>
    </div>
</body>
</html>