
<h4>Gestion des utilisateurs:</h4>
<hr>
<h6 class="title-setting"> <i class="fa fa-square"></i> Listes des utilisateurs</h6>

<div class="table-responsive" style="margin: 12px;margin-bottom: 0 !important;">
    <table class="table table-hover table-striped datatables" id="users_datatables" >
        <thead>
            <th >Nom</th>
            <th >Prénom</th>
            <th >Identification</th>
            <th >Etablissement</th>
            <th></th>
        </thead>
    </table>
</div>



<h6 class="title-setting"> <i class="fa fa-square"></i> Ajouter un utilisateur</h6>
{!! Form::open(['action' => 'UsersController@store','method'=>'POST','class'=>'form-create']) !!}
<div class="row" style="padding: 12px;margin: 12px;border:1px solid rgba(216,216,216,0.45);">
    <div class="row col-12">
        <div class="col-lg-2 col-md-2">
            {{Form::label('','Nom :')}}
        </div>
        <div class="col-lg-3 col-md-3">
            {{Form::text('last_name','',['class'=>'form-control','required'=>'required'])}}
        </div>


        <div class="col-lg-2 col-md-2">
            {{Form::label('','Prénom :')}}
        </div>
        <div class="col-lg-3 col-md-3">
            {{Form::text('first_name','',['class'=>'form-control','required'=>'required'])}}
        </div>

    </div>


    <div class="row col-12" style="margin-top: 8px">
        <div class="col-lg-2 col-md-2">
            {{Form::label('','Identification :')}}
        </div>
        <div class="col-lg-3 col-md-3">
            {{Form::text('username','',['class'=>'form-control','required'=>'required'])}}
        </div>

        <div class="col-lg-2 col-md-2">
            {{Form::label('','Mot de passe provisoire :')}}
        </div>
        <div class="col-lg-3 col-md-3">
            <input type="password" name="password" class="form-control" >
        </div>
    </div>

    <div class="row col-12" style="margin-top: 8px">
        <div class="col-lg-2 col-md-2">
            {{Form::label('','Intervenant :')}}
        </div>

        <div class="col-lg-3 col-md-3">
            <div class="form-group">
                <select placeholder="Porteur de projet" class="form-control select2" style="width: 100%;" name="organisation_id">

                    @foreach($organisations as $organisation)
                        <option value="{{$organisation->id}}">{{$organisation->nom_fr}}</option>
                    @endforeach
                </select>
            </div>
        </div>


    </div>





    <div class="row col-12" style="margin-top: 18px;display: flex;align-items: center;justify-content: center;">
        <button type="submit"  class="btn btn-secondary" style="background-color: #219009;border-color: #219009;"><i class="fa fa-plus" style="margin-right: 6px"></i>Ajouter </button>
    </div>
</div>
{!! Form::close() !!}
<br>



