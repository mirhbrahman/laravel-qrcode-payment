<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Paystack;
use Flash;
use App\Models\Qrcode as QrcodeModel;
use App\Models\Transaction as TransactionModel;
use App\Models\Account as AccountModel;
use App\Models\AccountHistory as AccountHistoryModel;
use App\Models\User as UserModel;

class PaymentController extends Controller
{

    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {
        return Paystack::getAuthorizationUrl()->redirectNow();
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();
        $qrocde_id = $paymentDetails['data']['metadata']['qrcode_id'];
        $qrcode = QrcodeModel::where('id', $qrocde_id)->first();

        if($paymentDetails['data']['status'] != 'success'){
            Flash::error('Sorry, Payment failed');
            return redirect()->route('qrcodes.show', $qrocde_id);
        }

        if($paymentDetails['data']['amount']/100 != $qrcode->amount){
            Flash::error('Sorry, You paid wrong amount. Please contact to admin');
            return redirect()->route('qrcodes.show', $qrocde_id);
        }

        $buyer_id = $paymentDetails['data']['metadata']['buyer_user_id'];
        $buyer = UserModel::where('id', $buyer_id)->first();
        // Create Buyer owner transaction
        TransactionModel::create([
            'user_id' => $buyer_id,
            'qrcode_id' => $qrcode->id,
            'qrcode_owner_id' => $qrcode->user_id,
            'payment_method' => 'Paystack/Card',
            'message' => 'Payment Successfull',
            'amount' => $qrcode->amount,
            'status' => 'Completed'
        ]);


        // Update qrcode owner account
        $qrcode_owner_account = AccountModel::where('user_id', $qrcode->user_id)->first();
        AccountModel::where('user_id', $qrcode->user_id)->update([
            'balance' => $qrcode_owner_account->balance + $qrcode->amount,
            'total_credit' => $qrcode_owner_account->total_credit + $qrcode->amount,
        ]);

        
        // Update qrcode owner account history
        AccountHistoryModel::where('user_id', $qrcode->user_id)->update([
            'account_id' => $qrcode_owner_account->id,
            'user_id' => $qrcode_owner_account->user_id,
            'message' => 'Received payment for qrcode: '. $qrcode->id . ' from : ' . $buyer->name
        ]);

        // Update Buyer Account
        $buyer_account = AccountModel::where('user_id', $buyer_id)->first();
        AccountModel::where('user_id', $buyer_id)->update([
            'total_debit' => $buyer_account->total_debit - $qrcode->amount,
        ]);
        // Update Buyer Account history
        AccountHistoryModel::where('user_id', $buyer_id)->update([
            'account_id' => $buyer_account->id,
            'user_id' => $buyer_account->user_id,
            'message' => 'Paid for qrcode: '. $qrcode->id . ' to : ' . $qrcode->user->email 
        ]);

        // dd($paymentDetails);
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
        Flash::success('Payment successfull');
        return redirect()->route('transactions.index');
    }
}