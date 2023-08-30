<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai=User::all();

        if(count($pegawai)>0){
            return response([
                'message'=>'Retrieve All Success',
                'data'=>$pegawai
            ],200);
        }

        return response([
            'message'=>'Empty',
            'data'=>null
        ],400);
    }    

    public function show($id)
    {
        $pegawai=User::find($id);

        if(!is_null($pegawai)){
            return response([
                'message'=>'retrieve pegawai success',
                'data'=>$pegawai
            ],200);
        }

        return response([
            'message'=>'Pegawai not found',
            'data'=>null
        ],404);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'username'=>'required',
            'password'=>'required',
            'nama'=>'required|max:60',
            'jabatan' => 'required',
            'no_hp' => 'required|numeric|digits_between:11,13|starts_with:08',
            'alamat' => 'required'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $storeData['password'] = bcrypt($request->password);  
            
        $pegawai = User::create($storeData);
        return response([
            'message' => 'Add Pegawai Success',
            'data' => $pegawai
        ], 200);
    }

   
    public function update(Request $request, $id) 
    {
        $pegawai = User::find($id);
        if(is_null($pegawai)){
            return response([
                'message' => 'Pegawai Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'username'=>'required',
            'password'=>'required',
            'nama'=>'required|max:60',
            'jabatan' => 'required',
            'no_hp' => 'required|numeric|digits_between:11,13|starts_with:08',
            'alamat' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->error()], 400);

        $updateData['password'] = bcrypt($request->password);

        $pegawai->username = $updateData['username'];
        $pegawai->password = $updateData['password'];
        $pegawai->nama = $updateData['nama'];
        $pegawai->no_hp = $updateData['no_hp'];
        $pegawai->alamat = $updateData['alamat'];
        $pegawai->jabatan = $updateData['jabatan'];

        if($pegawai->save()){
            return response([
                'message' => 'Update Pegawai Success',
                'data' => $pegawai
            ], 200);
        }

        return response([
            'message' => 'Update Pegawai Failed',
            'data' => null
        ], 400);
    }
    
    public function destroy($id)
    {
        $pegawai=User::find($id);

        if(is_null($pegawai)){
            return response([
                'message'=>'Pegawai not found',
                'data'=>null
            ],404);
        }

        if($pegawai->delete()){
            return response([
                'message'=>'delete Pegawai success',
                'data'=>$pegawai
            ],200);
        }

        return response([
            'message'=>'delete Pegawai failed',
            'data'=>null
        ],400);
    }
}