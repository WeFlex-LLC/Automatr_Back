@extends('layouts.simple.master')

@section('title', 'Help Center Manage')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/chartist.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/date-picker.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>{{ isset($ffqs) ? 'Edit a Question' : 'Create a new Question' }}</h3>
@endsection



@section('content')
<form method="POST" action="{{ isset($ffqs) ? $ffqs->id : 'add'}}" enctype="multipart/form-data" class="form theme-form">
@csrf <!-- {{ csrf_field() }} -->

@isset($ffqs)  
    @method('PUT') 
@endisset
    <div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="question">Question</label>
									<input class="form-control" id="question" name="question" type="text" value="{{ isset($ffqs) ? $ffqs->question : ''}}" placeholder="Question">
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col">
								<div class="mb-3 mb-0">
									<label for="tutorial">Answer</label>
									<textarea class="form-control ckeditor" id="answer" rows="3" name="answer">{{ isset($ffqs) ? $ffqs->answer : ''}}</textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<button class="btn btn-primary" type="submit">Submit</button>
						<input class="btn btn-light" type="reset" value="Cancel">
					</div>
				
			</div>
		</div>
	</div>
    </div>

    </form>
@endsection


@section('script')
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.ckeditor').ckeditor();
    });
    CKEDITOR.replace('answer', {
        filebrowserUploadUrl: "{{route('ckeditor.image-upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
</script>
@endsection


