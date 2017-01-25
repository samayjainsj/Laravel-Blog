@extends('main')
@section('title','| Blog')
@section('content')
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <h1>Blog</h1>
    </div>
  </div>

  @foreach ($posts as $post)

  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <h2>{{ $post->title }}</h2>
      <h5>Published:  {{ date('j M, Y' , strtotime($post->created_at)) }}</h5>
      <p>{{ substr(strip_tags($post->body),0,250) }}{{ strlen(strip_tags($post->body)) > 50 ? '....' : '' }}</p>
      <a href="{{ url('blog/'.$post->slug) }}" class="btn btn-primary">Read More</a>
			<hr>
    </div>
  </div>
  @endforeach
  <div class="row">
    <div class="col-md-12 text-center">
      <a href="{{ $posts->links() }}"></a>
    </div>
  </div>
@stop
