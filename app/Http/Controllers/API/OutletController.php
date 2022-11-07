<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OutletController extends Controller
{
    public function index()
    {
        $dataContent = Outlet::paginate(10);

        $result = collect($this->response);
        return $result->merge($dataContent);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'branch_id' => 'required',
        ]);

        if ($validator->fails()) {
            $this->response['status'] = false;
            $this->response['text'] = $validator->errors()->first();
            $this->response['errors'] = $validator->errors();

            return $this->response;
        }

        $branch = Branch::find($request->branch_id);
        if(!$branch){
            $this->response['status'] = false;
            $this->response['text'] = 'Branch not found';

            return $this->response;
        }

        Outlet::create($request->all());

        return $this->response;
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'branch_id' => 'required',
        ]);

        if ($validator->fails()) {
            $this->response['status'] = false;
            $this->response['text'] = $validator->errors()->first();
            $this->response['errors'] = $validator->errors();
            return $this->response;
        }

        $data = Outlet::find($id);

        $branch = Branch::find($request->branch_id);
        if(!$branch){
            $this->response['status'] = false;
            $this->response['text'] = 'Branch not found';

            return $this->response;
        }

        if ($data) {
            $data->update($request->all());
        }else{
            $this->response['status'] = false;
            $this->response['text'] = 'data not found.';
            return $this->response;
        }

        return $this->response;
    }

    public function destroy($id)
    {
        $product = Outlet::find($id);

        if ($product) {
            $product->delete();
        } else {
            $this->response['status'] = false;
            $this->response['text'] = 'data not found';
            return $this->response;
        }

        return $this->response;
    }
}
