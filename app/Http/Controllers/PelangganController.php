<?php
namespace App\Http\Controllers;

use App\Models\MultipleUpload;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PelangganController extends Controller
{
    # =========================================
    #                INDEX
    # =========================================
    public function index(Request $request)
    {
        $filterableColumns = ['gender'];
        $searchableColumns = ['first_name'];

        $data['dataPelanggan'] = Pelanggan::filter($request, $filterableColumns)
            ->search($request, $searchableColumns)
            ->paginate(10)
            ->withQueryString();

        return view('admin.pelanggan.index', $data);
    }

    # =========================================
    #                CREATE
    # =========================================
    public function create()
    {
        return view('admin.pelanggan.create');
    }

    # =========================================
    #                STORE
    # =========================================
    public function store(Request $request)
    {
        $data = $request->only([
            'first_name', 'last_name', 'birthday',
            'gender', 'email', 'phone',
        ]);

        Pelanggan::create($data);

        return redirect()->route('pelanggan.index')
            ->with('success', 'Penambahan Data Berhasil!');
    }

    # =========================================
    #                SHOW (DETAIL)
    # =========================================
    public function show($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $files = MultipleUpload::where('ref_table', 'pelanggan')
            ->where('ref_id', $id)
            ->get();

        return view('admin.pelanggan.show', compact('pelanggan', 'files'));
    }

    # =========================================
    #                EDIT
    # =========================================
    public function edit($id)
    {
        $data['dataPelanggan'] = Pelanggan::findOrFail($id);
        return view('admin.pelanggan.edit', $data);
    }

    # =========================================
    #                UPDATE
    # =========================================
    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $pelanggan->update($request->only([
            'first_name', 'last_name', 'birthday',
            'gender', 'email', 'phone',
        ]));

        return redirect()->route('pelanggan.index')
            ->with('success', 'Perubahan Data Berhasil!');
    }

    # =========================================
    #                DELETE
    # =========================================
    public function destroy($id)
    {
        Pelanggan::findOrFail($id)->delete();

        return redirect()->route('pelanggan.index')
            ->with('success', 'Data berhasil dihapus');
    }

    # =========================================
    #        HANDLE MULTIPLE UPLOAD FILES
    # =========================================
    public function handleFiles(Request $request, $id)
    {

        $request->validate([
            'files'   => 'required',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        foreach ($request->file('files') as $file) {

            // Simpan ke folder storage/app/public/multipleuploads/
            $path = $file->store('multipleuploads', 'public');

            MultipleUpload::create([
                'filename'  => $path,
                'ref_table' => 'pelanggan',
                'ref_id'    => $id,
            ]);
        }

        return back()->with('success', 'File berhasil diupload!');
    }

    # =========================================
    #             DELETE ONE FILE
    # =========================================
    public function deleteFile($fileId)
    {
        $file = MultipleUpload::findOrFail($fileId);

        if (Storage::disk('public')->exists($file->filename)) {
            Storage::disk('public')->delete($file->filename);
        }

        $file->delete();

        return back()->with('success', 'File berhasil dihapus!');
    }
}
