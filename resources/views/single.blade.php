@extends("layouts.layout")

@section("content")
    <h1> {{ $post->title }} </h1>

    <ul>
        @foreach($comments as $comment)
            <li>
                {{ $comment->text }}
            </li>
        @endforeach
    </ul>

    @auth()
        <form action="{{route("single.comment", $post->id)}}" method="post">
            <textarea name="text" id="" cols="30" rows="10"></textarea>
        </form>
    @endauth
@endsection
