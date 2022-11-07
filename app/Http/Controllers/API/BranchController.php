<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    public function index(){
        $dataContent = Branch::paginate(10);

        $result = collect($this->response);
        return $result->merge($dataContent);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);

        if($validator->fails()){
            $this->response['status'] = false;
            $this->response['text'] = $validator->errors()->first();
            $this->response['errors'] = $validator->errors();

            return $this->response;
        }

        Branch::create($request->all());

        return $this->response;
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);

        if($validator->fails()){
            $this->response['status'] = false;
            $this->response['text'] = $validator->errors()->first();
            $this->response['errors'] = $validator->errors();
            return $this->response;
        }

        $data = Branch::find($id);

        if($data){
            $data->update($request->all());
        }else{
            $this->response['status'] = false;
            $this->response['text'] = 'data not found.';
            return $this->response;
        }

        return $this->response;
    }

    public function destroy($id){
        $data = Branch::find($id);

        if($data){
            $data->delete();
        }else{
            $this->response['status'] = false;
            $this->response['text'] = 'data not found';
            return $this->response;
        }

        return $this->response;
    }
}
