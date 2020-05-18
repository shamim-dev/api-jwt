<?php

namespace App\Http\Controllers;

use App\Model\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return response()->json(['data' => Category::all()], 200);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:categories'
        ]);

        try {
            $data = new Category;
            $data->name = $request->name;
            $data->parent_id = $request->parent_id;
            $data->rank = $request->rank;
            $data->ip_address = $request->ip();
            $data->save();
            return response()->json(['data' => $data, 'message' => 'Created successfully!'], 201);

        } catch (\Exception $e) {
            //dd($e);
            return response()->json(['message' => 'Error found',], 409);
        }
    }


    public function show($id)
    {
        try {
            $data = Category::findOrFail($id);

            return response()->json(['data' => $data], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'Data not found!'], 404);
        }
    }


    public function edit($id)
    {
        try {
            $data = Category::findOrFail($id);

            return response()->json(['data' => $data], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'Data not found!'], 404);
        }
    }

    public function search(Request $request)
    {
        $this->validate($request,['searchStr'=>'required|string']);
        try {
            $searchItem = $request->searchStr;
            $data = Category::query()
                ->where('name', 'LIKE', "%{$searchItem}%")
                ->get();
            if(!$data->isEmpty()){
                return response()->json(['data' => $data,'message' => 'Result  with this query'], 200);
            }else{
                return response()->json(['data' => $data,'message' => 'No data found!'], 404);
            }


        } catch (\Exception $e) {

            return response()->json(['message' => 'Error found!'], 500);
        }

    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:categories'
        ]);

        try {
            $data = $request->all();
            $data['updated_by'] = 1;
            $data['updated_at'] = Carbon::now();
            $data['ip_address'] = $request->ip();
            Category::where('id', $id)->update($request->all());
            return response()->json(['message' => 'Data updated successfully'], 200);
        } catch (\Exception $e) {
            $errCode=$e->getCode();
            $errMgs=$e->getMessage();
            return response()->json(['error code'=>$errCode,'message' => $errMgs ], 500);
        }
    }


    public function destroy($id)
    {
        try {
            Category::findOrFail($id)->delete();
            return response()->json(['message' => 'Data deleted successfully'], 200);

        } catch (\Exception $e) {

            $errCode=$e->getCode();
            $errMgs=$e->getMessage();
            return response()->json(['error code'=>$errCode,'message' => $errMgs ], 500);
        }
    }

}