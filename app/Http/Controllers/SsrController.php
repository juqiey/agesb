<?php

namespace App\Http\Controllers;

use App\Models\Ssr;
use App\Http\Requests\StoreSsrRequest;
use App\Http\Requests\UpdateSsrRequest;
use App\Models\SsrItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class SsrController extends Controller
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

        $ssrs = Ssr::when($selectedVessel, function ($query) use ($selectedVessel) {
            $query->where('vessel', $selectedVessel);
        })
        ->latest()
        ->get();

        return view('ssr.request.index', [
            'ssrs' => $ssrs,
            'vessels' => $this->vessels,
            'selectedVessel' => $selectedVessel,
        ]);
    }

    public function verifyIndex(Request $request)
    {
        $selectedVessel = $request->get('vessel');
        $status = $request->get('status','OPEN');

        $ssrs = Ssr::when($selectedVessel, function ($query) use ($selectedVessel) {
            $query->where('vessel', $selectedVessel);
        })
        ->when($status, function ($query) use ($status) {
            $query->where('status', strtoupper($status));
        })
        ->latest()
        ->get();

        return view('ssr.verify.index', [
            'ssrs' => $ssrs,
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

        return view('ssr.request.create', [
            'vessels'=>$this->vessels,
            'selectedVessel'=>$selectedVessel
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ssr_no' => 'required|string|max:50',
            'location' => 'required|string|max:255',
            'vessel' => 'required|string|max:50',
            'ssr_date' => 'required|date',
            'department' => 'required|string|max:50',
            'item' => 'required|string|max:50',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'items' => 'nullable|array',
            'items.*.description' => 'nullable|string|max:255',
            'items.*.unit' => 'nullable|string|max:50',
            'items.*.qty_required' => 'nullable|numeric',
            'items.*.balance' => 'nullable|numeric',
            'items.*.qty_approved' => 'nullable|numeric',
            'items.*.impa' => 'nullable|string|max:50',
            'items.*.remarks' => 'nullable|string|max:500',
        ]);


            // Attachment upload here
            if($request->hasFile('attachment')){
                $file = $request->file('attachment');
                $originalName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
                $filename = date('Ymd_His') . '_' . $originalName;
                $destination = public_path('uploads/attachments');

                if (!file_exists($destination)) {
                    mkdir($destination, 0777, true);
                }

                $file->move($destination, $filename);

                $validated['attachment'] = 'uploads/attachments/' . $filename;
            }

            // Create SSR
            $ssr = Ssr::create([
                'ssr_no' => $validated['ssr_no'],
                'location' => $validated['location'],
                'vessel' => $validated['vessel'],
                'date' => $validated['ssr_date'],
                'department' => $validated['department'],
                'item' => $validated['item'],
                'doc_url' => $validated['attachment'] ?? null,
                'status'=>'OPEN',
                'verified_status'=>'PENDING',
                'approved_status'=>'PENDING',
                'pro_status'=>'PENDING',
                'requested_by'=>auth()->id(),
            ]);

            //Store SSR items
            if($request->has('items')){
                foreach($request->items as $item){
                    SsrItem::create([
                        'ssr_id'=>$ssr->id,
                        'description'=>$item['description'],
                        'unit'=>$item['unit'] ?? null,
                        'quantity_req'=>$item['quantity'] ?? 0,
                        'balance'=>$item['balance'] ?? 0,
                        'quantity_app'=>$item['qty_approved'] ?? 0,
                        'impa_code'=>$item['impa'] ?? null,
                        'remark'=>$item['remarks'] ?? null,
                    ]);
                }
            }

            return redirect()->route('ssr.request.index')->with('success', 'SSR created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ssr $ssr)
    {
        $ssr_items = SsrItem::where('ssr_id',$ssr->id)->get();

        return view('ssr.request.show', compact('ssr','ssr_items'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ssr $ssr)
    {
        $ssr_items = SsrItem::where('ssr_id', $ssr->id)->get();

        return view('ssr.request.edit',  [
            'ssr' => $ssr,
            'ssr_items' => $ssr_items,
            'vessels' => $this->vessels,]);
    }

    public function verifyEdit(Ssr $ssr)
    {
        $ssr_items = SsrItem::where('ssr_id', $ssr->id)->get();

        return view('ssr.verify.edit',  [
            'ssr' => $ssr,
            'ssr_items' => $ssr_items,
            'vessels' => $this->vessels,]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ssr $ssr)
    {
        $validated = $request->validate([
            'ssr_no' => 'required|string|max:50',
            'location' => 'required|string|max:255',
            'vessel' => 'required|string|max:50',
            'ssr_date' => 'required|date',
            'department' => 'required|string|max:50',
            'item' => 'required|string|max:50',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'items' => 'nullable|array',
            'items.*.description' => 'nullable|string|max:255',
            'items.*.unit' => 'nullable|string|max:50',
            'items.*.qty_required' => 'nullable|numeric',
            'items.*.balance' => 'nullable|numeric',
            'items.*.qty_approved' => 'nullable|numeric',
            'items.*.impa' => 'nullable|string|max:50',
            'items.*.remarks' => 'nullable|string|max:500',
        ]);

        try{
            //Check if the user uploaded new attachment
            if($request->hasFile('attachment')){
                if($ssr->doc_url && file_exists(public_path($ssr->doc_url))){
                    unlink(public_path($ssr->doc_url));
                }

                $file = $request->file('attachment');
                $originalName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
                $filename = date('Ymd_His') . '_' . $originalName;
                $destination = public_path('uploads/attachments');

                if (!file_exists($destination)) {
                    mkdir($destination, 0777, true);
                }

                $file->move($destination, $filename);

                $validated['attachment'] = 'uploads/attachments/' . $filename;
            }

            // Update SSR main data
            $ssr->update([
                'ssr_no' => $validated['ssr_no'],
                'location' => $validated['location'],
                'vessel' => $validated['vessel'],
                'date' => $validated['ssr_date'],
                'department' => $validated['department'],
                'item' => $validated['item'],
                'doc_url' => $validated['attachment'] ?? $ssr->doc_url
            ]);

            // Update SSR items
            $ssr->ssr_items()->delete();

            if (!empty($validated['items'])) {
                foreach ($validated['items'] as $item) {
                    $ssr->ssr_items()->create([
                        'description' => $item['description'],
                        'unit' => $item['unit'] ?? null,
                        'quantity_req' => $item['qty_required'] ?? null,
                        'balance' => $item['balance'] ?? null,
                        'quantity_app' => $item['qty_approved'] ?? null,
                        'impa_code' => $item['impa'] ?? null,
                        'remark' => $item['remarks'] ?? null,
                    ]);
                }
            }

            return redirect()->route('ssr.request.index')->with('success', 'SSR updated successfully.');
        }catch (\Exception $e){
            return redirect()->back()
                ->with('error', 'Failed to update SSR: ' . $e->getMessage())
                ->withInput();
        }

    }

    public function verifyUpdate(Request $request, Ssr $ssr){
        /*dd($request->all());*/

        // Validate inputs
        $request->validate([
            'items.*.qty_required' => 'nullable|integer|min:0',
            'items.*.balance' => 'nullable|integer|min:0',
            'items.*.qty_approved' => 'nullable|integer|min:0',
            'verification_status' => 'nullable|in:PENDING,VERIFIED',
            'verification_remark' => 'nullable|string',
        ]);

            if($request->has('items')){
                foreach ($request->items as $id => $itemData) {
                    SsrItem::where('id', $id)->update([
                        'quantity_req' => $itemData['qty_required'],
                        'balance' => $itemData['balance'],
                        'quantity_app' => $itemData['qty_approved'],
                    ]);
                }
            }

            //Update status for ssr
            $ssr->update([
                'verified_status'=>$request->verification_status,
                'verified_remark'=>$request->verification_remark,
                'verified_by'=>auth()->id(),
                'verified_at'=>now()
            ]);

            return redirect()->route('ssr.verify.index')->with('success','SSR is successfully verified!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ssr $ssr)
    {
        //
    }
}
