@extends('layouts.app')

@section('content')
<div class="container">
    <div id="library" class="row justify-content-center">
        <div class="col-md-12">
            <div class="row">
                @foreach($data_library as $row)
                <div class="col-lg-4 col-md-12 py-4">
                    <div class="card">
                        <div class="card-header">{{ $row->name }}
                            <button type="button" class="btn btn-info btn-modal float-right mr-2" data-name="{{ $row->name }}" data-id="{{ $row->id }}"><i class="fa fa-plus"> Book</i></button>
                            </div>
                        <div class="card-body">
                            <div class="col">
                                <div class="row">
                                    <?php $a = 0; ?>
                                    @foreach($data_trans as $key => $data)
                                    <?php //var_dump($data);exit;?>
                                        @if ($data->library_id == $row->id)
                                            <button data-idbook="{{ $data->book_id }}"
                                            data-idtrans="{{ $data->id }}" data-name="{{$data->name}}" data-namelib="{{$row->name}}" class="btn-book col-4 py-4">{{$data->name}}</button>
                                            <?php $a++; ?>
                                        @endif
                                    @endforeach
                                    @if ($a == 0)
                                        <div class="col-12 py-4">Library is empty</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="default-modal" role="dialog"><div class="modal-dialog"><div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Book - <span id="modal-type">New Book to </span><span id="modal-library"></span></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
        <div class="col-md-12">
            <div class="row clearfix">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('book-save') }}" id="default-form">
                        @csrf
                        <div class="form-group">
                            <label id="book-form">Book Name</label>
                            <select class="select2" id="book-id" name="book_id" data-placeholder="Select Book" style="width: 100%;" required>
                                <option></option>
                                @foreach($data_book as $row)
                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input type="text" class="collapse" id="type" name="type" value="">
        <input type="text" class="collapse" id="id" name="id" value="">
        <input type="text" class="collapse" id="id-trans" name="id" value="">
        <button id="btn-submit" type="submit" class="btn btn-info float-right">Submit</button>
    </div>
    </form>
</div></div></div>

<!-- Modal Edit -->
<div class="modal fade" id="default-modal-book" role="dialog"><div class="modal-dialog"><div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title"><span id="modal-library"></span> - <span id="modal-book"></span></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
        <div class="col-md-12">
            <div class="row clearfix">
                <div class="col-md-12">
                    <center>
                        <button id="btn-edit-book" data-idtrans="" data-idbook="" class="btn btn-warning"><i class="fa fa-pencil"></i></button>
                        <button id="btn-delete-book" data-idtrans="" data-name="" class="btn btn-danger"><i class="fa fa-trash"></i></button> 
                    </center>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
    </div>
</div></div></div>

@endsection
