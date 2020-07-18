<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Book;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	/*** Area for adding CSS ***/
		$this->fragment['site']['css'] = [
            "text/css,stylesheet,".url("plugins/sweetalert2/dist/sweetalert2.min.css"),
		];
		/*** Area for adding JS ***/
		$this->fragment['site']['js'] = [
            url("plugins/sweetalert2/dist/sweetalert2.min.js"),
            url("js/book.js"),
        ];
        $this->fragment['data'] = Book::all();
        return view('book', $this->fragment);
    }

    public function save(Request $req){
        $name   = $req->input('name');
        $type   = $req->input('type');
        $id     = $req->input('id');
        if ( empty($name) ){$response['msg'] = "Please Input Book Name."; return json_encode($response);exit;}

        $type = ($type == "update") ? "update" : "new";
        if ( $type == "update" ){
            if ( empty($id) ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
            $book = Book::find($id);
            if ( !$book ) {$this->response['msg'] = "Book not found.";echo json_encode($this->response);exit;}

        }else{
            $book = new Book;
        }

        $book->name = $name;
        $book->save();
        /*** Result Area ***/
        $response['type'] = 'done';
        $response['msg'] = ($type == "update") ? "Successfully to update data." : "Successfully to insert data.";
        return json_encode($response);exit;
    }

    public function detail(Request $req){
        $key = $req->input('key');
        if( empty($key) ){$response['msg'] = "Error parameters"; return json_encode($response);exit;}

        $book = Book::find($key);
        if ( !$book ) {$this->response['msg'] = "Book not found.";echo json_encode($this->response);exit;}

        $response['type']   = 'done';
        $response['msg']    = $book;
        echo json_encode($response);exit;
    }

    public function delete(Request $req){
        $key = $req->input('key');
        if( empty($key) ){$response['msg'] = "Error parameters"; return json_encode($response);exit;}

        $book = Book::find($key);
        if ( !$book ) {$this->response['msg'] = "Book not found.";echo json_encode($this->response);exit;}

        $book->delete();

        $response['type']   = 'done';
        $response['msg'] = "Successfully to delete data.";
        echo json_encode($response);exit;

    }
}
