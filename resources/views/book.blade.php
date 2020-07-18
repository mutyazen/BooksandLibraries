@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-12">
							<h1 class="mt-0 strong">List Book</h1>
							<hr>
							<button id="default-btn-modal" type="button" class="btn btn-info btn-modal float-right" data-toggle="modal" data-target="#default-modal"><i class="fa fa-plus"> New Entry</i></button>
						</div>
					</div>
					<div class="table-responsive py-4">
						<table id="dt" class="table table-striped table-bordered" style="width:100%">
							<thead>
								<tr>
									<th style="width:10px;">#</th>
									<th style="min-width:500px;">Name</th>
									<th style="min-width:20px;"><i class="fa fa-gear"></i></th>
								</tr>
							</thead>
							<tbody>
								<?php $a=1; ?>
								@foreach($data as $row)
								<tr>
									<td>{{$a++}}</td>
									<td>{{$row->name}}</td>
									<td>
										<button class="btn btn-info btn-detail" data-id="{{$row->id}}" data-uri="{{ route('book-detail') }}"><i class="fa fa-eye"></i></button>
										<button class="btn btn-warning btn-edit" data-id="{{$row->id}}" data-uri="/book/detail"><i class="fa fa-pencil"></i></button>
										<button class="btn btn-danger btn-delete" data-id="{{$row->id}}" data-title="{{$row->name}}" data-uri="/book/delete"><i class="fa fa-trash"></i></button>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="default-modal" role="dialog"><div class="modal-dialog"><div class="modal-content">
	<div class="modal-header">
		<h4 class="modal-title">Book - <span id="modal-type">New Entry</span></h4>
		<button type="button" class="close" data-dismiss="modal">&times;</button>
	</div>
	<div class="modal-body">
		<div class="col-md-12">
			<div class="row clearfix">
				<div class="col-md-12">
					<form method="POST" action="{{ route('book-save') }}" id="default-form">
						@csrf
						<div class="form-group">
							<label>Book Name</label>
							<input type="text" class="form-control" name="book_name" id="book-name">
						</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<input type="text" class="collapse" id="type" name="type" value="">
        <input type="text" class="collapse" id="id" name="id" value="">
		<button id="btn-submit" type="submit" class="btn btn-info float-right">Submit</button>
	</div>
	</form>
</div></div></div>
@endsection
