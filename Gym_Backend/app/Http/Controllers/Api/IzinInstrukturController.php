<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\IzinInstruktur;
use function PHPUnit\Framework\returnSelf;

class IzinInstrukturController extends Controller
{
    public function index()
    {
        $instruktur=IzinInstruktur::with('instruktur', 'instrukturPengganti')->latest()->get();

        if(count($instruktur)>0){
            return response([
                'message'=>'Retrieve All Success',
                'data'=>$instruktur
            ],200);
        }

        return response([
            'message'=>'Empty',
            'data'=>null
        ],400);
    }    

    public function show($id)
    {
        $user=IzinInstruktur::find($id);

        if(!is_null($user)){
            return response([
                'message'=>'retrieve Instruktur success',
                'data'=>$user
            ],200);
        }

        return response([
            'message'=>'Instruktur not found',
            'data'=>null
        ],404);
    }

       /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'id_instruktur'=>'required',
            'alasan_izin'=>'required',
            'status_izin'=>'required',
            'tanggal_izin'=>'required',
            'id_instruktur_pengganti'=>'required',
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $instruktur = IzinInstruktur::create($storeData);
        return response([
            'message' => 'Add Instruktur Success',
            'data' => $instruktur
        ], 200);
    }

   
    public function update(Request $request, $id) 
    {
        $instruktur = IzinInstruktur::find($id);
        if(is_null($instruktur)){
            return response([
                'message' => 'Instruktur Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'id_instruktur'=>'required',
            'alasan_izin'=>'required',
            'status_izin'=>'required',
            'tanggal_izin'=>'required',
            'id_instruktur_pengganti'=>'required',
        ]);

        if($validate->fails())
            return response(['message' => $validate->error()], 400);

        $instruktur->id_instruktur = $updateData['id_instruktur'];
        $instruktur->alasan_izin = $updateData['alasan_izin'];
        $instruktur->status_izin = $updateData['status_izin'];
        $instruktur->tanggal_izin = $updateData['tanggal_izin'];
        $instruktur->id_instruktur_pengganti = $updateData['id_instruktur_pengganti'];

        if($instruktur->save()){
            return response([
                'message' => 'Update Instruktur Success',
                'data' => $instruktur
            ], 200);
        }

        return response([
            'message' => 'Update Instruktur Failed',
            'data' => null
        ], 400);
    }
    
    public function destroy($id)
    {
        $instruktur=IzinInstruktur::find($id);

        if(is_null($instruktur)){
            return response([
                'message'=>'Instruktur not found',
                'data'=>null
            ],404);
        }

        if($instruktur->delete()){
            return response([
                'message'=>'delete Instruktur success',
                'data'=>$instruktur
            ],200);
        }

        return response([
            'message'=>'deleteInstruktur failed',
            'data'=>null
        ],400);
    }

    /*public function search()
    {
        $searchQuery = request('query');

        $user= IzinInstruktur::where('nama', 'LIKE', "%{$searchQuery}%")->get(); 

        if(!is_null($user)){
            return response([
                'message'=>'retrieve Instruktur success',
                'data'=>$user
            ],200);
        }

        return response([
            'message'=>'Instruktur not found',
            'data'=>null
        ],404);
    }*/

    public function updateStatus(Request $request, $id) 
    {
        $instruktur = IzinInstruktur::find($id);
        if(is_null($instruktur)){
            return response([
                'message' => 'Instruktur Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'status_izin'=>'required',
        ]);

        if($validate->fails())
            return response(['message' => $validate->error()], 400);

        $instruktur->status_izin = $updateData['status_izin'];

        if($instruktur->save()){
            return response([
                'message' => 'Update Instruktur Success',
                'data' => $instruktur
            ], 200);
        }

        return response([
            'message' => 'Update Instruktur Failed',
            'data' => null
        ], 400);
    }
}