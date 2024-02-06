@extends('layouts.simple.master')

@section('title', 'Package Manage')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/chartist.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/date-picker.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>{{ isset($packages) ? 'Edit a Package' : 'Create a new Package' }}</h3>
@endsection



@section('content')
<form method="POST" action="{{ isset($packages) ? $packages->id : 'add'}}" enctype="multipart/form-data" class="form theme-form">
@csrf <!-- {{ csrf_field() }} -->

@isset($packages)  
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
									<input class="form-control" id="name" name="name" type="text" value="{{ isset($packages) ? $packages->name : ''}}" placeholder="Name">
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="timeLimit">Time limit (second)</label>
									<input class="form-control" id="timeLimit" name="timeLimit" type="text" value="{{ isset($packages) ? $packages->timeLimit : ''}}" placeholder="Time Limit">
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="autoLimit">Automation limit</label>
									<input class="form-control" id="autoLimit" name="autoLimit" type="text" value="{{ isset($packages) ? $packages->autoLimit : ''}}" placeholder="Automation Limit">
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




