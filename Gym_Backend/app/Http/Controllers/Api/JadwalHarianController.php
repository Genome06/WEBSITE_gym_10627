<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Jadwal_Harian;

class JadwalHarianController extends Controller
{
    public function index()
    {
        $users = Jadwal_Harian::with('jadwalUmum', 'instruktur')->orderBy("id_jadwal_umum", "asc")->get();

        if(count($users)>0){
            return response([
                'message'=>'Retrieve All Success',
                'data'=>$users
            ],200);
        }

        return response([
            'message'=>'Empty',
            'data'=>null
        ],400);
    }    

    public function show($id)
    {
        $user=Jadwal_Harian::find($id);

        if(!is_null($user)){
            return response([
                'message'=>'retrieve Jadwal Harian success',
                'data'=>$user
            ],200);
        }

        return response([
            'message'=>'Jadwal Harian not found',
            'data'=>null
        ],404);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'id_jadwal_umum' => 'required',
            'tanggal' => 'required',
            'status' => 'required'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400); 

        $instruktur = Jadwal_Harian::create($storeData);
        return response([
            'message' => 'Add Jadwal Harian Success',
            'data' => $instruktur
        ], 200);
    }


   
    public function update(Request $request, $id) 
    {
        $user = Jadwal_Harian::find($id);
        if(is_null($user)){
            return response([
                'message' => 'Jadwal Harian Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'status' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->error()], 400);


        $user->status = $updateData['status'];

        if($user->save()){
            return response([
                'message' => 'Update Jadwal Harian Succes',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Update Jadwal Harian Failed',
            'data' => null
        ], 400);
    }
    
    public function destroy($id)
    {
        $user=Jadwal_Harian::find($id);

        if(is_null($user)){
            return response([
                'message'=>'Jadwal Harian not found',
                'data'=>null
            ],404);
        }

        if($user->delete()){
            return response([
                'message'=>'Jadwal Harian success',
                'data'=>$user
            ],200);
        }

        return response([
            'message'=>'delete Jadwal Harian failed',
            'data'=>null
        ],400);
    }
}