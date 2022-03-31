@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>List of friends</h1>
        <div class="row justify-content-center">
            @foreach($friends as $friend)
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{route('profiles.show', ['id' => $friend->id])}}"
                               target="_blank">User {{$friend->name}} {{$friend->surname}}</a>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    </div>
@endsection
