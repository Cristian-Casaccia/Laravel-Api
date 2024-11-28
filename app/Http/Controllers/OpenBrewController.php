<?php

namespace App\Http\Controllers;

use App\Helper\HelperResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class OpenBrewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        dd($user);
        if (!HelperResponse::TokenIsValid(User::GetToken($user))) {
            dd(HelperResponse::TokenIsValid(User::GetToken($user)), User::GetToken($user), $user);
            return redirect()->route('login');
        }

        return view('home');
    }

    public function GuzzlefetchBreweries(Request $request)
    {
        $client = new Client();
        $response = $client->get($request->url);
        $breweries = json_decode($response->getBody()->getContents(), true);

        $columns = array_keys($breweries[0]);
        $rows = [];

        foreach ($breweries as $brew) {
            $rows[] = array_values($brew);
        }

        return response()->json([
            'columns' => $columns,
            'rows' => $rows
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
