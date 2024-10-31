@extends('layouts.app')

@section('title', 'Home')

@section('content')
    @forelse($all_posts as $post)
        <!-- Check if $all_posts is not empty -> display all the record -->
        <div class="mt-2 border border-2 rounded py-3 px-4">
            <a href="{{ route('post.show',$post->id) }}">
                <h4>{{ $post->title }}</h4>
            </a>
            <h6 class="text-muted">{{ $post->user->name }}</h6>
            <p class="fw-light mb-0">{{ $post->body }}</p>

            {{-- Action Button --}}
            @if(Auth::user()->id === $post->user_id)
                <div class="mt-2 text-end">
                    <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-pen"></i> Edit
                    </a>

                    <form action="{{ route('post.destroy', $post->id) }}" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fa-solid fa-trash-can"></i> Delete
                        </button>
                    </form>
                </div>
            @endif
            
        </div>  
    @empty
        <!-- If $all_posts is empty -> display a link to create a new post -->
        <div class="mt-5">
            <h2 class="text-muted text-center">
                No posts yet.
            </h2>
            <p class="text-center">
                <a href="{{ route('post.create') }}" class="text-decoration-none">
                    Create a new post
                </a>
            </p>
        </div>
    @endforelse
@endsection