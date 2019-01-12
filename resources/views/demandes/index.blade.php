@extends('layouts.app') 

@section('content')

<ul>
     @foreach($demandes as $demande)
     <li>numero :{{$demande->num_ordre}}, date reception: {{$demande->date_reception}}, objet : {{$demande->objet_fr}},Communes :{{$demande->commune}} </li>   
     @endforeach
</ul>

    
       <a href="demandes/create">
            ajouter demande
           </a> 
@endsection