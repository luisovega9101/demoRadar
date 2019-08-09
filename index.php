<?php
include_once 'controlador/Controlador.php';
include_once 'conexion/Conexion.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Demo</title>
    </head>
    <body>
        <?php      
        $resultados = Controlador::lista_resultado();
        $label = array();
        $data = array();    
        while ($row = mysqli_fetch_row($resultados)) {
            $label[]=$row[1];
            $data[]=$row[2];
        }
        ?>        
        <div>
            <form method="POST" action="vista/graficar.php">
                <div>
                    <input type="hidden" name="label" value='<?php echo serialize($label);?>'/>
                    <input type="hidden" name="data" value='<?php echo serialize($data);?>;'/>
                    <input style="width: auto" type="submit" class="boton" name="btn_graficar" value="Graficar"/>
                </div>
            </form>
        </div>       
    </body>
</html>
