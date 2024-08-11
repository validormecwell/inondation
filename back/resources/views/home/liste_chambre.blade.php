<!DOCTYPE html>
<html lang="en">
    <head>

        @include('home.css')
    </head>
    <body>
        <div class="main-wrapper">
            <div class="header">
                @include('home.header')
            </div>
            <div class="sidebar" id="sidebar">
                @include('home.sidebar')
            </div>
            <div class="page-wrapper">
                <div class="content container-fluid">
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="mt-5">
                                    <h4 class="card-title float-left mt-2">Liste des Chambres</h4>
                                    <a href="{{url('create_chambre')}}" class="btn btn-primary float-right veiwbutton">Ajout Chambre</a> </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card card-table">
                                <div class="card-body booking_card">
                                    <div class="table-responsive">
                                        <table class="datatable table table-stripped table table-hover table-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th>numero</th>
                                                    <th>type</th>
                                                    <th>prix</th>

                                                    <th class="text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $data)
                                                <tr>
                                                    <td>{{$data->id}}</td>
                                                    <td>{{$data->type}}</td>
                                                    <td>{{$data->prix}} Ariary</td>
                                                    <td class="text-right">
                                                        <div class="dropdown dropdown-action"> <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v ellipse_color"></i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="{{ url('edit_chambre', $data->id) }}">
                                                                    <i class="fas fa-pencil-alt m-r-5"></i> Edit</a>
                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_asset" data-id="{{ $data->id }}">
                                                                        <i class="fas fa-trash-alt m-r-5"></i> Delete
                                                                    </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                @endforeach



                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="delete_asset" class="modal fade delete-modal" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body text-center">
                                <img src="assets/img/sent.png" alt="" width="50" height="46">
                                <h3 class="delete_class">vous etes sure?</h3>
                                <div class="m-t-20">
                                    <form method="POST" action="{{ route('delete_chambre', $data->id) }}" id="deleteForm">
                                        @csrf
                                        @method('DELETE')
                                        <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    @include('home.js')

</body>
</html>
