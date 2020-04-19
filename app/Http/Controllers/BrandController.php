<?php

namespace App\Http\Controllers;

use App\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return response()->json(['brands' => Brand::all()], 200);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'code' => 'required|string|unique:brands',
            'image' => 'required|string',
            'sort_order' => 'required|numeric'
        ]);

        try {
            $brand = new Brand;

            $brand->name = $request->name;
            $brand->code = $request->code;
            $brand->image = $request->image;
            $brand->sort_order = $request->sort_order;
            $brand->ip_address = $request->ip();
            $brand->save();
            return response()->json(['brands' => $brand, 'message' => 'Created successfully!'], 201);

        } catch (\Exception $e) {

            return response()->json(['message' => 'Error found',], 409);
        }
    }


    public function show($id)
    {
        try {
            $brands = Brand::findOrFail($id);

            return response()->json(['brands' => $brands], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'Data not found!'], 404);
        }
    }


    public function edit($id)
    {
        try {
            $brands = Brand::findOrFail($id);

            return response()->json(['brands' => $brands], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'Data not found!'], 404);
        }
    }

    public function search(Request $request)
    {
        $this->validate($request,['searchStr'=>'required|string']);
        try {
            $searchItem = $request->searchStr;
            $brand = Brand::query()
                ->where('name', 'LIKE', "%{$searchItem}%")
                ->orWhere('code', 'LIKE', "%{$searchItem}%")
                ->get();
            if(!$brand->isEmpty()){
                return response()->json(['datas' => $brand,'message' => 'Result  with this query'], 200);
            }else{
                return response()->json(['datas' => $brand,'message' => 'No data found!'], 404);
            }


        } catch (\Exception $e) {

            return response()->json(['message' => 'Error found!'], 500);
        }

    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'code' => 'sometimes|required|string|unique:brands,code,' . $id,
            'image' => 'required|string',
            'sort_order' => 'required|numeric',
            'status' => 'required|numeric'
        ]);

        try {
            $data = $request->all();
            $data['updated_by'] = 1;
            $data['updated_at'] = Carbon::now();
            $data['ip_address'] = $request->ip();
            Brand::where('id', $id)->update($request->all());
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
            Brand::findOrFail($id)->delete();
            return response()->json(['message' => 'Data deleted successfully'], 200);

        } catch (\Exception $e) {

            $errCode=$e->getCode();
            $errMgs=$e->getMessage();
            return response()->json(['error code'=>$errCode,'message' => $errMgs ], 500);
        }
    }

}