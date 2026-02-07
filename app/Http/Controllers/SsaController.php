<?php

namespace App\Http\Controllers;

use App\Models\Ssa; 
use App\Models\SsaItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

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
        $ssas = Ssa::when($selectedVessel, fn($q) => $q->where('vessel', $selectedVessel))
            ->latest()->get();

        return view('ssa.request.index', compact('ssas', 'selectedVessel'))->with('vessels', $this->vessels);
    }

    public function verifyIndex(Request $request)
    {
        $selectedVessel = $request->get('vessel');
        $status = $request->get('status','OPEN');

        $ssas = Ssa::when($selectedVessel, fn($q) => $q->where('vessel', $selectedVessel))
            ->when($status, fn($q) => $q->where('status', strtoupper($status)))
            ->latest()->get();

        return view('ssa.verify.index', compact('ssas', 'selectedVessel'))->with('vessels', $this->vessels);
    }

    public function approveIndex(Request $request)
    {
        $selectedVessel = $request->get('vessel');
        $status = $request->get('status','OPEN');

        $ssas = Ssa::when($selectedVessel, fn($q) => $q->where('vessel', $selectedVessel))
            ->when($status, fn($q) => $q->where('status', strtoupper($status)))
            ->where('verified_status','VERIFIED')
            ->latest()->get();

        return view('ssa.approve.index', compact('ssas', 'selectedVessel'))->with('vessels', $this->vessels);
    }

    public function proIndex(Request $request)
    {
        $selectedVessel = $request->get('vessel');
        $status = $request->get('status','OPEN');

        $ssas = Ssa::when($selectedVessel, fn($q) => $q->where('vessel', $selectedVessel))
            ->when($status, fn($q) => $q->where('status', strtoupper($status)))
            ->where('verified_status','VERIFIED')
            ->where('approved_status','APPROVED')
            ->latest()->get();

        return view('pro.ssa.index', compact('ssas', 'selectedVessel'))->with('vessels', $this->vessels);
    }

    public function create(Request $request)
    {
        $selectedVessel = $request->query('vessel', null);
        return view('ssa.request.create', compact('selectedVessel'))->with('vessels', $this->vessels);
    }

    public function reportIndex(Request $request)
    {
        $selectedVessel = $request->get('vessel');
        $ssas = Ssa::when($selectedVessel, fn($q) => $q->where('vessel', $selectedVessel))
            ->latest()->get();

        return view('ssa.report.index', compact('ssas', 'selectedVessel'))->with('vessels', $this->vessels);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ssa_no' => 'required|string|max:50',
            'location' => 'required|string|max:255',
            'vessel' => 'required|string|max:50',
            'ssa_date' => 'required|date',
            'department' => 'required|string|max:50',
            'ssa_raised' => 'required|string|max:50',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'items' => 'nullable|array',
            'items.*.description' => 'nullable|string|max:255',
            'items.*.model_no' => 'nullable|string|max:50',
            'items.*.remedial' => 'nullable|string|max:255',
            'items.*.assistance' => 'nullable|string|max:255',
            'items.*.remark' => 'nullable|string|max:500',
        ]);

        if($request->hasFile('attachment')){
            $file = $request->file('attachment');
            $filename = date('Ymd_His').'_'.$file->getClientOriginalName();
            $destination = public_path('uploads/attachments');
            if(!file_exists($destination)) mkdir($destination, 0777, true);
            $file->move($destination, $filename);
            $validated['attachment'] = 'uploads/attachments/'.$filename;
        }

        $ssa = Ssa::create([
            'ssa_no'=>$validated['ssa_no'],
            'location'=>$validated['location'],
            'vessel'=>$validated['vessel'],
            'date'=>$validated['ssa_date'],
            'department'=>$validated['department'],
            'ssa_raised' => $validated['ssa_raised'],
            'doc_url'=>$validated['attachment'] ?? null,
            'status'=>'OPEN',
            'verified_status'=>'PENDING',
            'approved_status'=>'PENDING',
            'pro_status'=>'PENDING',
            'created_by'=>Auth::id(),
        ]);

        if(!empty($validated['items'])){
            foreach($validated['items'] as $item){
                $ssa->ssa_items()->create([
                    'description'=>$item['description'] ?? null,
                    'model_no'=>$item['model_no'] ?? null,
                    'remedial'=>$item['remedial'] ?? null,
                    'assistance'=>$item['assistance'] ?? null,
                    'remark'=>$item['remark'] ?? null,
                    'status'=>'OPEN'
                ]);
            }
        }

        return redirect()->route('ssa.request.index')->with('success','SSA created successfully.');
    }

    public function show(Ssa $ssa)
    {
        $ssa_items = $ssa->ssa_items()->get();
        return view('ssa.request.show', compact('ssa','ssa_items'));
    }

    public function edit(Ssa $ssa)
    {
        $ssa_items = $ssa->ssa_items()->get();
        return view('ssa.request.edit', compact('ssa','ssa_items'))->with('vessels', $this->vessels);
    }

    public function update(Request $request, Ssa $ssa)
    {
        $validated = $request->validate([
            'ssa_no' => 'required|string|max:50',
            'location' => 'required|string|max:255',
            'vessel' => 'required|string|max:50',
            'ssa_date' => 'required|date',
            'department' => 'required|string|max:50',
            'ssa_raised' => 'required|string|max:50',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'items' => 'nullable|array',
            'items.*.description' => 'nullable|string|max:255',
            'items.*.model_no' => 'nullable|string|max:50',
            'items.*.remedial' => 'nullable|string|max:255',
            'items.*.assistance' => 'nullable|string|max:255',
            'items.*.remark' => 'nullable|string|max:500',
        ]);

        if($request->hasFile('attachment')){
            if($ssa->doc_url && file_exists(public_path($ssa->doc_url))){
                unlink(public_path($ssa->doc_url));
            }

            $file = $request->file('attachment');
            $filename = date('Ymd_His').'_'.$file->getClientOriginalName();
            $destination = public_path('uploads/attachments');
            if(!file_exists($destination)) mkdir($destination, 0777, true);
            $file->move($destination, $filename);
            $validated['attachment'] = 'uploads/attachments/'.$filename;
        }

        $ssa->update([
            'ssa_no'=>$validated['ssa_no'],
            'location'=>$validated['location'],
            'vessel'=>$validated['vessel'],
            'date'=>$validated['ssa_date'],
            'department'=>$validated['department'],
            'ssa_raised' => $validated['ssa_raised'],
            'doc_url'=>$validated['attachment'] ?? $ssa->doc_url,
        ]);

        $ssa->ssa_items()->delete();
        if(!empty($validated['items'])){
            foreach($validated['items'] as $item){
                $ssa->ssa_items()->create([
                    'description'=>$item['description'] ?? null,
                    'model_no'=>$item['model_no'] ?? null,
                    'remedial'=>$item['remedial'] ?? null,
                    'assistance'=>$item['assistance'] ?? null,
                    'remark'=>$item['remark'] ?? null,
                    'status'=>'OPEN'
                ]);
            }
        }

        return redirect()->route('ssa.request.index')->with('success','SSA updated successfully.');
    }

    public function verifyUpdate(Request $request, Ssa $ssa)
    {
        $request->validate([
            'items.*.quantity_req' => 'nullable|numeric|min:0',
            'items.*.balance' => 'nullable|numeric|min:0',
            'items.*.quantity_app' => 'nullable|numeric|min:0',
            'verified_status'=>'nullable|in:PENDING,VERIFIED',
            'verified_remark'=>'nullable|string',
        ]);

        if($request->has('items')){
            foreach($request->items as $id=>$itemData){
                SsaItem::where('id',$id)->update([
                    'quantity_req'=>$itemData['quantity_req'] ?? 0,
                    'balance'=>$itemData['balance'] ?? 0,
                    'quantity_app'=>$itemData['quantity_app'] ?? 0,
                ]);
            }
        }

        $ssa->update([
            'verified_status'=>$request->verified_status,
            'verified_remark'=>$request->verified_remark,
            'verified_by'=>Auth::id(),
            'verified_at'=>now()
        ]);

        return redirect()->route('ssa.verify.index')->with('success','SSA verified successfully!');
    }

    public function approveUpdate(Request $request, Ssa $ssa)
    {
        $request->validate([
            'approved_status'=>'nullable|in:PENDING,APPROVED',
            'approved_remark'=>'nullable|string'
        ]);

        $ssa->update([
            'approved_status'=>$request->approved_status,
            'approved_remark'=>$request->approved_remark,
            'approved_by'=>Auth::id(),
            'approved_at'=>now()
        ]);

        return redirect()->route('ssa.approve.index')->with('success','SSA approved successfully!');
    }

    public function proUpdate(Request $request, Ssa $ssa)
    {
        $request->validate([
            'pro_status'=>'nullable|in:PENDING,APPROVED',
            'pro_remark'=>'nullable|string'
        ]);

        $ssa->update([
            'pro_status'=>$request->pro_status,
            'pro_remark'=>$request->pro_remark,
            'pro_by'=>Auth::id(),
            'pro_at'=>now()
        ]);

        return redirect()->route('pro.ssa.index')->with('success','SSA PRO approved successfully!');
    }

    public function destroy(Ssa $ssa)
    {
        $ssa->deleted_by = Auth::id();
        $ssa->save();
        $ssa->delete();

        return redirect()->route('ssa.request.index')->with('success','SSA deleted successfully.');
    }

    public function exportReport(Ssa $ssa)
    {
        $pdf = Pdf::loadView('ssa.report.report', compact('ssa'))->setPaper('a4','portrait');
        $filename = 'SSA_'.$ssa->ssa_no.'.pdf';
        return $pdf->download($filename);
    }

    public function exportSummary(Request $request)
    {
        $vessel = $request->get('vessel');
        $year = $request->get('year');

        $ssas = Ssa::with('ssa_items')
            ->when($vessel, fn($q) => $q->where('vessel',$vessel))
            ->when($year, fn($q) => $q->whereYear('date',$year))
            ->get();

        $pdf = Pdf::loadView('ssa.report.summary', compact('ssas','vessel','year'))->setPaper('a4','landscape');
        $filename = 'SSA_Summary_'.($vessel??'All').'_'.($year??now()->year).'.pdf';
        return $pdf->download($filename);
    }
}
