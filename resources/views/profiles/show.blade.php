@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Profile {{$userData->name}} {{$userData->surname}}</div>

                    <div class="card-body">
                        <div class="card-text">Name: {{$userData->name}}</div>
                        <div class="card-text">Surname: {{$userData->surname}}</div>
                        <div class="card-text">Age: {{$userData->age}}</div>
                        <div class="card-text">Interests: {{$userData->interests}}</div>
                        <div class="card-text">City: {{$userData->city}}</div>
                    </div>

                    @if(\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier() != $userData->id)
                        <div class="card-footer">
                            @switch($friendStatus)
                                @case(\App\Helpers\FriendHelper::STATUS_NOT_FRIENDS)
                                    <p>The user is not your friend, you can send a friend request</p>
                                    <a href="{{route('friends.add', ['id' => $userData->id])}}">Send a friendship request</a>
                                    @break
                                @case(\App\Helpers\FriendHelper::STATUS_IN_SUBSCRIBERS)
                                    <p>The user is in your subscribers, you can accept the request or leave the user in subscribers</p>
                                    <a href="{{route('friends.add', ['id' => $userData->id])}}">Accept a friendship request</a>
                                    @break
                                @case(\App\Helpers\FriendHelper::STATUS_REQUEST_SENT)
                                    <p>You have sent a friend request, you can cancel it</p>
                                    <a href="{{route('friends.remove', ['id' => $userData->id])}}">Cancel the friendship request</a>
                                    @break
                                @default
                                    <p>This user is in your friends list, you can remove him from friends, then he will become your subscriber</p>
                                    <a href="{{route('friends.remove', ['id' => $userData->id])}}">Remove from friends</a>
                            @endswitch

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
