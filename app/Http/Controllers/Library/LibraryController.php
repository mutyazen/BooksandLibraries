<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Library;

class LibraryController extends Controller
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
        $this->fragment['data'] = Library::all();
        return view('library', $this->fragment);
    }

    public function save(Request $req){
        // $name   = $req->library_name;
        $name   = $req->input('name');
        $type   = $req->input('type');
        $id     = $req->input('id');
        if ( empty($name) ){$response['msg'] = "Please Input Library Name."; return json_encode($response);exit;}

        $type = ($type == "update") ? "update" : "new";
        if ( $type == "update" ){
            if ( empty($id) ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
            $library = Library::find($id);
            if ( !$library ) {$this->response['msg'] = "Library not found.";echo json_encode($this->response);exit;}

        }else{
            $library = new Library;
        }

        $library->name = $name;
        $library->save();
        /*** Result Area ***/
        $response['type'] = 'done';
        $response['msg'] = ($type == "update") ? "Successfully to update data." : "Successfully to insert data.";
        return json_encode($response);exit;
    }

    public function detail(Request $req){
        $key = $req->input('key');
        if( empty($key) ){$response['msg'] = "Error parameters"; return json_encode($response);exit;}

        $library = Library::find($key);
        if ( !$library ) {$this->response['msg'] = "Library not found.";echo json_encode($this->response);exit;}

        $response['type']   = 'done';
        $response['msg']    = $library;
        echo json_encode($response);exit;
    }

    public function delete(Request $req){
        $key = $req->input('key');
        if( empty($key) ){$response['msg'] = "Error parameters"; return json_encode($response);exit;}

        $library = Library::find($key);
        if ( !$library ) {$this->response['msg'] = "Library not found.";echo json_encode($this->response);exit;}

        $library->delete();

        $response['type']   = 'done';
        $response['msg'] = "Successfully to delete data.";
        echo json_encode($response);exit;

    }
}
