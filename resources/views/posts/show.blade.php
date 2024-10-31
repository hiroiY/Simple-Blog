@extends('layouts.app')

@section('title', 'Show Post')

@section('content')
    <div class="mt-2 border border-2 rounded py-3 px-4 shadow-sm">
        <h4>{{ $post->title }}</h4> 
        <!-- Display the Post Title -->

        <h6 class="text-muted">{{ $post->user->name }}</h6>
        <!-- Display the owner of the Post -->

        <p class="mt-3">{{ $post->body }}</p>
        <!-- Display the content body of the post -->

        <img src="{{ asset('storage/image/'.$post->image) }}" alt="{{ $post->image }}" class="w-100 shadow h-50 object-fit-cover border-0 mt-2">
        <!-- Display the image of the post -->
        <!-- asset() -> access the public folder -->
        <h6 class="text-muted text-end me-0 mt-4">
            {{ $post->updated_at }}
        </h6>
    </div>

    <form action="{{ route('comment.store', $post->id) }}" method="post">
        @csrf

        <div class="input-group mt-5">
            <input type="text" name="comment" id="comment" placeholder="Add a comment..." class="form-control" value="{{ old('comment') }}">
            <button type="submit" class="btn btn-outline-secondary btn-sm">
                Post
            </button>
        </div>
        @error('comment')
            <p class="text-danger small">{{ $message }}</p>
        @enderror
    </form>

    <!-- If the post has a comments. show all the comments -->
    @if($post->comments)
        <div class="mt-2 mb-5">
            @foreach($post->comments as $comment)
                <div class="row p-2">
                    <div class="col-10">
                        <span class="fw-bold">{{ $comment->user->name }}</span>
                        &nbsp; <!-- &nbsp; code for space -->
                        <span class="small text-muted">{{ $comment->created_at }}</span>
                        <p class="mb-0">{{ $comment->body }}</p>
                    </div>
                    <div class="col-2 text-end">
                        <!-- Show a delete button if the Auth user is the owner of the comment -->

                        <!-- check if the auth user is the owner of the comment -->
                        @if($comment->user_id === Auth::user()->id)
                            <form action="{{ route('comment.destroy', $comment->id) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Comment">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection