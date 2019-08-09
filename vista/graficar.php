<?php
if (isset($_POST["btn_graficar"])) {
    $label = unserialize($_POST["label"]);
    $data =unserialize($_POST["data"]);
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Demo/Grafica</title>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>
        <script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
    </head>
    <body>
        <div id="grafico_canva">
            <canvas id="myChart" width="300" height="100"></canvas>
        </div>       
        <div>
            <form method="POST" action="exportar_excel.php">
                <div>
                    <input type="hidden" name="label" value='<?php echo serialize($label);?>'/>
                    <input type="hidden" name="data" value='<?php echo serialize($data);?>;'/>
                    <input style="width: auto" type="submit" class="boton" name="btn_exportar_XLS" value="Exportar XLS"/>
                </div>
            </form>
            <button onclick="demoFromHTML()">Exportar PDF</button>
        </div>
        
        <script>            
            var label=<?php echo json_encode($label);?>;
            var data=<?php echo json_encode($data);?>;
            var num = data.map(data => Number(data));

            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: label,
                    datasets: [{
                        label: 'Valor de la descripción',
                        data: num,
                        backgroundColor: "rgba(200,0,0,0.2)"
                    }]
                },
                options: {
                    scale: {
                        ticks: {
                            beginAtZero: true,
                            min: 0,
                            max: 6
                         }
                    }
                }
            });      

    function demoFromHTML() {
        var canvas = document.getElementById('myChart');
        var imgData = canvas.toDataURL("image/jpeg", 1.0);
        var pdf = new jsPDF('', 'pt', 'a4');
        pdf.addImage(imgData, 'JPEG', 0, 0, 595.28, 592.28/canvas.width * canvas.height );
        //pdf.addImage(imgData, 'JPEG', 20, 20);
        pdf.save("download.pdf");
     }
    
 </script>
    </body>
</html>
