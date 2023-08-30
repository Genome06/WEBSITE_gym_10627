<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\DepositUang;

class DepositUangController extends Controller
{
    public function index()
    {
        $users = DepositUang::with('member', 'pegawai', 'promo')->latest()->get();

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
        $user=DepositUang::find($id);

        if(!is_null($user)){
            return response([
                'message'=>'retrieve Deposit Uang success',
                'data'=>$user
            ],200);
        }

        return response([
            'message'=>'Deposit Uang not found',
            'data'=>null
        ],404);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'id_member' =>'required',
            'id_kasir'=> 'required',
            'id_promo'=> 'required',
            'waktu'=> 'required',
            'biaya_deposit'=> 'required',
            'no_deposit'=> 'required'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400); 

        $instruktur = DepositUang::create($storeData);
        return response([
            'message' => 'Add Aktivasi Tahunan Success',
            'data' => $instruktur
        ], 200);
    }


   
    /*public function update(Request $request, $id) 
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
            'id_instruktur' => 'required',
            'status' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->error()], 400);


        $user->id_instruktur = $updateData['id_instruktur'];
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
    }*/
    
    /*public function destroy($id)
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
    }*/
}