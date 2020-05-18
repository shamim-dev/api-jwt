<?php

namespace App\Http\Controllers;

use App\Model\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return response()->json(['companies' => Company::all()], 200);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:companies',
            'web_url' => 'required|string|unique:companies',
            'status' => 'required|boolean'
        ]);

        try {
            $data = new Company;
            $data->name = $request->name;
            $data->web_url = $request->web_url;
            $data->status = $request->status;
            $data->ip_address = $request->ip();
            $data->save();
            return response()->json(['data' => $data, 'message' => 'Created successfully!'], 201);

        } catch (\Exception $e) {
            dd($e);
            return response()->json(['message' => 'Error found',], 409);
        }
    }


    public function show($id)
    {
        try {
            $data = Company::findOrFail($id);

            return response()->json(['data' => $data], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'Data not found!'], 404);
        }
    }


    public function edit($id)
    {
        try {
            $data = Company::findOrFail($id);

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
            $data = Company::query()
                ->where('name', 'LIKE', "%{$searchItem}%")
                ->orWhere('web_url', 'LIKE', "%{$searchItem}%")
                ->get();
            if(!$data->isEmpty()){
                return response()->json(['data' => $data,'message' => 'Result  with this query'], 200);
            }else{
                return response()->json(['data' => $data,'message' => 'No data found!'], 404);
            }


        } catch (\Exception $e) {
            //dd($e);
            return response()->json(['message' => 'Error found!'], 500);
        }

    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:companies',
            'web_url' => 'required|string|unique:companies',
            'status' => 'required|boolean'
        ]);

        try {
            $data = $request->all();
            $data['updated_by'] = 1;
            $data['updated_at'] = Carbon::now();
            $data['ip_address'] = $request->ip();
            Company::where('id', $id)->update($request->all());
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
            Company::findOrFail($id)->delete();
            return response()->json(['message' => 'Data deleted successfully'], 200);
        } catch (\Exception $e) {

            $errCode=$e->getCode();
            $errMgs=$e->getMessage();
            return response()->json(['error code'=>$errCode,'message' => $errMgs ], 500);
        }
    }

}