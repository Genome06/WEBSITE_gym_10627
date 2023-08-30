<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Jadwal_Umum;

class JadwalUmumController extends Controller
{
    public function index()
    {
        $users = Jadwal_Umum::with('kelas', 'instruktur')->orderBy("waktu", "asc")->get();

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
        $user=Jadwal_Umum::find($id);

        if(!is_null($user)){
            return response([
                'message'=>'retrieve Jadwal Umum success',
                'data'=>$user
            ],200);
        }

        return response([
            'message'=>'Jadwal Umum not found',
            'data'=>null
        ],404);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'id_kelas' => 'required',
            'id_instruktur' => 'required',
            'waktu' => 'required',
            'waktu_hari' => 'required'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400); 

        $instruktur = Jadwal_Umum::create($storeData);
        return response([
            'message' => 'Add Instruktur Success',
            'data' => $instruktur
        ], 200);
    }


   
    public function update(Request $request, $id) 
    {
        $user = Jadwal_Umum::find($id);
        if(is_null($user)){
            return response([
                'message' => 'Jadwal Umum Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'id_kelas' => 'required',
            'id_instruktur' => 'required',
            'waktu' => 'required',
            'waktu_hari' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->error()], 400);


        $user->id_kelas = $updateData['id_kelas'];
        $user->id_instruktur = $updateData['id_instruktur'];
        $user->waktu = $updateData['waktu'];
        $user->waktu_hari = $updateData['waktu_hari'];

        if($user->save()){
            return response([
                'message' => 'Update Jadwal Umum Succes',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Update Jadwal Umum Failed',
            'data' => null
        ], 400);
    }
    
    public function destroy($id)
    {
        $user=Jadwal_Umum::find($id);

        if(is_null($user)){
            return response([
                'message'=>'Jadwal Umum not found',
                'data'=>null
            ],404);
        }

        if($user->delete()){
            return response([
                'message'=>'Jadwal Umum Kelas success',
                'data'=>$user
            ],200);
        }

        return response([
            'message'=>'delete Jadwal Umum failed',
            'data'=>null
        ],400);
    }
}