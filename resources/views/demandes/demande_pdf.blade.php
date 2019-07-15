

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Demandes</title>

        <style>
            .page-break {
                page-break-after: always;
            }
        </style>
    </head>

    <body>
        <div>Test PDF demande</div>

        <h1 class="page-break">Liste des demandes</h1>
        @foreach($demandes as $demande)
            {{$demande->num_ordre}}
            <br>
        @endforeach
    </body>



</html>

