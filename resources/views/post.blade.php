<div class="card mt-3">
    @if($post->image)
        <img class="card-img-top" src="{{ sprintf('/storage/images/%s', $post->image) }}">
    @endif
    <div class="card-body">
        {{$post->user->name}} | {{$post->created_at}}
        <br>
        {{ $post->content }}
        @if($post->file)
            <br>
            <a href="{{ sprintf('/storage/files/%s', $post->file) }}">{{ $post->file_origin_name }}</a>
        @endif
        @if($allowDelete)
        <form action="{{ route('post.delete',$post) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger float-end">delete</button>
        </form>
        @endif
    </div>
</div>
