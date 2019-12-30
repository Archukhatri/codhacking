@extends('layouts.blog-post')

@section('content')
{{-- <h1>Post</h1> --}}
<!-- Blog Post -->

<!-- Title -->
<h1>{{$post->title}}</h1>

<!-- Author -->
<p class="lead">
	by <a href="#">{{$post->user->name}}</a>
</p>

<hr>

<!-- Date/Time -->
<p><span class="glyphicon glyphicon-time"></span> Posted on {{$post->created_at->diffForHumans()}}</p>

<hr>

<!-- Preview Image -->
<img class="img-responsive" src="{{$post->photo->file}}" alt="">

<hr>

<!-- Post Content -->
<p>{{$post->body}}</p>
               {{--  <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus, vero, obcaecati, aut, error quam sapiente nemo saepe quibusdam sit excepturi nam quia corporis eligendi eos magni recusandae laborum minus inventore?</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut, tenetur natus doloremque laborum quos iste ipsum rerum obcaecati impedit odit illo dolorum ab tempora nihil dicta earum fugiat. Temporibus, voluptatibus.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, doloribus, dolorem iusto blanditiis unde eius illum consequuntur neque dicta incidunt ullam ea hic porro optio ratione repellat perspiciatis. Enim, iure!</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error, nostrum, aliquid, animi, ut quas placeat totam sunt tempora commodi nihil ullam alias modi dicta saepe minima ab quo voluptatem obcaecati?</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum, dolor quis. Sunt, ut, explicabo, aliquam tenetur ratione tempore quidem voluptates cupiditate voluptas illo saepe quaerat numquam recusandae? Qui, necessitatibus, est!</p> --}}

                <hr>
                @if(Session::has('comment_message'))
                {{session('comment_message')}}
                @endif

                <!-- Blog Comments -->

                @if(Auth::check())

                <!-- Comments Form -->
                <div class="well">
                	<h4>Leave a Comment:</h4>

                	{!! Form::open(['method'=>'POST', 'action'=> 'PostCommentController@store','files'=>true]) !!}

                	<input type="hidden" name="post_id" value="{{$post->id}}" >

                	<div class="form-group">
                		{!! Form::label('body', 'Body:') !!}
                		{!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=>3])!!}
                	</div>
                	<div class="form-group">
                		{!! Form::submit('Submit coment', ['class'=>'btn btn-primary']) !!}
                	</div>
                	{!! Form::close() !!}

                	<hr>
                </div>
                @endif
                <!-- Posted Comments -->

                @if(count($comments)>0)

                @foreach($comments as $comment)

                <!-- Comment -->
                <div class="media">
                	<a class="pull-left" href="#">
                		<img height="64" class="media-object" src="{{$comment->photo}}" alt="">
                	</a>
                	<div class="media-body">
                		<h4 class="media-heading">{{$comment->author}}
                			<small>{{$comment->created_at->diffForHumans()}}</small>
                		</h4>
                		<p>{{$comment->body}}</p>

                        <div class="comment-reply-container">

                                <button class="toogle-reply btn btn-primary pull-right">Reply</button>
                        </div>        




                		@if(count($comment->replies) > 0 )
                		@foreach($comment->replies as $reply)

                		@if($reply->is_active == 1)

                			<!-- Nested Comment -->
                			<div id="nested-comment" class="media">
                				<a class="pull-left" href="#">
                					<img height="64"class="media-object" src="{{$reply->photo}}" alt="">
                				</a>
                				<div class="media-body">

                					<h4 class="media-heading">{{$reply->author}}
                						<small>{{$reply->created_at->diffForHumans()}}</small>
                					</h4>
                					<p>{{$reply->body}}</p>
                				</div>

                                 <div class="comment-reply-container">

                                <button class="toogle-reply btn btn-primary pull-right">Reply</button>
                        
                			
	                			<div class="comment-reply col-sm-6">

			                				{!! Form::open(['method'=>'POST', 'action'=> 'CommentRepliesController@createReply']) !!}

			                				<div class="form-group">

			                				    <input type="hidden" name="comment_id" value="{{$comment->id}}" >

			                					{!! Form::label('body', 'Body: ') !!}
			                					{!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=> 1])!!}
			                				</div>

			                				<div class="form-group">
			                					{!! Form::submit('Return reply', ['class'=>'btn btn-primary'])!!}
			                				</div>

			                				{!! Form::close() !!}
                			    </div>
                			</div>
                			<!-- End Nested Comment -->
                		</div>
                    </div>s
                        @endif
                		@endforeach
                		@endif


                	</div>
                </div>
                @endforeach
                @endif


@stop

@section('scripts')
 <script>
 	$(".comment-reply-container .toogle-reply").click(function(){
 		$(this).next().slideToggle("slow");
 	});
 </script>
@stop




