<div class="card mt-3">
    @if($post->image)
        <img class="card-img-top" src="{{ sprintf('/storage/images/%s', $post->image) }}">
    @endif
    <div class="card-body">
        @if(Auth::user()->image)
            <img class="img-thumbnail" style="max-height: 50px" src="{{ sprintf('/storage/images/%s', Auth::user()->image) }}">
        @endif | {{$post->user->name}} | {{$post->created_at}}
        <br>
        {{ $post->content }}
        @if($post->file)
            <br>
            <a href="{{ sprintf('/storage/files/%s', $post->file) }}">{{ $post->file_origin_name }}</a>
        @endif
        @if($allowDelete)
        <form action="{{ route('post.delete',$post) }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col">
                    <button type="submit" class="btn btn-danger float-end">delete</button>
                </div>
            </div>
        </form>
        @endif
        <hr>
        <div class="row">
            @foreach($post->comments as $comment)
                <div class="col-12">
                    {{ $comment->user->name }}: {{ $comment->content }}
                    @if((int)Auth::user()->id === (int)$comment->user_id)
                    <form action="{{ route('comment.delete', $comment) }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <button type="submit" class="btn btn-danger float-end">delete</button>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            @endforeach
        </div>
        <hr>
        <form action="{{ route('comment.create', $post) }}" method="POST">
            @csrf
            <div class="row mb-3">
                <label for="content" class="col-md-4 col-form-label text-md-end">{{ __('Comment') }}</label>

                <div class="col-md-6">
                    <textarea id="content" class="form-control @error('content') is-invalid @enderror" name="content">{{ old('content') }}</textarea>

                    @error('content')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <button type="submit" class="btn btn-success float-end">Comment</button>
                </div>
            </div>
        </form>
    </div>
</div>
