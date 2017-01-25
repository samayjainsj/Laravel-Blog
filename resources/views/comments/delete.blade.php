@extends('main')
@section('title','| Delete Comment')
@section('content')
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <h1>Delete this Comment</h1>
      <p>
        <p><strong>Name:</strong>{{ $comment->name }}</p>
        <p><strong>Email:</strong>{{ $comment->email }}</p>
        <p><strong>Comment</strong>{{ $comment->comment }}</p>
      </p>
      {{ Form::open(['route' => ['comments.destroy',$comment->id],'method' => 'DELETE']) }}

      {{ Form::submit('Delete',['class' => 'btn btn-lg btn-block btn-danger']) }}
      {{-- <a href="{{ route('posts.show',$post->comment->id) }}"></a> --}}
      {{ Form::close() }}
    </div>
  </div>
@stop
