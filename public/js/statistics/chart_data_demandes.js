$(document).ready(function(){
    $('#interventions_demande_filter,#annee_demande_filter').on('change', function (e) {

      var intervention =   $("#interventions_demande_filter").val();
      var annee = $("#annee_demande_filter").val();


        $.ajax({
            url: '/chartDataDemandes',
            type: 'GET',
            data: {
                _token: '{{ csrf_token() }}',
                intervention: intervention,
                annee : annee
            },
            dataType: 'JSON',
            success: function (data) {
                console.log();

                var ctx = document.getElementById('demande_chart');
                var myChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Taux', 'Total'],
                        datasets: [{
                            label: '# of Votes',
                            data: [data.number_demande_interv[0].number__demande_interv, data.nombre_total_demande],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)'
                            ],
                            borderWidth: 1
                        }]
                    }
                });
                var ctx = $("#demande_chart").get(0).getContext("2d");
                ctx.width = 100;
                ctx.height = 100;
            }
        });

    });



});
