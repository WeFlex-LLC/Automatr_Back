@extends('layouts.simple.master')

@section('title', 'Admins')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatable-extension.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Admin Management</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Admin</li>
<li class="breadcrumb-item active">Management</li>
@endsection

@section('content')


<form>
    <div class="col-sm-12">
    <a href="add"><i class="fa fa-plus"> Add new</i></a>
		<div class="card-body">
		    <div class="dt-ext table-responsive">
						<table class="display" id="keytable">
							<thead>
								<tr>
									<th>Name</th>
									<th>E-Mail</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
                            @foreach ($admins as $admin)
								<tr>
									<td>{{ $admin->name }}</td>
									<td>{{ $admin->email }}</td>
									<td><a href="edit/{{$admin->id}}"><i class="fa fa-edit"></i></a><form method="POST" action="delete/{{$admin->id}}" id="deleteForm{{$admin->id}}"> @method('DELETE')  @csrf <a href="#" onclick="$('#deleteForm{{$admin->id}}').submit();"><i class="fa fa-trash-o"></i></a> </form> </td>
								</tr>
                                
                            @endforeach
							</tbody>
							<tfoot>
								<tr>
                                    <th>Name</th>
									<th>E-Mail</th>
									<th>Action</th>
								</tr>
							</tfoot>
						</table>
			</div>
		</div>
	</div>
</form>
@endsection

@section('script')
<script src="{{asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/jszip.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/dataTables.autoFill.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/dataTables.select.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/dataTables.keyTable.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/dataTables.colReorder.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/dataTables.rowReorder.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/dataTables.scroller.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/custom.js')}}"></script>
@endsection

