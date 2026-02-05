<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOrder;
use App\Http\Requests\StoreDeliveryOrderRequest;
use App\Http\Requests\UpdateDeliveryOrderRequest;
use App\Models\PrItem;
use App\Models\PurchaseRequest;
use App\Models\Ssr;
use App\Models\SsrItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function React\Promise\all;

class DeliveryOrderController extends Controller
{
    public $positions = [
        "DOCUMENT CONTROLLER",
        "ASSISTANT DOCUMENT CONTROLLER",
        "TECHNICAL SUPERINTENDENT",
        "SENIOR EXECUTIVE TECHNICAL",
        "EXECUTIVE OPERATION",
        "JUNIOR EXECUTIVE TECHNICAL",
        "SENIOR EXECUTIVE CUM HSE",
        "MARINE SUPRINTENDENT",
        "CHIEF EXECUTIVE OFFICER",
        "HOD PROCUREMENT",
        "EXECUTIVE PROCUREMENT"
    ];

    public $vessels = [
        "AA1"=>"AISHAH AIMS 1",
        "AA2"=>"AISHAH AIMS 2",
        "AA3"=>"AISHAH AIMS 3",
        "AA4"=>"AISHAH AIMS 4",
        "AA5"=>"AISHAH AIMS 5",
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $selectedVessel = $request->get('vessel');

        $dos = DeliveryOrder::when($selectedVessel, function ($query) use ($selectedVessel) {
            $query->where('vessel', $selectedVessel);
        })
            ->latest()
            ->get();

        return view('pro.do.index', [
            'dos'=>$dos,
            'vessels' => $this->vessels,
            'selectedVessel' => $selectedVessel,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $selectedVessel = $request->query('vessel', null);

        $prs = PurchaseRequest::where('status','OPEN')
                ->where('confirmed_status','CONFIRMED')
                ->where('approved_status','APPROVED')
                ->where('pro_status', 'APPROVED')
                ->get();

        $ssrs = Ssr::where('status','OPEN')
                ->where('verified_status','VERIFIED')
                ->where('approved_status','APPROVED')
                ->where('pro_status', 'APPROVED')
                ->get();

        return view('pro.do.create', [
            'vessels'=>$this->vessels,
            'selectedVessel'=>$selectedVessel,
            'prs'=>$prs,
            'ssrs'=>$ssrs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'do_no'=>'string|required',
            'do_date'=>'date|required',
            'do_recipient'=>'string|required',
            'job_no'=>'string|required',
            'vessel'=>'string|required',
            'pr_items'=>'array',
            'ssr_items'=>'array',
            'location'=>'string|required'
        ]);

        DB::beginTransaction();

        try{
            $do = DeliveryOrder::create([
                'do_no'=>$request->do_no,
                'date'=>$request->do_date,
                'job_no'=>$request->job_no,
                'vessel'=>$request->vessel,
                'do_recipient'=>$request->do_recipient,
                'location'=>$request->location
            ]);

            $prTotal = 0;
            $ssrTotal = 0;

            if($request->has('pr_items')){
                foreach($request->pr_items as $itemId => $data) {
                    $prItem = PrItem::find($data['item_id']);

                    if($prItem){
                        $prItem->update([
                            'do_id'=>$do->id,
                            'quantity_pro' => $data['qty'],
                            'unit_price'=>$data['unit_price'],
                            'total_price'=>$data['qty'] * $data['unit_price'],
                            'status'=>'CLOSE'
                        ]);

                        $prTotal+=$data['qty'] * $data['unit_price'];
                    }
                }

                //Check to close PR
                $pr = $prItem->purchase_requests;

                if ($pr->pr_items()->where('status', '!=', 'CLOSE')->doesntExist()) {
                    $pr->update(['status' => 'CLOSE']);
                }
            }

            if($request->has('ssr_items')){
                foreach ($request->ssr_items as $itemId => $data) {
                    $ssrItem = SsrItem::find($data['item_id']);

                    if($ssrItem){
                        $ssrItem->update([
                            'do_id'=>$do->id,
                            'quantity_pro' => $data['qty'],
                            'unit_price'=>$data['unit_price'],
                            'total_price'=>$data['qty'] * $data['unit_price'],
                        ]);

                        $ssrTotal += $data['qty'] * $data['unit_price'];
                    }
                }

                //Check to close SSR
                $ssr = $ssrItem->ssr;

                if ($ssr->ssr_items()->where('status', '!=', 'CLOSE')->doesntExist()) {
                    $ssr->update(['status' => 'CLOSE']);
                }
            }

            $total = $ssrTotal + $prTotal;

            $do->update([
                'total'=>$total
            ]);

            DB::commit();

            return redirect()->route('pro.do.index')->with('success', 'Delivery Order created successfully');
        }catch (\Exception $e){
            DB::rollBack();

            \Log::error('DeliveryOrder creation failed: '.$e->getMessage());

            return redirect()->back()->with('error', 'Failed to create Delivery Order!'.$e->getMessage() );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DeliveryOrder $do)
    {
        return view('pro.do.show', compact('do'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeliveryOrder $do)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeliveryOrderRequest $request, DeliveryOrder $deliveryOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeliveryOrder $deliveryOrder)
    {
        //
    }

    public function getPRItems($prId){
        $pr = PurchaseRequest::with([
            'pr_items' => function ($query) {
                $query->whereNull('do_id');
            }
        ])->findOrFail($prId);;

        return response()->json($pr->pr_items);
    }

    public function getSsrItems($ssrId){
        $ssr = SSR::with([
            'ssr_items' => function ($query) {
                $query->whereNull('do_id');
            }
        ])->findOrFail($ssrId);

        return response()->json($ssr->ssr_items);
    }

    public function exportReport(DeliveryOrder $do){
        //Load view and pass DO data
        $pdf = Pdf::loadView('pro.do.report', compact('do'))->setPaper('a4', 'portrait');

        $safePrNo = str_replace(['/', '\\'], '_', $do->do_no);

        $filename = 'DO_' . $safePrNo . '.pdf';

        return $pdf->download($filename);
    }
}
