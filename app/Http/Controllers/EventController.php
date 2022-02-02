<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use DB;
class EventController extends Controller
{
    //
    public function store(Request $request) {
        if ($request->input('type') === "deposit"){
            return $this->deposit(
                $request->input('destination'),
                $request->input('amount')
            );
        } else  if ($request->input('type') === 'withdraw') {
           return $this->withdraw (
            $request->input('origin'),
            $request->input('amount')
           ); 
        } else if ($request->input('type') === 'transfer') {
            return $this->transfer(
                $request->input('origin'),
                $request->input('destination'),
                $request->input('amount')
            );
        }
    }

    private function deposit($destination, $amount) {
        $account = Account::firstOrCreate([
            'id' => $destination
        ], 
        [
            'balance' => 0
        ]);

        $account->balance += $amount;
        $account->save();

        return response()->json([
            'destination' => [
                'id' => $account->id,
                'balance' => $account->balance   
            ]
        ], 201);
    }

    private function withdraw ($origin, $amount) {
        $account = Account::findOrFail($origin);

        $account->balance -= $amount;
        $account->save();

        return response()->json([
            'origin' => [
                'id' => $account->id,
                'balance' => $account->balance   
            ]
        ], 201);

    }

    private function transfer ($origin, $destination,$amount) {


        $accountOrigin = Account::findOrFail($origin);

        $accountDestination = Account::firstOrCreate([
            'id' => $destination
        ]);

        DB::transaction(function() use ($accountOrigin,$accountDestination,$amount) {
        

        $accountOrigin->balance -=$amount;
        $accountDestination->balance += $amount;
    
        
        $accountOrigin->save();
        $accountDestination->save();


       
    });
    return response()->json([
        'origin' => [
            'id' => $accountOrigin->id,
            'balance' => $accountOrigin->balance   
        ],
        'destination' => [
            'id' => $accountDestination->id,
            'balance' => $accountDestination->balance   
        ]

    ], 201);

    }
}
