<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(){
        $dataContent = Product::paginate(10);

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

        Product::create($request->all());

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

        $product = Product::find($id);

        if($product){
            $product->update($request->all());
        }

        return $this->response;
    }

    public function destroy($id){
        $product = Product::find($id);

        if($product){
            $product->delete();
        }else{
            $this->response['status'] = false;
            $this->response['text'] = 'data not found';
            return $this->response;
        }

        return $this->response;
    }
}
