<?php

namespace App\Http\Controllers;

use App\Models\Ssa; 
use App\Models\SsaItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SsaController extends Controller
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

    public function index(Request $request)
    {
        $selectedVessel = $request->get('vessel');

        $ssas = Ssa::when($selectedVessel, function ($query) use ($selectedVessel) {
            $query->where('vessel', $selectedVessel);
        })->latest()->get();

        return view('ssa.request.index', [
            'ssas' => $ssas,
            'vessels' => $this->vessels,
            'selectedVessel' => $selectedVessel,
        ]);
    }

    public function verifyIndex(Request $request)
    {
        $selectedVessel = $request->get('vessel');
        $status = $request->get('status','OPEN');

        $ssas = Ssa::when($selectedVessel, fn($q) => $q->where('vessel', $selectedVessel))
            ->when($status, fn($q) => $q->where('status', strtoupper($status)))
            ->latest()
            ->get();

        return view('ssa.verify.index', [
            'ssas' => $ssas,
            'vessels' => $this->vessels,
            'selectedVessel' => $selectedVessel,
        ]);
    }

    public function approveIndex(Request $request)
    {
        $selectedVessel = $request->get('vessel');
        $status = $request->get('status','OPEN');

        $ssas = Ssa::when($selectedVessel, fn($q) => $q->where('vessel', $selectedVessel))
            ->when($status, fn($q) => $q->where('status', strtoupper($status)))
            ->where('verified_status','VERIFIED')
            ->latest()
            ->get();

        return view('ssa.approve.index', [
            'ssas' => $ssas,
            'vessels' => $this->vessels,
            'selectedVessel' => $selectedVessel,
        ]);
    }

    public function proIndex(Request $request)
    {
        $selectedVessel = $request->get('vessel');
        $status = $request->get('status','OPEN');

        $ssas = Ssa::when($selectedVessel, fn($q) => $q->where('vessel', $selectedVessel))
            ->when($status, fn($q) => $q->where('status', strtoupper($status)))
            ->where('verified_status','VERIFIED')
            ->where('approved_status', 'APPROVED')
            ->latest()
            ->get();

        return view('pro.ssa.index', [
            'ssas' => $ssas,
            'vessels' => $this->vessels,
            'selectedVessel' => $selectedVessel,
        ]);
    }

    public function create(Request $request)
    {
        $selectedVessel = $request->query('vessel', null);

        return view('ssa.request.create', [
            'vessels'=>$this->vessels,
            'selectedVessel'=>$selectedVessel
        ]);
    }

    public function reportIndex(Request $request)
    {
        $selectedVessel = $request->get('vessel');

        $ssas = Ssa::when($selectedVessel, fn($q) => $q->where('vessel', $selectedVessel))
            ->latest()
            ->get();

        return view('ssa.report.index', [
            'ssas' => $ssas,
            'vessels' => $this->vessels,
            'selectedVessel' => $selectedVessel,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ssa_no' => 'required|string|max:50',
            'location' => 'required|string|max:255',
            'vessel' => 'required|string|max:50',
            'ssa_date' => 'required|date',
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

        if($request->hasFile('attachment')){
            $file = $request->file('attachment');
            $originalName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
            $filename = date('Ymd_His') . '_' . $originalName;
            $destination = public_path('uploads/attachments');

            if (!file_exists($destination)) mkdir($destination, 0777, true);

            $file->move($destination, $filename);
            $validated['attachment'] = 'uploads/attachments/' . $filename;
        }

        $ssa = Ssa::create([
            'ssa_no' => $validated['ssa_no'],
            'location' => $validated['location'],
            'vessel' => $validated['vessel'],
            'date' => $validated['ssa_date'],
            'department' => $validated['department'],
            'item' => $validated['item'],
            'doc_url' => $validated['attachment'] ?? null,
            'status'=>'OPEN',
            'verified_status'=>'PENDING',
            'approved_status'=>'PENDING',
            'pro_status'=>'PENDING',
            'requested_by'=>auth()->id(),
        ]);

        if($request->filled('items')){
            foreach($request->items as $item){
                SsaItem::create([
                    'ssa_id'=>$ssa->id,
                    'description'=>$item['description'] ?? null,
                    'unit'=>$item['unit'] ?? null,
                    'quantity_req'=>$item['qty_required'] ?? 0,
                    'balance'=>$item['balance'] ?? 0,
                    'quantity_app'=>$item['qty_approved'] ?? 0,
                    'impa_code'=>$item['impa'] ?? null,
                    'remark'=>$item['remarks'] ?? null,
                ]);
            }
        }

        return redirect()->route('ssa.request.index')->with('success','SSA created successfully.');
    }

    public function show(Ssa $ssa)
    {
        $ssa_items = SsaItem::where('ssa_id',$ssa->id)->get();
        return view('ssa.request.show', compact('ssa','ssa_items'));
    }

    public function edit(Ssa $ssa)
    {
        $ssa_items = SsaItem::where('ssa_id',$ssa->id)->get();
        return view('ssa.request.edit', [
            'ssa'=>$ssa,
            'ssa_items'=>$ssa_items,
            'vessels'=>$this->vessels
        ]);
    }

    //update
    public function update(Request $request, Ssa $ssa)
    {
        $validated = $request->validate([
            'ssa_no' => 'required|string|max:50',
            'location' => 'required|string|max:255',
            'vessel' => 'required|string|max:50',
            'ssa_date' => 'required|date',
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

        if($request->hasFile('attachment')){
            if($ssa->doc_url && file_exists(public_path($ssa->doc_url))){
                unlink(public_path($ssa->doc_url));
            }

            $file = $request->file('attachment');
            $originalName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
            $filename = date('Ymd_His') . '_' . $originalName;
            $destination = public_path('uploads/attachments');

            if (!file_exists($destination)) mkdir($destination, 0777, true);

            $file->move($destination, $filename);
            $validated['attachment'] = 'uploads/attachments/' . $filename;
        }

        $ssa->update([
            'ssa_no'=>$validated['ssa_no'],
            'location'=>$validated['location'],
            'vessel'=>$validated['vessel'],
            'date'=>$validated['ssa_date'],
            'department'=>$validated['department'],
            'item'=>$validated['item'],
            'doc_url'=>$validated['attachment'] ?? $ssa->doc_url
        ]);

        $ssa->ssa_items()->delete();
        if(!empty($validated['items'])){
            foreach($validated['items'] as $item){
                $ssa->ssa_items()->create([
                    'description'=>$item['description'],
                    'unit'=>$item['unit'] ?? null,
                    'quantity_req'=>$item['qty_required'] ?? 0,
                    'balance'=>$item['balance'] ?? 0,
                    'quantity_app'=>$item['qty_approved'] ?? 0,
                    'impa_code'=>$item['impa'] ?? null,
                    'remark'=>$item['remarks'] ?? null,
                ]);
            }
        }

        return redirect()->route('ssa.request.index')->with('success','SSA updated successfully.');
    }

    public function destroy(Ssa $ssa)
    {
        //
    }
}
