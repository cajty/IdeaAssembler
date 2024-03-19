<?php

namespace App\Http\Controllers;

use App\Models\Componet;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class ComponetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        try{
            $componet = $request->validate([
                'content' => 'required',
            ]);
            
            $componet = Componet::firstOrCreate($componet);

        }catch (QueryException $exception) {

            return response()->json(['error' => $exception->getMessage()], 500); 
        
        }catch (\Throwable $th) {
            return response()->json([
                $componet,
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
       
     
        return response()->json([
            $componet,
        ], 201);
      
     

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Componet $componet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Componet $componet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Componet $componet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Componet $componet)
    {
        //
    }
}
