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



    //longeur demande

    $('#interventions_demande_lg_filter,#annee_demande_lg_filter').on('change', function (e) {
        var intervention =   $("#interventions_demande_lg_filter").val();
        var annee = $("#annee_demande_lg_filter").val();


        $.ajax({
            url: '/chartDataDemandesLongeur',
            type: 'GET',
            data: {
                _token: '{{ csrf_token() }}',
                intervention: intervention,
                annee : annee
            },
            dataType: 'JSON',
            success: function (data) {
                console.log();

                var ctx_longeur_demande = document.getElementById('demande_longueur_chart');
                var myChart_longeur_demande = new Chart(ctx_longeur_demande, {
                    type: 'doughnut',
                    data: {
                        labels: ['Taux', 'Total'],
                        datasets: [{
                            label: '# of Votes',
                            data: [data.longeur_demande_intervention, data.longueur_total],
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
                var ctx_demande_longeur = $("#demande_chart").get(0).getContext("2d");
                ctx_demande_longeur.width = 100;
                ctx_demande_longeur.height = 100;
            }
        });

    });

});
