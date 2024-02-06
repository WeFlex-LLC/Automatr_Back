@extends('layouts.simple.master')

@section('title', 'Blog Manage')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/chartist.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/date-picker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>{{ isset($blogs) ? 'Edit a Blog' : 'Create a new Blog' }}</h3>
@endsection



@section('content')
<form method="POST" action="{{ isset($blogs) ? $blogs->id : 'add'}}" enctype="multipart/form-data" class="form theme-form">
@csrf <!-- {{ csrf_field() }} -->

@isset($blogs)  
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
									<label for="shortDescription">Description</label>
									<input class="form-control" id="shortDescription" name="shortDescription" type="text" value="{{ isset($blogs) ? $blogs->shortDescription : ''}}" placeholder="Description">
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="url">URL</label>
									<input class="form-control" id="url" name="url" type="text" value="{{ isset($blogs) ? $blogs->url : ''}}" placeholder="URL">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="read_duration">Read Duration</label>
									<input class="form-control" id="read_duration" name="read_duration" type="text" value="{{ isset($blogs) ? $blogs->read_duration : ''}}" placeholder="Read Duration">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="publishDate">Publish Date</label>
									<input class="form-control" id="publishDate" name="publishDate" type="datetime-local" value="{{ isset($blogs) ? date('Y-m-d\TH:i', strtotime($blogs->updated_at)) : ''}}" placeholder="Publish Date">
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="tags">Tag</label>
									<select class="js-example-basic-multiple col-sm-12" multiple="multiple" id="tags" name="tags[]" selected="1,2">
                                    @foreach ($tags as $tag)
										<option @if(isset($blogs) && in_array($tag->id, $blogs->tags)) selected @endif value="{{$tag->id}}">{{$tag->name}}</option>
                                    @endforeach
									</select>
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col">
								<div class="mb-3 mb-0">
									<label for="tutorial">Content</label>
									<textarea class="form-control ckeditor" id="content" rows="3" name="content">{{ isset($blogs) ? $blogs->content : ''}}</textarea>
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col">
								<div class="mb-3 mb-0">
									<label for="tutorial">Short Content</label>
									<textarea class="form-control" id="shortContent" rows="3" name="shortContent">{{ isset($blogs) ? $blogs->shortContent : ''}}</textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="metaTitle">Meta Title</label>
									<input class="form-control" id="metaTitle" name="metaTitle" type="text" placeholder="Meta Title" value="{{ isset($blogs) ? $blogs->metaTitle : ''}}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="metaTitle">Meta Description</label>
									<input class="form-control" id="metaDescription" name="metaDescription" type="text" placeholder="Meta Description" value="{{ isset($blogs) ? $blogs->metaDescription : ''}}">
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="thumbnail">Thumbnail</label>
									<input type="file" name="thumbnail" class="form-control">
								</div>
							</div>
						</div>
                        @isset($blogs)
                        <div class="row">
							<div class="col">
								<div class="mb-3">
                                        <img src="{{$blogs->thumbnail}}" />
								</div>
							</div>
						</div>
                        @endisset
                        <div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="coverPhoto">Cover Photo</label>
									<input type="file" name="coverPhoto" class="form-control">
								</div>
							</div>
						</div>
                        @isset($blogs)
                        <div class="row">
							<div class="col">
								<div class="mb-3">
                                        <img src="{{$blogs->coverPhoto}}" />
								</div>
							</div>
						</div>
                        @endisset
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
<script src="{{asset('assets/js/select2/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/select2/select2-custom.js')}}"></script>
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.ckeditor').ckeditor();
    });
    CKEDITOR.replace('content', {
        filebrowserUploadUrl: "{{route('ckeditor.image-upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
</script>
@endsection


