@extends('main')
@section('title','| All Tags')
@section('content')
    <div class="row">
      <div class="col-md-8">
        <h1>Tags</h1>
        <table class="table">
          <thead>
            <tr>
              <th>Tag ID</th>
              <th>Tag Name</th>
              <th></th>
            </tr>
          </thead>
            <tbody>
              @foreach ($tags as $tag)
              <tr>
                <th>{{ $tag->id }}</th>
                <td>{{ $tag->name }}</td>
                <td><a href="{{ route('tags.show',$tag->id) }}" class="btn btn-default btn-xs">View</a> <a href="{{ route('tags.edit',$tag->id) }}" class="btn btn-default btn-xs">Edit</a></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="col-md-3">
        <div class="well">
          {!! Form::open(['route'=>'tags.store','method'=>'POST']) !!}
          <h2>Add New Category </h2>
          {{ Form::label('name','Tag Name') }}
          {{ Form::text('name',null,['class'=>'form-control']) }}
          {{ Form::submit('Create New Category',['class'=>'btn btn-primary btn-block spacing-top']) }}
          {{ Form::close() }}
        </div>
      </div>
    </div>
@stop
