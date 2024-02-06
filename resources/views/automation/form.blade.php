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
<h3>{{ isset($autos) ? 'Edit a Automation' : 'Create a new Automation' }}</h3>
@endsection



@section('content')
<form method="POST" action="{{ isset($autos) ? $autos->id : 'add'}}" class="form theme-form">
@csrf <!-- {{ csrf_field() }} -->

@isset($autos)  
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
									<input class="form-control" id="name" name="name" type="text" value="{{ isset($autos) ? $autos->name : ''}}" placeholder="Name" required>
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="exampleFormControlSelect9">Category</label>
									<select class="form-select digits" id="exampleFormControlSelect9" name="category">
                                    @foreach ($categories as $category)
										<option @if(isset($autos) && $autos->category_id == $category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
									</select>
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="exampleFormControlSelect3">Type</label>
									<select class="form-select digits" id="exampleFormControlSelect9" name="type" >
                                    @foreach ($types as $type)
										<option @if(isset($autos) && $autos->type_id == $type->id) selected @endif value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
									</select>
								</div>
							</div>
						</div>
						<hr></hr>
						<div id="dynamic2">
						@if (isset($autos->tabName))
						@foreach ($autos->tabName as $n => $tabName)
						
								<div class="mb-3">
									<div class="row" style="align-items: center">
										<div class="col">
											<label for="inputName">Tab Name</label>
											<input type="text" class="form-control" name="tabName[]" id="tabName" placeholder="Tab Name" value="{{$tabName}}"/>
										</div>
										<div class="col-lg-2">
											@if($n > 0)
											<button class="btn btn-danger" type="button" style="margin-top: 25px" id="delete" >Delete</button>
											@else
											<button class="btn btn-success" type="button" style="margin-top: 25px" id="add2">Add New Tab</button>
											@endif
										</div>
									</div>
									<div class="row" style="align-items: center">
										<div class="col">
											<div class="mb-3 mb-0">
											@if($n > 0)
												<label for="tabText{{$n}}">Tab Text</label>
												<textarea class="form-control ckeditor" id="tabText{{$n}}" rows="1" name="tabText[]">@if(isset($autos->tabText[$n])){{$autos->tabText[$n]}}@endif</textarea>
											@else
												<label for="tabText">Tab Text</label>
												<textarea class="form-control ckeditor" id="tabText" rows="1" name="tabText[]">@if(isset($autos->tabText[$n])){{$autos->tabText[$n]}}@endif</textarea>
											@endif
											</div>
										</div>
										
									</div>
								</div>
							
						@endforeach
						@else
						<div class="mb-3">
									<div class="row" style="align-items: center">
										<div class="col">
											<label for="inputName">Tab Name</label>
											<input type="text" class="form-control" name="tabName[]" id="tabName" placeholder="Tab Name" />
										</div>
										<div class="col-lg-2">
											<button class="btn btn-success" type="button" style="margin-top: 25px" id="add2">Add New Tab</button>
										</div>
									</div>
									<div class="row" style="align-items: center">
										<div class="col">
											<div class="mb-3 mb-0">
												<label for="tabText">Tab Text</label>
												<textarea class="form-control ckeditor" id="tabText" rows="1" name="tabText[]"></textarea>
											</div>
										</div>
										
									</div>
								</div>
						@endif
						
						
						</div>
                        <div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="status">Status</label>
									<select class="form-select digits" id="status" name="status">
										<option value="1">Active</option>
                                        <option value="0">Passive</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="mb-3 mb-0">
									<label for="shortDescription">Short Description</label>
									<textarea class="form-control" id="shortDescription" rows="3" name="shortDescription">{{ isset($autos) ? $autos->shortDescription : ''}}</textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="metaTitle">Meta Title</label>
									<input class="form-control" id="metaTitle" name="metaTitle" type="text" placeholder="Meta Title" value="{{ isset($autos) ? $autos->metaTitle : ''}}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="metaTitle">Meta Description</label>
									<input class="form-control" id="metaDescription" name="metaDescription" type="text" placeholder="Meta Description" value="{{ isset($autos) ? $autos->metaDescription : ''}}">
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col">
								<div class="mb-3 mb-0">
									<label for="api">Slug</label>
									<textarea class="form-control" id="api" rows="3" name="api">{{ isset($autos) ? $autos->api : ''}}</textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="mb-3 mb-0">
									<label for="slug">API</label>
									<textarea class="form-control" id="slug" rows="3" name="slug">{{ isset($autos) ? $autos->slug : ''}}</textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="url">Url</label>
									<input class="form-control" id="url" name="url" type="text" placeholder="Url" value="{{ isset($autos) ? $autos->url : ''}}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="header1">Header 1</label>
									<input class="form-control" id="header1" name="h1" type="text" placeholder="Header 1" value="{{ isset($autos) ? $autos->h1 : ''}}">
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="header2">Header 2</label>
									<input class="form-control" id="header2" name="h2" type="text" placeholder="Header 2" value="{{ isset($autos) ? $autos->h2 : ''}}">
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="header3">Header 3</label>
									<input class="form-control" id="header3" name="h3" type="text" placeholder="Header 3" value="{{ isset($autos) ? $autos->h3 : ''}}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="mb-3 mb-0">
									<label for="text1">Text 1</label>
									<textarea class="form-control ckeditor" id="text1" rows="3" name="text1">{{ isset($autos) ? $autos->text1 : ''}}</textarea>
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col">
								<div class="mb-3 mb-0">
									<label for="text2">Text 2</label>
									<textarea class="form-control ckeditor" id="text2" rows="3" name="text2">{{ isset($autos) ? $autos->text2 : ''}}</textarea>
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col">
								<div class="mb-3 mb-0">
									<label for="text3">Text 3</label>
									<textarea class="form-control ckeditor" id="text3" rows="3" name="text3">{{ isset($autos) ? $autos->text3 : ''}}</textarea>
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col">
								<div class="mb-3 mb-0">
									<label for="tutorial">Tutorial</label>
									<textarea class="form-control ckeditor" id="tutorial" rows="3" name="tutorial">{{ isset($autos) ? $autos->tutorial : ''}}</textarea>
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col">
								<div class="mb-3 mb-0">
									<label for="updates">Updates</label>
									<textarea class="form-control ckeditor" id="updates" rows="3" name="updates">{{ isset($autos) ? $autos->updates : ''}}</textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="step1Header">Step 1 Header</label>
									<input class="form-control" id="step1Header" name="step1Header" type="text" placeholder="Step 1 Header" value="{{ isset($autos) ? $autos->step1Header : ''}}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="step1Text">Step 1 Text</label>
									<input class="form-control" id="step1Text" name="step1Text" type="text" placeholder="Step 1 Text" value="{{ isset($autos) ? $autos->step1Text : ''}}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="url">step2Header 2 Header</label>
									<input class="form-control" id="step2Header" name="step2Header" type="text" placeholder="Step 2 Header" value="{{ isset($autos) ? $autos->step2Header : ''}}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="step2Text">Step 2 Text</label>
									<input class="form-control" id="step2Text" name="step2Text" type="text" placeholder="Step 2 Text" value="{{ isset($autos) ? $autos->step2Text : ''}}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="step3Header">Step 3 Header</label>
									<input class="form-control" id="step3Header" name="step3Header" type="text" placeholder="Step 3 Header" value="{{ isset($autos) ? $autos->step3Header : ''}}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="step3Text">Step 3 Text</label>
									<input class="form-control" id="step3Text" name="step3Text" type="text" placeholder="Step 3 Text" value="{{ isset($autos) ? $autos->step3Text : ''}}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="step4Header">Step 4 Header</label>
									<input class="form-control" id="step4Header" name="step4Header" type="text" placeholder="Step 4 Header" value="{{ isset($autos) ? $autos->step4Header : ''}}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="step4Text">Step 4 Text</label>
									<input class="form-control" id="step4Text" name="step4Text" type="text" placeholder="Step 4 Text" value="{{ isset($autos) ? $autos->step4Text : ''}}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="related">Related Automations</label>
									<select class="js-example-basic-multiple-limit3 col-sm-12" multiple="multiple" id="related" name="related[]" selected="1,2">
                                    @foreach ($related as $relat)
										<option @if(isset($autos->related) && in_array($relat->id, $autos->related)) selected @endif value="{{$relat->id}}">{{$relat->name}}</option>
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
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>


<script type="text/javascript">
    $(document).ready(function () {
        $('.ckeditor').ckeditor();
    });
	var i = 0;
	
	CKEDITOR.replace('tabText', {
        allowedContent: true
    });
    CKEDITOR.replace('updates', {
        filebrowserUploadUrl: "{{route('ckeditor.image-upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
    CKEDITOR.replace('tutorial', {
        filebrowserUploadUrl: "{{route('ckeditor.image-upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
    CKEDITOR.replace('text1', {
        filebrowserUploadUrl: "{{route('ckeditor.image-upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
    CKEDITOR.replace('text2', {
        filebrowserUploadUrl: "{{route('ckeditor.image-upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
    CKEDITOR.replace('text3', {
        filebrowserUploadUrl: "{{route('ckeditor.image-upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
</script>
@if (isset($autos) && isset($autos->tabName))
@foreach ($autos->tabName as $n => $tabName)
<script type="text/javascript">
	i = '{{ $n }}';
	console.log(i);
	CKEDITOR.replace('tabText{{$n}}', {
        allowedContent: true
    });

</script>
@endforeach
@endif


<script type="text/javascript">
	$(".js-example-basic-multiple-limit3").select2({
                maximumSelectionLength: 4,
            });
	$("#add2").click(function () {
		i++; 
		$("#dynamic2").append(`
		<div class="mb-3">
									<div class="row" style="align-items: center">
										<div class="col">
											<label for="inputName">Tab Name</label>
											<input type="text" class="form-control" name="tabName[]" id="tabName" placeholder="Tab Name" />
										</div>
										<div class="col-lg-2">
											<button class="btn btn-danger" type="button" style="margin-top: 25px" id="delete">Delete</button>
										</div>
									</div>
									<div class="row" style="align-items: center">
										<div class="col">
											<div class="mb-3 mb-0">
												<label for="tabText">Tab Text</label>
												<textarea class="form-control ckeditor" id="tabText`+i+`" rows="1" name="tabText[]"></textarea>
											</div>
										</div>
										
									</div>
								</div>
		`)

		CKEDITOR.replace('tabText'+i, {
        allowedContent: true
    });
		
    });
    $(document).on('click', '#delete', function () {
        $(this).parent().parent().parent().remove();
    });

</script>
@endsection


