@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Profiles</h1>
        <div class="row justify-content-center">
            @foreach($users as $user)
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{route('profiles.show', ['id' => $user->id])}}"
                               target="_blank">User {{$user->name}} {{$user->surname}}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
