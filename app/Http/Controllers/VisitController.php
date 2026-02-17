<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Visit;
use App\Models\Visitor;
use Barryvdh\DomPDF\Facade\Pdf;
use Devrabiul\ToastMagic\Facades\ToastMagic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VisitController extends Controller
{
    public function index(Request $request)
    {
        $query = Visit::with([
            'visitor',
            'visitor.idCardImage',
            'selfieImage'
        ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('purpose', 'like', "%{$search}%")
                    ->orWhereHas('visitor', function ($v) use ($search) {
                        $v->where('full_name', 'like', "%{$search}%")
                            ->orWhere('identity_number', 'like', "%{$search}%")
                            ->orWhere('visit_id', 'like', "%{$search}%")
                            ->orWhere('phone_number', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_filter')) {

            if ($request->date_filter === 'today') {
                $query->whereDate('visit_date', now());
            }

            if ($request->date_filter === 'last7') {
                $query->whereBetween('visit_date', [
                    now()->subDays(7),
                    now()
                ]);
            }
        }

        $visits = $query
            ->latest() // order by created_at desc
            ->paginate(10)
            ->appends($request->query());

        return view("adminpage.visits.index", compact('visits'));
    }




    public function create()
    {
        return view("adminpage.visits.create", [
            "visitors" => Visitor::orderBy('full_name', 'asc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'visitor_type' => 'required|in:new,existing',
            'visit_date' => 'required|date',
            'check_in' => 'required|date_format:H:i',
            'purpose' => 'required|string',
            'selfie_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if ($request->visitor_type === 'existing') {
            $request->validate([
                'existing_visitor_id' => 'required|exists:visitors,id',
            ]);
        } else { // new visitor
            $request->validate([
                'full_name' => 'required|string|max:255',
                'identity_number' => 'required|string|size:16',
                'phone_number' => 'required|string|max:15',
                'address' => 'required|string',
                'id_card_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            ]);
        }

        $visitor = null;

        if ($request->visitor_type === 'existing') {
            $visitor = Visitor::findOrFail($request->existing_visitor_id);
        } else {
            $idCardPath = $request->file('id_card_image')->store('id_cards', 'public');
            $selfiePath = $request->file('selfie_image')->store('selfies', 'public');

            $idCardImage = Image::create([
                'name' => $request->file('id_card_image')->getClientOriginalName(),
                'path' => $idCardPath,
            ]);

            $visitor = Visitor::create([
                'full_name' => $request->full_name,
                'identity_number' => $request->identity_number,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'id_card_image_id' => $idCardImage->id,
            ]);
        }

        // Selfie image untuk kunjungan
        $selfieImage = Image::create([
            'name' => $request->file('selfie_image')->getClientOriginalName(),
            'path' => $request->file('selfie_image')->store('selfies', 'public'),
        ]);

        $visitId = 'KUNJ-' . rand(1000000, 9999999);

        Visit::create([
            'visitor_id' => $visitor->id,
            'visit_id' => $visitId,
            'visit_date' => $request->visit_date,
            'check_in' => $request->check_in,
            'purpose' => $request->purpose,
            'status' => 'pending',
            'selfie_image_id' => $selfieImage->id,
        ]);

        ToastMagic::success("Berhasil menambahkan data kunjungan!");
        return redirect()->route("adminpage.visit.index")->with('success', 'Visit created successfully');
    }


    public function show(string $id)
    {
        $visit = Visit::with('visitor')->findOrFail($id);

        return view("adminpage.visits.show", [
            "visit" => $visit
        ]);
    }

    public function edit(string $id)
    {
        $visit = Visit::findOrFail($id);

        return view("adminpage.visits.edit", [
            "visit" => $visit,
            "visitors" => Visitor::orderBy('full_name', 'asc')->get()
        ]);
    }

    public function update(Request $request, string $id)
    {
        $visit = Visit::findOrFail($id);

        $validated = $request->validate([
            'visit_date' => 'required|date',
            'check_in' => 'required',
            'check_out' => 'nullable',
            'purpose' => 'required|string',
            'status' => 'required|in:checked_in,checked_out,cancelled',
        ]);

        $visit->update($validated);

        return redirect()->route('visits.index')
            ->with('success', 'Data kunjungan berhasil diupdate!');
    }

    public function destroy(string $id)
    {
        $visit = Visit::findOrFail($id);

        $visit->delete();

        ToastMagic::success("Data kujungan berhasil dihapus!");
        return redirect()->route('adminpage.visit.index');
    }

    public function checkout(string $id)
    {
        $visit = Visit::findOrFail($id);

        $visit->update([
            'check_out' => now(),
            'status' => 'complete'
        ]);

        ToastMagic::success("Status kunjungan berhasil diperbaharui!");
        return redirect()->route('adminpage.visit.index');
    }

    public function updateStatus(string $id, Request $request)
    {
        $visit = Visit::findOrFail($id);

        $statusOrder = ['pending', 'accepted', 'in_progress', 'complete', 'cancelled'];

        $currentIndex = array_search($visit->status, $statusOrder);
        $nextIndex = $currentIndex + 1;

        $targetStatus = $request->input('status', 'complete');

        if ($statusOrder[$nextIndex] !== $targetStatus) {
            ToastMagic::error("Status tidak bisa langsung diubah dari {$visit->status} ke {$targetStatus}. Harus berurutan!");
            return redirect()->route('adminpage.visit.index');
        }

        $visit->update([
            'check_in' => $visit->check_in ?? ($targetStatus === 'accepted' ? now() : $visit->check_in),
            'check_out' => $targetStatus === 'complete' ? now() : $visit->check_out,
            'status' => $targetStatus
        ]);

        ToastMagic::success("Status kunjungan berhasil diperbaharui!");
        return redirect()->route('adminpage.visit.index');
    }

    public function exportPdf()
    {
        $visits = Visit::with('visitor')->get();

        $pdf = Pdf::loadView('adminpage.visits.pdf', compact('visits'));

        return $pdf->download('visits.pdf');
    }

    public function exportExcel()
    {
        $fileName = 'orders.csv';
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['ID', 'Nama', 'Nik', 'ID Kunjungan', 'Tujuan', "Tanggal", "Check In", "Check Out", "Status"]);

            $visits = Visit::all();

            foreach ($visits as $visit) {
                fputcsv($file, [
                    $visit->id,
                    $visit->visitor->full_name,
                    $visit->visitor->identity_number,
                    $visit->visit_id,
                    $visit->purpose,
                    $visit->visit_date,
                    $visit->check_in,
                    $visit->check_out,
                    $visit->status,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
