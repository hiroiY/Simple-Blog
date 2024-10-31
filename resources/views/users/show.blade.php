@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="row mt-2 mb-5 h-25">
        <div class="col-4">
            <!-- Display the image of the user -->
            <!-- check if the user has an avatar, If yes display it, if no display an icon. -->
           @if($user->avatar)
            <img src="{{ asset('storage/avatars/'. $user->avatar) }}" alt="{{ $user->name }}'s avatar" class="pb-0 img-thumbnail w-100 h-50 object-fit-cover border-0">
           @else
            <i class="pb-0 fa-solid fa-image fa-10x d-block text-center"></i>
           @endif 
        </div>
        <div class="col-8 ps-2">
            <h2 class="display-6">{{ $user->name }}</h2>
            <a href="{{ route('profile.edit') }}" class="text-decoration-none">
                Edit Profile
            </a>
        </div>
    </div>

    <!-- If the user has a posts, show all the posts of this user using the relationship method -->
    <!-- User::Post : user has many posts -->
    @if($user->posts)
    <div class="pt-3">
        <h3 class="text-center mt-5 mb-3">- My Articles -</h3>
        <ul class="list-group mb-5">
            @foreach($user->posts as $post)
                <li class="list-group-item py-4">
                    <a href="{{ route('post.show', $post->id) }}">
                        <h4>{{ $post->title }}</h4>
                    </a>
                    <p class="fw-light mb-0">
                        {{ $post->body }}
                    </p>
                </li>
            @endforeach
        </ul>
    </div>
    @endif
    
@endsection