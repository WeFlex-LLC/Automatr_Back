@extends('layouts.simple.master')

@section('title', 'Type Manage')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/chartist.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/date-picker.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>{{ isset($types) ? 'Edit a Type' : 'Create a new Type' }}</h3>
@endsection



@section('content')
<form method="POST" action="{{ isset($types) ? $types->id : 'add'}}" enctype="multipart/form-data" class="form theme-form">
@csrf <!-- {{ csrf_field() }} -->

@isset($types)  
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
									<input class="form-control" id="name" name="name" type="text" value="{{ isset($types) ? $types->name : ''}}" placeholder="Name">
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


