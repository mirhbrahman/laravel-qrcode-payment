<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Repositories\AccountRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Auth;
use Carbon\Carbon;
use App\Models\Account as AccountModel;
use App\Models\AccountHistory as AccountHistoryModel;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AccountController extends AppBaseController
{
    /** @var  AccountRepository */
    private $accountRepository;

    public function __construct(AccountRepository $accountRepo)
    {
        $this->middleware('checkmoderator')->only(['create','store']);
        $this->accountRepository = $accountRepo;
    }

    /**
     * Display a listing of the Account.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->role_id < 3){
            $this->accountRepository->pushCriteria(new RequestCriteria($request));
            $accounts = $this->accountRepository->all();
        }else{
            $accounts = AccountModel::where('user_id', Auth::user()->id)->get();
        }

        return view('accounts.index')
            ->with('accounts', $accounts);
    }

    public function apply_for_payout(Request $request){
        $id = $request->apply_for_payout;
        $account = $this->accountRepository->findWithoutFail($id);

        if (empty($account)) {
            Flash::error('Account not found');

            return redirect(route('accounts.index'));
        }

        if (Auth::user()->id != $account->user_id) {
            Flash::error('You cannot perform this operation');

            return redirect(route('accounts.index'));
        }

        AccountModel::where('id', $account->id)->update([
            'applied_for_payout' => 1,
            'paid' => 0,
            'last_date_applied' => Carbon::now()->toDateTimeString(),
        ]);

        AccountHistoryModel::create([
            'user_id' => Auth::user()->id,
            'account_id' => $account->id,
            'message' => 'Payout request initiated by account owner',
        ]);

        Flash::success('Application successfull');

        return redirect()->back();
    }

    public function mark_as_paid(Request $request){
        $id = $request->mark_as_paid;
        $account = $this->accountRepository->findWithoutFail($id);

        if (empty($account)) {
            Flash::error('Account not found');

            return redirect(route('accounts.index'));
        }

        if (Auth::user()->role_id > 2) {
            Flash::error('You cannot perform this operation');

            return redirect(route('accounts.index'));
        }

        AccountModel::where('id', $account->id)->update([
            'applied_for_payout' => 0,
            'paid' => 1,
            'last_date_paid' => Carbon::now()->toDateTimeString(),
        ]);

        AccountHistoryModel::create([
            'user_id' => $account->user_id,
            'account_id' => $account->id,
            'message' => 'Payment completed by admin:'.Auth::user()->id,
        ]);

        Flash::success('Mark as paid Successfull');

        return redirect()->back();
    }

    /**
     * Show the form for creating a new Account.
     *
     * @return Response
     */
    public function create()
    {
        return view('accounts.create');
    }

    /**
     * Store a newly created Account in storage.
     *
     * @param CreateAccountRequest $request
     *
     * @return Response
     */
    public function store(CreateAccountRequest $request)
    {
        $input = $request->all();

        $account = $this->accountRepository->create($input);

        Flash::success('Account saved successfully.');

        return redirect(route('accounts.index'));
    }

    /**
     * Display the specified Account.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(Auth::user()->role_id < 3){
            $account = $this->accountRepository->findWithoutFail($id);
        }else{
            $account = AccountModel::where('user_id', Auth::user()->id)->first();
        }
        

        if (empty($account)) {
            Flash::error('Account not found');

            return redirect(route('accounts.index'));
        }

        return view('accounts.show')
        ->with('account', $account)
        ->with('accountHistories', $account->account_histories);
    }

    /**
     * Show the form for editing the specified Account.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $account = $this->accountRepository->findWithoutFail($id);

        if (empty($account)) {
            Flash::error('Account not found');

            return redirect(route('accounts.index'));
        }

        return view('accounts.edit')->with('account', $account);
    }

    /**
     * Update the specified Account in storage.
     *
     * @param  int              $id
     * @param UpdateAccountRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAccountRequest $request)
    {
        $account = $this->accountRepository->findWithoutFail($id);

        if (empty($account)) {
            Flash::error('Account not found');

            return redirect(route('accounts.index'));
        }

        $account = $this->accountRepository->update($request->all(), $id);

        Flash::success('Account updated successfully.');

        return redirect(route('accounts.index'));
    }

    /**
     * Remove the specified Account from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $account = $this->accountRepository->findWithoutFail($id);

        if (empty($account)) {
            Flash::error('Account not found');

            return redirect(route('accounts.index'));
        }

        $this->accountRepository->delete($id);

        Flash::success('Account deleted successfully.');

        return redirect(route('accounts.index'));
    }
}
