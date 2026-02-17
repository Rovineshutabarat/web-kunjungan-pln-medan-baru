<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Visit;
use App\Models\Visitor;
use Devrabiul\ToastMagic\Facades\ToastMagic;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        return view("index");
    }

    public function visit()
    {
        return view("visit");
    }

    public function checkStatus(Request $request)
    {
        $visit = null;

        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');

            $visit = Visit::with('visitor')
                ->where('visit_id', $keyword)
                ->first();

            if (!$visit) {
                ToastMagic::error("Data kunjungan tidak dapat ditemukan!");
            }
        }

        return view("check-status", compact('visit'));
    }

    public function createVisit(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'identity_number' => 'required|string|size:16',
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string',
            'id_card_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'visit_date' => 'required|date',
            'check_in' => 'required|date_format:H:i',
            'purpose' => 'required|string',
            'selfie_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $visitor = null;

        $idCardPath = $request->file('id_card_image')->store('id_cards', 'public');

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

        $selfieImage = Image::create([
            'name' => $request->file('selfie_image')->getClientOriginalName(),
            'path' => $request->file('selfie_image')->store('selfies', 'public'),
        ]);

        $visitId = 'KUNJ-' . rand(1000000, 9999999);

        $visit = Visit::create([
            'visitor_id' => $visitor->id,
            'visit_id' => $visitId,
            'visit_date' => $request->visit_date,
            'check_in' => $request->check_in,
            'purpose' => $request->purpose,
            'status' => 'pending',
            'selfie_image_id' => $selfieImage->id,
        ]);

        ToastMagic::success("Berhasil menambahkan data kunjungan!");
        return redirect()->route('visit.success', ['visit_id' => $visit->visit_id])
            ->with('success', 'Kunjungan berhasil didaftarkan!');
    }

    public function showSuccess($visit_id)
    {
        $visit = Visit::with(['visitor', 'selfieImage'])
            ->where('visit_id', $visit_id)
            ->firstOrFail();

        return view('visit-success', compact('visit'));
    }
}
