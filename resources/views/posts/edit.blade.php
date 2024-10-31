@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
    <form action="{{ route('post.update', $post->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="title" class="form-label text-secondary">Title</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Enter title here" value="{{ old('title', $post->title) }}" autofocus>

            {{-- Error --}}
            @error('title')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="body" class="form-label text-secondary">Body</label>
            <textarea name="body" id="body" rows="5" class="form-control" placeholder="Start writing...">{{ old('body', $post->body) }}</textarea>

            {{-- Error --}}
            @error('body')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <div class="col-6">
                <label for="image" class="form-label text-secondary">Image</label>

                <!-- <img src="#" alt="#" class="w-100 img-thumbnail"> -->
                <img src="{{ asset('/storage/images/' .$post->image) }}" alt="{{ $post->image }}" class="w-100 img-thumbnail">

                <input type="file" name="image" id="image" class="form-control mt-1" aria-describedby="image-info">

                <div class="form-text" id="image-info">
                    <p class="mb-0">Acceptable formats are jpeg, jpg, png, gif only.</p>
                    <p class="mt-0">Maximum file size is 1048kb.</p>
                </div>

                {{-- Error --}}
                @error('image')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-warning px-5">Save</button>
    </form>
@endsection