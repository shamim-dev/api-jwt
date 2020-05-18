<?php

namespace App\Http\Controllers;

use App\Attribute;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return response()->json(['data' => Attribute::all()], 200);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:attributes',
            'attribute_group_id' => 'required|numeric'
        ]);

        try {

           /* $attributes = new Attribute;
            $attributes->name = $request->name;
            $attributes->attribute_group_id = $request->attribute_group_id;
            $attributes->ip_address = $request->ip();
            $attributes->save();*/
            
            $postData=$request->all();
            $postData['ip_address']=$request->ip();
            $data= Attribute::create($postData);
            return response()->json(['data' => $data, 'message' => 'Created successfully!'], 201);

        } catch (\Exception $e) {
            $errCode = $e->getCode();
            $errMgs = $e->getMessage();
            return response()->json(['error code' => $errCode, 'message' => $errMgs], 409);
        }
    }


    public function show($id)
    {
        try {
            $attributes = Attribute::findOrFail($id);

            return response()->json(['data' => $attributes], 200);

        } catch (\Exception $e) {
            $errCode = $e->getCode();
            $errMgs = $e->getMessage();
            return response()->json(['error code' => $errCode, 'message' => $errMgs], 500);
        }
    }


    public function edit($id)
    {
        try {
            $attributes = Attribute::findOrFail($id);

            return response()->json(['data' => $attributes], 200);

        } catch (\Exception $e) {
            $errCode = $e->getCode();
            $errMgs = $e->getMessage();
            return response()->json(['error code' => $errCode, 'message' => $errMgs], 500);
        }
    }

    public function search(Request $request)
    {
        $this->validate($request, ['searchStr' => 'required|string']);
        try {
            $searchItem = $request->searchStr;
            $attributes = Attribute::query()
                ->where('name', 'LIKE', "%{$searchItem}%")
                ->get();
            if (!$attributes->isEmpty()) {
                return response()->json(['data' => $attributes, 'message' => 'Result with this query'], 200);
            } else {
                return response()->json(['data' => $attributes, 'message' => 'No data found!'], 404);
            }


        } catch (\Exception $e) {
            $errCode = $e->getCode();
            $errMgs = $e->getMessage();
            return response()->json(['error code' => $errCode, 'message' => $errMgs], 500);
        }

    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:attributes,name,' . $id
        ]);

        try {
            $data = $request->all();
            $data['updated_by'] = 1;
            $data['updated_at'] = Carbon::now();
            $data['ip_address'] = $request->ip();
            Attribute::where('id', $id)->update($request->all());
            return response()->json(['message' => 'Data updated successfully'], 200);
        } catch (\Exception $e) {
            $errCode = $e->getCode();
            $errMgs = $e->getMessage();
            return response()->json(['error code' => $errCode, 'message' => $errMgs], 500);
        }
    }


    public function destroy($id)
    {
        try {
            Attribute::findOrFail($id)->delete();
            return response()->json(['message' => 'Data deleted successfully'], 200);

        } catch (\Exception $e) {

            $errCode = $e->getCode();
            $errMgs = $e->getMessage();
            return response()->json(['error code' => $errCode, 'message' => $errMgs], 500);
        }
    }
}