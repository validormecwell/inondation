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
                            <h3 class="page-title mt-5">Ajout Chambre</h3>
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

                        <form method="POST" action="{{ url('add_chambre') }}">
                            @csrf
                            <div class="row formtype">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Numero Chambre</label>
                                        <input class="form-control" type="text" name="id" value="{{ old('id') }}">
                                        @error('id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Type Chambre</label>
                                        <select class="form-control" name="type">
                                            <option>Select</option>
                                            <option value="Single" {{ old('type') == 'Single' ? 'selected' : '' }}>Single</option>
                                            <option value="Double" {{ old('type') == 'Double' ? 'selected' : '' }}>Double</option>
                                            <option value="Quad" {{ old('type') == 'Quad' ? 'selected' : '' }}>Quad</option>
                                            <option value="King" {{ old('type') == 'King' ? 'selected' : '' }}>King</option>
                                            <option value="Suite" {{ old('type') == 'Suite' ? 'selected' : '' }}>Suite</option>
                                            <option value="Villa" {{ old('type') == 'Villa' ? 'selected' : '' }}>Villa</option>
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
