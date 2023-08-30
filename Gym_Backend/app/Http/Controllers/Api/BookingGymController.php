<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\BookingGym;
use function PHPUnit\Framework\returnSelf;

class BookingGymController extends Controller
{
    public function index()
    {
        $instruktur=BookingGym::with('member')->latest()->get();

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
        $user=BookingGym::with('member')->find($id);

        if(!is_null($user)){
            return response([
                'message'=>'retrieve Booking Gym success',
                'data'=>$user
            ],200);
        }

        return response([
            'message'=>'Booking Gym not found',
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
            'id_member'=>'required',
            'status_hadir'=>'required',
            'no_booking'=>'required',
            'tanggal_booking'=>'required'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $instruktur = BookingGym::create($storeData);
        return response([
            'message' => 'Add Booking Gym Success',
            'data' => $instruktur
        ], 200);
    }

   
    public function update(Request $request, $id) 
    {
        $instruktur = BookingGym::find($id);
        if(is_null($instruktur)){
            return response([
                'message' => 'Instruktur Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'id_member'=>'required',
            'status_hadir'=>'required',
            'no_booking'=>'required',
            'tanggal_booking'=>'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->error()], 400);

        $instruktur->id_member = $updateData['id_member'];
        $instruktur->status_hadir = $updateData['status_hadir'];
        $instruktur->no_booking = $updateData['no_booking'];
        $instruktur->tanggal_booking = $updateData['tanggal_booking'];
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
        $instruktur=BookingGym::find($id);

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
        $instruktur = BookingGym::find($id);
        if(is_null($instruktur)){
            return response([
                'message' => 'Instruktur Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'status_hadir'=>'required',
        ]);

        if($validate->fails())
            return response(['message' => $validate->error()], 400);

        $instruktur->status_hadir = $updateData['status_hadir'];

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