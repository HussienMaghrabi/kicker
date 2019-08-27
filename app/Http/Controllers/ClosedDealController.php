<?php

namespace App\Http\Controllers;

use App\ClosedDeal;
use App\DealAgents;
use App\Property;
use App\Proposal;
use App\RentalUnit;
use App\ResaleUnit;
use App\Land;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;

class ClosedDealController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(function ($request, $next) {
    //         if (checkRole('deals') or @auth()->user()->type == 'admin') {
    //             return $next($request);
    //         } else {
    //             session()->flash('error', __('admin.you_dont_have_permission'));
    //             return back();
    //         }
    //     });
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deals = ClosedDeal::get();
        return view('admin.deals.index_new', ['title' => trans('admin.all_deals'), 'deals' => $deals]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.deals.create_new', ['title' => trans('admin.add_deal')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $rules = [
            'proposal_id' => 'required',
            'price' => 'required',
            'agent_commission' => 'required',
            'company_commission' => 'required',
            //            'broker_commission' => 'required',
            'seller_id' => 'required',
            'buyer_id' => 'required',
            'description' => 'required',
            'agent_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'proposal_id' => trans('admin.proposal'),
            'price' => trans('admin.price'),
            'agent_commission' => trans('admin.agent_commission'),
            'company_commission' => trans('admin.company_commission'),
            'broker_commission' => trans('admin.broker_commission'),
            'seller_id' => trans('admin.seller'),
            'buyer_id' => trans('admin.buyer'),
            'description' => trans('admin.description'),
        ]);
        if ($validator->fails()) {
            return response()->json(['data'=>'validation error']);
            // return back()->withInput()->withErrors($validator);
        } else {
            // return response()->json(['data'=>'skape validation']);
            $deal = new ClosedDeal;
            $deal->proposal_id = $request->proposal_id;
            $deal->price = $request->price;
            $deal->agent_commission = $request->agent_commission;
            $deal->company_commission = $request->company_commission;
            $deal->broker_commission = $request->broker_commission;
            $deal->seller_id = $request->seller_id;
            $deal->buyer_id = $request->buyer_id;
            $deal->agent_id = $request->agent_id;
            $deal->description = $request->description;
            $deal->agent_payment_status = 'pending';
            $deal->user_id = auth()->user()->id;
            $deal->save();

            if ($request->has('other_agent')) {
                for ($i = 0; $i < count($request->other_agent); $i++) {
                    $agents = new DealAgents;
                    $agents->agent_id = $request->other_agent[$i];
                    $agents->agent_commission = $request->other_agent_commission[$i];
                    $agents->agent_payment_status = 'pending';
                    $agents->deal_id = $deal->id;
                    $agents->save();
                }
            }

            $proposal = Proposal::find($deal->proposal_id);
            if ($proposal->unit_type == 'resale') {
                $unit = ResaleUnit::find($proposal->unit_id);
                $unit->lead_id = $proposal->lead_id;
                $unit->availability = 'sold';
                $unit->save();
            } elseif ($proposal->unit_type == 'rental') {
                $unit = RentalUnit::find($proposal->unit_id);
                $unit->lead_id = $proposal->lead_id;
                $unit->availability = 'sold';
                $unit->save();
            } elseif ($proposal->unit_type == 'new_home') {
                $unit = Property::find($proposal->unit_id);
                $unit->availability = 'sold';
                $unit->save();
            } elseif ($proposal->unit_type == 'land') {
                $unit = Land::find($proposal->unit_id);
                $unit->availability = 'sold';
                $unit->save();
            }
            session()->flash('success', trans('admin.created'));

            $old_data = json_encode($deal);
            LogController::add_log(
                __('admin.created', [], 'ar') . ' ' . __('admin.deal', [], 'ar'),
                __('admin.created', [], 'en') . ' ' . __('admin.deal', [], 'en'),
                'deals',
                $deal->id,
                'create',
                auth()->user()->id,
                $old_data
            );

            // return redirect(adminPath() . '/deals/' . $deal->id);
            return "done";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClosedDeal $closedDeal
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $closedDeal =  DB::table('closed_deals as deal')
            ->leftjoin('leads as seller', 'deal.seller_id', '=', 'seller.id')
            ->leftjoin('leads as buyer', 'deal.buyer_id', '=', 'buyer.id')
            ->leftjoin('proposals as proposal', 'deal.proposal_id', '=', 'proposal.id')
            ->leftjoin('properties as property', 'proposal.unit_id', '=', 'property.id')
            ->leftjoin('resale_units as resale', 'proposal.unit_id', '=', 'resale.id')
            ->leftjoin('rental_units as rental', 'proposal.unit_id', '=', 'rental.id')
            ->leftjoin('users as user', 'deal.agent_id', '=', 'user.id')
            ->select(
                'proposal.unit_type',
                'deal.id',
                'seller.first_name as seller_first_name',
                'seller.last_name as seller_last_name',
                'buyer.first_name as buyer_first_name',
                'buyer.last_name as buyer_last_name',
                'deal.price',
                'deal.proposal_id',
                'property.' . app()->getLocale() . '_name as property_name',
                'resale.' . app()->getLocale() . '_title as resale_title',
                'rental.' . app()->getLocale() . '_title as rental_title',
                'user.name as user_name',
                'deal.agent_commission',
                'deal.company_commission',
                'deal.description',
                'property.en_name as unit',
                'proposal.personal_commercial'
            )->where('deal.id', '=', $id)
            ->first();

        
        return response()->json($closedDeal);
        // return view('admin.deals.show_new', ['title' => trans('admin.deal'), 'deal' => $closedDeal]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClosedDeal $closedDeal
     * @return \Illuminate\Http\Response
     */
    public function edit(ClosedDeal $closedDeal)
    {
        return view('admin.deals.edit', ['title' => trans('admin.deal'), 'deal' => $closedDeal]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\ClosedDeal $closedDeal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClosedDeal $closedDeal)
    {
        $rules = [
            'proposal_id' => 'required',
            'price' => 'required',
            'agent_commission' => 'required',
            'company_commission' => 'required',
            //            'broker_commission' => 'required',
            'seller_id' => 'required',
            'buyer_id' => 'required',
            'description' => 'required',
            'agent_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'proposal_id' => trans('admin.proposal'),
            'price' => trans('admin.price'),
            'agent_commission' => trans('admin.agent_commission'),
            'company_commission' => trans('admin.company_commission'),
            'broker_commission' => trans('admin.broker_commission'),
            'seller_id' => trans('admin.seller'),
            'buyer_id' => trans('admin.buyer'),
            'description' => trans('admin.description'),
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $closedDeal->proposal_id = $request->proposal_id;
            $closedDeal->price = $request->price;
            $closedDeal->agent_commission = $request->agent_commission;
            $closedDeal->company_commission = $request->company_commission;
            $closedDeal->broker_commission = $request->broker_commission;
            $closedDeal->seller_id = $request->seller_id;
            $closedDeal->buyer_id = $request->buyer_id;
            $closedDeal->agent_id = $request->agent_id;
            $closedDeal->description = $request->description;
            $closedDeal->user_id = auth()->user()->id;
            $closedDeal->save();
            session()->flash('success', trans('admin.created'));
            return redirect(adminPath() . '/deals/' . $closedDeal->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClosedDeal $closedDeal
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $closedDeal = ClosedDeal::find($id);
        $closedDeal->delete();
        session()->flash('success', trans('admin.deleted'));

        $old_data = json_encode($closedDeal);
        LogController::add_log(
            __('admin.created', [], 'ar') . ' ' . __('admin.deal', [], 'ar'),
            __('admin.created', [], 'en') . ' ' . __('admin.deal', [], 'en'),
            'deals',
            $closedDeal->id,
            'create',
            auth()->user()->id,
            $old_data
        );
        return 'done';

        // return redirect(adminPath() . '/deals');
    }

    public function main_payed($id)
    {
        $deal = ClosedDeal::find($id);
        $deal->agent_payment_status = 'payed';
        $deal->save();
        session()->flash('redirect_back', 'finance');
        session()->flash('success', trans('admin.payed'));
        return back();
    }

    public function sub_payed($id)
    {
        $deal = DealAgents::find($id);
        $deal->agent_payment_status = 'payed';
        $deal->save();
        session()->flash('redirect_back', 'finance');
        session()->flash('success', trans('admin.payed'));
        return back();
    }

    public function getAllDealsWithPaginate(Request $request)
    {
        $deals = DB::table('closed_deals as deals')
            ->leftjoin('leads as seller', 'deals.seller_id', '=', 'seller.id')
            ->leftjoin('leads as buyer', 'deals.buyer_id', '=', 'buyer.id')
            ->leftjoin('proposals as proposal', 'deals.proposal_id', '=', 'proposal.id')
            ->select(
                'proposal.unit_type',
                'deals.id',
                'seller.first_name as seller_first_name',
                'seller.last_name as seller_last_name',
                'buyer.first_name as buyer_first_name',
                'buyer.last_name as buyer_last_name'
            )->paginate(10);
        return $deals;
    }
}
