@extends('layouts.simple.master')

@section('title', 'Default')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/chartist.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/date-picker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>{{ isset($categories) ? 'Edit a Category' : 'Create a new Category' }}</h3>
@endsection



@section('content')
<form method="POST" action="{{ isset($categories) ? $categories->id : 'add'}}" enctype="multipart/form-data" class="form theme-form">
@csrf <!-- {{ csrf_field() }} -->

@isset($categories)  
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
									<label for="name">Name</label>
									<input class="form-control" id="name" name="name" type="text" value="{{ isset($categories) ? $categories->name : ''}}" placeholder="Name">
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="name">URL</label>
									<input class="form-control" id="url" name="url" type="text" value="{{ isset($categories) ? $categories->url : ''}}" placeholder="URL">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="metaTitle">Meta Title</label>
									<input class="form-control" id="metaTitle" name="metaTitle" type="text" placeholder="Meta Title" value="{{ isset($categories) ? $categories->metaTitle : ''}}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="metaTitle">Meta Description</label>
									<input class="form-control" id="metaDescription" name="metaDescription" type="text" placeholder="Meta Description" value="{{ isset($categories) ? $categories->metaDescription : ''}}">
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="icon">Icon</label>
									<input type="file" name="icon" class="form-control">
								</div>
							</div>
						</div>
						@isset($categories)
                        <div class="row">
							<div class="col">
								<div class="mb-3">
                                        <img src="{{$categories->icon}}" />
								</div>
							</div>
						</div>
                        @endisset
						<div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="icon2">Icon 2</label>
									<input type="file" name="icon2" class="form-control">
								</div>
							</div>
						</div>
						@isset($categories)
                        <div class="row">
							<div class="col">
								<div class="mb-3">
                                        <img src="{{$categories->icon2}}" />
								</div>
							</div>
						</div>
                        @endisset
						<div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="icon3">Icon 3</label>
									<input type="file" name="icon3" class="form-control">
								</div>
							</div>
						</div>
                        @isset($categories)
                        <div class="row">
							<div class="col">
								<div class="mb-3">
                                        <img src="{{$categories->icon3}}" />
								</div>
							</div>
						</div>
                        @endisset
						<div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="related">Related Automations</label>
									<select class="js-example-basic-multiple-limit3 col-sm-12" multiple="multiple" id="related" name="related[]" selected="1,2">
                                    @foreach ($related as $relat)
										<option @if(isset($categories->related) && in_array($relat->id, $categories->related)) selected @endif value="{{$relat->id}}">{{$relat->name}}</option>
                                    @endforeach
									</select>
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
<script src="{{asset('assets/js/select2/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/select2/select2-custom.js')}}"></script>
<script type="text/javascript">
	$(".js-example-basic-multiple-limit3").select2({
                maximumSelectionLength: 3,
            });
</script>
@endsection