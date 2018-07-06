<div class="col s6 m4 l3">

  <h3>Estadisticas</h3>

  <canvas id="myChart" ></canvas>

  <script type="text/javascript">
    var ctx = document.getElementById("myChart");
    var ctx = document.getElementById("myChart").getContext("2d");
    var ctx = $("#myChart");
    var ctx = "myChart";

    var myChart = new Chart(ctx, {
        type: 'line',
        label: 'Ordenes de trabajo',
        data:{
          labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
          datasets: [
            {
            label: 'My First dataset',
            borderColor: 'red',
            backgroundColor: 'red',
            fill: false,
            data: [
              2,
              2,
              2,
              2,
              2,
              2,
              2
            ],
            yAxisID: 'y-axis-1',
          },
          {
            label: 'My Second dataset',
            borderColor: 'blue',
            backgroundColor: 'blue',
            fill: false,
            data: [
              1,
              5,
              6,
              7,
              2,
              3,
              1
            ],
            yAxisID: 'y-axis-2'
          }]
        },
        options: {
          responsive: true,
          hoverMode: 'index',
          stacked: false,
          title: {
            display: true,
            text: 'Chart.js Line Chart - Multi Axis'
          },
          scales: {
            yAxes: [{
              type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
              display: true,
              position: 'left',
              id: 'y-axis-1',
            }, {
              type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
              display: true,
              position: 'right',
              id: 'y-axis-2',

              // grid line settings
              gridLines: {
                drawOnChartArea: false, // only want the grid lines for one axis to show up
              },
            }],
          }
        }
    });
  </script>

</div>
