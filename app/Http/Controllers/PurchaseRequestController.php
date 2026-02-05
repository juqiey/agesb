<?php

namespace App\Http\Controllers;

use App\Models\PrItem;
use App\Models\PurchaseRequest;
use App\Http\Requests\StorePurchaseRequestRequest;
use App\Http\Requests\UpdatePurchaseRequestRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PurchaseRequestController extends Controller
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

        $prs = PurchaseRequest::when($selectedVessel, function ($query) use ($selectedVessel) {
                $query->where('vessel', $selectedVessel);
            })
        ->latest()
        ->get();

        return view('pr.request.index', [
            'prs' => $prs,
            'vessels' => $this->vessels,
            'selectedVessel' => $selectedVessel,
        ]);
    }

    public function confirmIndex(Request $request){
        $selectedVessel = $request->get('vessel');
        $status = $request->get('status','OPEN');

        $prs = PurchaseRequest::when($selectedVessel, function ($query) use ($selectedVessel) {
                $query->where('vessel', $selectedVessel);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', strtoupper($status));
            })
            ->latest()
            ->get();

        return view('pr.confirm.index', [
            'prs' => $prs,
            'vessels' => $this->vessels,
            'selectedVessel' => $selectedVessel,
        ]);
    }

    public function approveIndex(Request $request)
    {
        $selectedVessel = $request->get('vessel');
        $status = $request->get('status','OPEN');

        $prs = PurchaseRequest::when($selectedVessel, function ($query) use ($selectedVessel) {
            $query->where('vessel', $selectedVessel);
        })
            ->when($status, function ($query) use ($status) {
                $query->where('status', strtoupper($status));
            })
            ->where('confirmed_status','CONFIRMED')
            ->latest()
            ->get();

        return view('pr.approve.index', [
            'prs' => $prs,
            'vessels' => $this->vessels,
            'selectedVessel' => $selectedVessel,
        ]);
    }

    public function reportIndex(Request $request){
        $selectedVessel = $request->get('vessel');
        $status = $request->get('status','OPEN');

        $prs = PurchaseRequest::when($selectedVessel, function ($query) use ($selectedVessel) {
            $query->where('vessel', $selectedVessel);
        })
            ->when($status, function ($query) use ($status) {
                $query->where('status', strtoupper($status));
            })
            ->latest()
            ->get();

        return view('pr.report.index', [
            'prs' => $prs,
            'vessels' => $this->vessels,
            'selectedVessel' => $selectedVessel,
        ]);
    }

    public function proIndex(Request $request){
        $selectedVessel = $request->get('vessel');
        $status = $request->get('status','OPEN');

        $prs = PurchaseRequest::when($selectedVessel, function ($query) use ($selectedVessel) {
            $query->where('vessel', $selectedVessel);
        })
            ->when($status, function ($query) use ($status) {
                $query->where('status', strtoupper($status));
            })
            ->where('confirmed_status','CONFIRMED')
            ->where('approved_status', 'APPROVED')
            ->latest()
            ->get();

        return view('pro.pr.index', [
            'prs' => $prs,
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

        return view('pr.request.create', [
            'vessels'=>$this->vessels,
            'selectedVessel'=>$selectedVessel,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category'=>'required|string',
            'category_others' => 'nullable|string',
            'vessel'=>'nullable|string',
            'title'=>'nullable|string',
            'items' => 'nullable|array',
            'items.*.description' => 'nullable|string|max:255',
            'items.*.unit' => 'nullable|string|max:50',
            'items.*.qty' => 'nullable|numeric',
            'items.*.remarks'=>'nullable|string'
        ]);

        $pr_no = PurchaseRequest::generatePRNo($request->vessel);

        $pr = PurchaseRequest::create([
            'item_req' => $request->category === 'Others' ? $request->category_others : $request->category,
            'vessel' => $request->vessel,
            'title'=>$request->title,
            'date'=>now(),
            'confirmed_status'=>'PENDING',
            'approved_status'=>'PENDING',
            'pro_status'=>'PENDING',
            'status'=>'OPEN',
            'requested_by'=> auth()->id(),
            'pr_no'=>$pr_no
        ]);

        if($request->has('items')){
            foreach($request->items as $item){
                PrItem::create([
                    'pr_id'=>$pr->id,
                    'description'=>$item['description'],
                    'unit'=>$item['unit'],
                    'quantity'=>$item['qty'],
                    'remark'=>$item['remarks'],
                    'status'=>'OPEN'
                ]);
            }
        }

        return redirect()->route('pr.request.index')->with('success','Successfully created new PR!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseRequest $pr)
    {
        return view('pr.request.show', compact('pr'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseRequest $pr)
    {
        return view('pr.request.edit', [
            'pr'=>$pr,
            'vessels'=>$this->vessels
        ]);
    }

    public function confirmEdit(PurchaseRequest $pr)
    {
        return view('pr.confirm.edit',[
           'pr'=>$pr,
           'vessels'=>$this->vessels
        ]);
    }

    public function approveEdit(PurchaseRequest $pr){
        return view('pr.approve.edit',[
            'pr'=>$pr,
            'vessels'=>$this->vessels
        ]);
    }

    public function proEdit(PurchaseRequest $pr){
        return view('pro.pr.edit',[
            'pr'=>$pr,
            'vessels'=>$this->vessels
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseRequest $pr)
    {
        $request->validate([
            'title'=>'string|nullable',
            'vessel'=>'string|nullable',
            'category'=>'string|nullable',
            'category_others'=>'string|nullable',
            'items.*.description'=>'string|nullable',
            '$items.*.unit'=>'string|nullable',
            'items.*.quantity'=>'integer|nullable',
            'items.*.remark'=>'string|nullable'
        ]);

        $pr->update([
            'vessel'=>$request->vessel,
            'title'=>$request->title,
            'item_req'=> $request->category === 'Others' ? $request->category_others : $request->category,
        ]);

        //Delete removed items
        if($request->removed_items){
            $ids = explode(',', $request->removed_items);
            PrItem::whereIn('id',$ids)->delete();
        }

        //Update existing items
        foreach($request->items as $item){
            if(!empty($item['id'])){
                PrItem::where('id', $item['id'])->update([
                    'description' => $item['description'],
                    'unit'=>$item['unit'],
                    'quantity' => $item['quantity'],
                    'remark' => $item['remark'],
                ]);
            } else {
                PrItem::create([
                    'pr_id' => $pr->id,
                    'description' => $item['description'],
                    'unit'=>$item['unit'],
                    'quantity' => $item['quantity'],
                    'remark' => $item['remark'],
                ]);
            }
        }

        return redirect()->route('pr.request.index')
            ->with('success', 'Purchase Request updated successfully');
    }

    public function confirmUpdate(Request $request, PurchaseRequest $pr)
    {
        $request->validate([
            'confirmation_status'=>'string|nullable',
        ]);

        $pr->update([
           'confirmed_status'=>$request->confirmation_status,
           'confirmed_by'=>auth()->id(),
            'confirmed_at'=>now()
        ]);

        return redirect()->route('pr.confirm.index')
            ->with('success', 'Purchase Request confirmed successfully');
    }

    public function approveUpdate(Request $request, PurchaseRequest $pr){
        $request->validate([
            'approval_status'=>'string|nullable',
        ]);

        $pr->update([
            'approved_status'=>$request->approval_status,
            'approved_by'=>auth()->id(),
            'approved_at'=>now()
        ]);

        return redirect()->route('pr.approve.index')
            ->with('success', 'Purchase Request confirmed successfully');
    }

    public function proUpdate(Request $request, PurchaseRequest $pr){
        $request->validate([
            'approval_status'=>'string|nullable',
        ]);

        $pr->update([
            'pro_status'=>$request->approval_status,
            'pro_by'=>auth()->id(),
            'pro_at'=>now()
        ]);

        return redirect()->route('pro.pr.index')
            ->with('success', 'Purchase Request confirmed successfully');

        //Check for quantity of item approved
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseRequest $purchaseRequest)
    {
        //
    }

    public function exportReport(PurchaseRequest $pr)
    {
        //Load view and pass SSR + SSR Items data
        $pdf = Pdf::loadView('pr.report.report', compact('pr'))->setPaper('a4', 'portrait');

        $safePrNo = str_replace(['/', '\\'], '_', $pr->pr_no);

        $filename = 'PR_' . $safePrNo . '.pdf';

        return $pdf->download($filename);
    }

    public function exportSummary(Request $request){
        $vessel = $request->get('vessel');
        $year = $request->get('year');

        $prs = PurchaseRequest::with('pr_items')
            ->when($vessel, fn($q) => $q->where('vessel', $vessel))
            ->when($year, fn($q) => $q->whereYear('date', $year))
            ->get();

        $pdf = Pdf::loadView('pr.report.summary', compact('prs', 'vessel', 'year'))
            ->setPaper('a4', 'landscape');

        $filename = 'SSR_Summary_' . ($vessel ?? 'All') . '_' . ($year ?? now()->year) . '.pdf';
        return $pdf->download($filename);
    }
}
