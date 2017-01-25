  @extends('main')
  @section('title','| Edit Blog Post')
    @section('stylesheets')

      {!! Html::style('css/select2.min.css') !!}
    	<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    	<script>tinymce.init({ selector:'textarea' });</script>


    @endsection

  @section('content')
    <div class="row">
      {!! Form::model($post, ['route' => ['posts.update',$post->id],'method' => 'PUT','files' => true]) !!}
      <div class="col-md-8">
        {{ Form::label('title','Title:') }}
        {{ Form::text('title',null,["class" => "form-control input-lg"])}}

        {{ Form::label('slug','Slug',['class' => 'form-spacing-top']) }}
        {{ Form::text('slug',null,["class" => "form-control"]) }}

        {{ Form::label('category_id','Category',['class'=>'form-spacing-top']) }}
        {{ Form::select('category_id',$categories,null,['class'=>'form-control']) }}

        {{ Form::label('tags','Tag',['class'=>'form-spacing-top']) }}
        {{ Form::select('tags[]',$tags,null,['class'=>'select2-multi form-control','multiple' => 'multiple']) }}

        {{ Form::label('featured_image','Update Image',['class' => 'form-spacing-top']) }}
        {{ Form::file('featured_image') }}

        {{ Form::label('body', "Body:",['class' => 'form-spacing-top']) }}
        {{ Form::textarea('body',null,["class" => "form-control input-lg"]) }}
      </div>
      <div class="col-md-4">
        <div class="well">
          <dl class="dl-horizontal">
            <dt>Created At : </dd>
            <dd>{{ date('j M, Y h:ia' , strtotime($post->created_at)) }}</dt>
          </dl>
          <dl class="dl-horizontal">
            <dt>Last Updated : </dd>
            <dd>{{date('j M, Y h:ia', strtotime($post->updated_at)) }}</dt>
          </dl>
          <hr>
          <div class="row">
            <div class="col-sm-6">
              {!! Html::linkRoute('posts.show', 'Cancel', $post->id, array('class'=> 'btn btn-danger btn-block'))!!}
            </div>
            <div class="col-sm-6">
              {!! Form::submit('Save Changes', ['class' => 'btn btn-success btn-block']) !!}
            </div>
          </div>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  @endsection


  @section('scripts')

  	{{-- {!! Html::script('js/parsley.min.js') !!} --}}
  	{!! Html::script('js/select2.min.js') !!}

  	<script type="text/javascript">
  		$('.select2-multi').select2();
    	$('.select2-multi').select2().val({!! json_encode($post->tags()->getRelatedIds()) !!}).trigger('change');
  	</script>

  @endsection
