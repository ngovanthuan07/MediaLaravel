<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function updateProfile(Request $request) {
        try {
            $user = Auth::user();

            $user->update([
                'name' => $request['name'],
                'dob' => $request['dob'],
                'gender' => $request['gender'],
                'description' => $request['description'],
                'avatar' => $request['avatar'],
                'background' => $request['background']
            ]);

            return response()->json([
               'user' => $user,
               'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e,
                'success' => false
            ], 404);
        }

    }

    public function search(Request $request) {
        $searchField = $request->input('field');
        $searchTerm = $request->input('searchTerm');

        if ($searchTerm) {
            $users = User::where($searchField, 'like', '%'.$searchTerm.'%')->get();
        } else {
            $users = [];
        }

        return response([
            'users' => $users,
            'success'=> true
        ]);
    }

    public function signUpSeller(Request $request) {
        try {
            $email = $request->input('email');
            $bankAccountHolderName = $request->input('bankAccountHolderName');
            $bankAccountNumber = $request->input('bankAccountNumber');
            $bankIdentifierCode = $request->input('bankIdentifierCode');
            $bankLocation = $request->input('bankLocation');
            $bankCurrency = $request->input('bankCurrency');
            $address = $request->input('address');


            Seller::create([
                'email' => $email,
                'bank_account_holder_name' => $bankAccountHolderName,
                'bank_account_number' => $bankAccountNumber,
                'bank_identifier_code' => $bankIdentifierCode,
                'bank_location' => $bankLocation,
                'bank_currency' => $bankCurrency,
                'address' => $address,
                'user_id' => Auth::user()->id,
            ]);

            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e
            ]);
        }
    }
}
