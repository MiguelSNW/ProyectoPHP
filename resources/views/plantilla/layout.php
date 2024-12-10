<!-- 
LAYOUT DE LA APLICACIÓN 
ESTA PÁGINA DISPONE DONDE IRÁN LOS DIFERENTES BLOQUES QUE CONFORMAN LA APLICACIÓN

Se centra solamente en la presentación.
Deberemos indicarle:
    - titulo
    - menu
    - cuerpo

Podría tener tantos parámetros como quisiesemos
Igualmente nuestra aplicación podría tener tantos layouts como deseasemos
-->
<html>
    <head>
        <title>Frontal 2 - <?=$titulo?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>    
<body>
    <header>
        <div style="background: PURPLE; text-align: center; font-size: 2em">
            Albañilería S.L
        </div>
    </header>
    <div id="menu"><?=$menu?></div>
    <div id="cuerpo" style = "margin-right:300px"><?=$cuerpo?></div>
    <footer style="background: #ccffcc; clear: both;">
        Pie de página
    </footer>
</body>
</html>