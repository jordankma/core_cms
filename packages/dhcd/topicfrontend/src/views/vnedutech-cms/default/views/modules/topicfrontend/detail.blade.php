@extends('layouts.frontend')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-topicfrontend::language.titles.detail') }}@stop

{{-- page styles --}}
@section('header_styles')
@stop
<!--end of page css-->
<style type="text/css">
	.the-box{
        padding: 15px;
        margin-bottom: 30px;
        border: 1px solid #D5DAE0;
        position: relative;
        background: white;

    }
    .chat
	{
	    list-style: none;
	    margin: 0;
	    padding: 0;
	}

	.chat li
	{
	    margin-bottom: 10px;
	    padding-bottom: 5px;
	    border-bottom: 1px dotted #B3A9A9;
	}

	.chat li.left .chat-body
	{
	    margin-left: 60px;
	}

	.chat li.right .chat-body
	{
	    margin-right: 60px;
	}


	.chat li .chat-body p
	{
	    margin: 0;
	    color: #777777;
	}

	.panel .slidedown .glyphicon, .chat .glyphicon
	{
	    margin-right: 5px;
	}

	.panel-body
	{
	    overflow-y: scroll;
	    height: 450px;
	}

	::-webkit-scrollbar-track
	{
	    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	    background-color: #F5F5F5;
	}

	::-webkit-scrollbar
	{
	    width: 12px;
	    background-color: #F5F5F5;
	}

	::-webkit-scrollbar-thumb
	{
	    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
	    background-color: #555;
	}
</style>

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>Giao diện thảo luận</h1>
    </section>
    <!--section ends-->
    <section class="content paddingleft_right15">
        <!--main content-->
        <div class="row">
            <div class="the-box no-border" id="list-topic">
	            <div class="panel panel-primary">
	                <div class="panel-heading">
	                    <span class="glyphicon glyphicon-comment"></span> Chat
	                </div>
	                <div class="panel-body">
	                    <ul class="chat">
	                        {{-- <li class="left clearfix">
	                            <span class="chat-img pull-left">
	              					<img src="http://placehold.it/50/55C1E7/fff&text=JS" alt="User Avatar" class="img-circle" />
	            				</span>
	                            <div class="chat-body clearfix">
	                                <div class="header">
	                                    <strong class="primary-font">Jack Sparrow</strong>
	                                </div>
	                                <p>
	                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales.
	                                </p>
	                            </div>
	                        </li> --}}
	                    </ul>
	                </div>
	                <div class="panel-footer">
	                    <div class="input-group">
	                        <input id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here..." />
	                        <span class="input-group-btn">
	                            <button class="btn btn-warning btn-sm" id="btn-chat">
	                                Gửi</button>
	                        </span>
	                    </div>
	                </div>
	            </div>
        	</div>
        </div>
        <!--main content ends-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
	<script type="text/javascript">
		var name = '{{$name}}';
		$(document).ready(function() {
			$('body').on('click', '#btn-chat', function(event) {
				event.preventDefault();
				var input = $('#btn-input').val();
				var str = '<li class="left clearfix">'
	                    +        '<span class="chat-img pull-left">'
	              		+			'<img src="http://placehold.it/50/55C1E7/fff&text=JS" alt="User Avatar" class="img-circle" />'
	            		+		'</span>'
	                    +       '<div class="chat-body clearfix">'
	                    +            '<div class="header">'
	                    +                '<strong class="primary-font">'
	                    + name
	                    +'</strong>'
	                   	+            '</div>'
	                    +            '<p>'
	                    +               input
	                    +            '</p>'
	                    +        '</div>'
	                    +    '</li>';
	            $('.chat').append(str);
	            $('#btn-input').val('');
			});
		});
	</script>	
@stop
