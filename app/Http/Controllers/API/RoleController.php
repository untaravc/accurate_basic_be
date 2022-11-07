<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        $dataContent = Role::paginate(10);

        $result = collect($this->response);
        return $result->merge($dataContent);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            $this->response['status'] = false;
            $this->response['text'] = $validator->errors()->first();
            $this->response['errors'] = $validator->errors();

            return $this->response;
        }

        Role::create($request->all());

        return $this->response;
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            $this->response['status'] = false;
            $this->response['text'] = $validator->errors()->first();
            $this->response['errors'] = $validator->errors();
            return $this->response;
        }

        $data = Role::find($id);

        if ($data) {
            $data->update($request->all());
        } else {
            $this->response['status'] = false;
            $this->response['text'] = 'data not found.';
            return $this->response;
        }

        return $this->response;
    }

    public function destroy($id)
    {
        $data = Role::find($id);

        if ($data) {
            $data->delete();
        } else {
            $this->response['status'] = false;
            $this->response['text'] = 'data not found';
            return $this->response;
        }

        return $this->response;
    }
}
