<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Visitor;
use Devrabiul\ToastMagic\Facades\ToastMagic;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        $query = Visitor::query()->with(['idCardImage', 'visits']);

        if ($search = $request->input('search')) {
            $query->where('full_name', 'like', "%$search%")
                ->orWhere('identity_number', 'like', "%$search%")
                ->orWhere('phone_number', 'like', "%$search%");
        }

        $visitors = $query->paginate(10);

        return view('adminpage.visitors.index', compact('visitors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $visitor = Visitor::findOrFail($id);

        $visitor->delete();

        ToastMagic::success("Data pengunjung berhasil dihapus!");
        return redirect()->route('adminpage.visitor.index');
    }
}
