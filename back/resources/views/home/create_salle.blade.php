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
                            <h3 class="page-title mt-5">Ajout Salle</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Afficher les messages de session -->
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ url('add_salle') }}">
                            @csrf
                            <div class="row formtype">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Numero Salle</label>
                                        <input class="form-control" type="text" name="num_salle" value="{{ old('num_salle') }}">
                                        @error('num_salle')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Type Salle</label>
                                        <select class="form-control" name="type">
                                            <option>Select</option>
                                            <option value="Conference" {{ old('type') == 'Conference' ? 'selected' : '' }}>Conference</option>
                                            <option value="mariage" {{ old('type') == 'mariage' ? 'selected' : '' }}>mariage</option>
                                            <option value="Autre" {{ old('type') == 'Autre' ? 'selected' : '' }}>Autre</option>

                                        </select>
                                        @error('type')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Prix</label>
                                        <input type="text" class="form-control" name="prix" value="{{ old('prix') }}">
                                        @error('prix')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Capacite</label>
                                        <input type="text" class="form-control" name="capacite" value="{{ old('capacite') }}">
                                        @error('capacite')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <input class="btn btn-primary buttonedit ml-2" value="Ajouter" type="submit">
                            <button type="button" class="btn btn-primary buttonedit">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('home.js')
</body>
</html>
