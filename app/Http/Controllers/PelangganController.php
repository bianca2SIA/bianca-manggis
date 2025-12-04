<?php
namespace App\Http\Controllers;

use App\Models\Multipleupload;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            //Redirect ke halaman login
            return redirect()->route('auth');
        }
        $filterableColumns = ['gender'];
        $searchableColumns = ['first_name', 'last_name', 'email'];

        $data['dataPelanggan'] = Pelanggan::latest()->filter($request, $filterableColumns)
            ->search($request, $searchableColumns)
            ->paginate(10)
            ->onEachSide(2);

        return view('admin.pelanggan.index', $data);
    }

    public function create()
    {
        if (Auth::check()) {
            //Redirect ke halaman login
            return redirect()->route('auth');
        }
        return view('admin.pelanggan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'birthday'   => 'required',
            'gender'     => 'required',
            'email'      => 'required',
            'phone'      => 'required',
            'files.*'    => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        // 1. Simpan data pelanggan dulu
        $pelanggan = Pelanggan::create($request->only([
            'first_name', 'last_name', 'birthday', 'gender', 'email', 'phone',
        ]));

        // 2. Kalau ada file yang diupload dari halaman create
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                if (! $file->isValid()) {
                    continue;
                }

                $filename = round(microtime(true) * 1000) . '-' .
                str_replace(' ', '-', $file->getClientOriginalName());

                $file->move(public_path('uploads/multiple'), $filename);

                Multipleupload::create([
                    'ref_table' => 'pelanggan',
                    'ref_id'    => $pelanggan->pelanggan_id, // pk pelanggan kamu
                    'filename'  => $filename,
                ]);
            }
        }

        return redirect()->route('pelanggan.index')
            ->with('create', 'Penambahan data berhasil!');
    }

    public function show(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $files = Multipleupload::where('ref_table', 'pelanggan')
            ->where('ref_id', $id)
            ->get();

        return view('admin.pelanggan.show', compact('pelanggan', 'files'));
    }

    public function edit(string $id)
    {
        $dataPelanggan = Pelanggan::findOrFail($id);

        $files = Multipleupload::where('ref_table', 'pelanggan')
            ->where('ref_id', $id)
            ->get();

        return view('admin.pelanggan.edit', compact('dataPelanggan', 'files'));

        // $data['dataPelanggan'] = Pelanggan::findOrFail($id);
        // return view('admin.pelanggan.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'birthday'   => 'required',
            'gender'     => 'required',
            'email'      => 'required',
            'phone'      => 'required',
            'files.*'    => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);

        // 1. Update data pelanggan
        $pelanggan->update($request->only([
            'first_name', 'last_name', 'birthday', 'gender', 'email', 'phone',
        ]));

        // 2. Tambah file baru (kalau ada) saat edit
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                if (! $file->isValid()) {
                    continue;
                }

                $filename = round(microtime(true) * 1000) . '-' .
                str_replace(' ', '-', $file->getClientOriginalName());

                $file->move(public_path('uploads/multiple'), $filename);

                Multipleupload::create([
                    'ref_table' => 'pelanggan',
                    'ref_id'    => $pelanggan->pelanggan_id,
                    'filename'  => $filename,
                ]);
            }
        }

        return redirect()->route('pelanggan.index')
            ->with('update', 'Perubahan data berhasil!');
    }

    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')
            ->with('delete', 'Data berhasil dihapus!');
    }

    /* MULTIPLE FILE UPLOAD */
    public function uploadFiles(Request $request)
    {
        $request->validate([
            'ref_table' => 'required|string',
            'ref_id'    => 'required|integer',
            'files.*'   => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                if (! $file->isValid()) {
                    continue;
                }

                $filename = round(microtime(true) * 1000) . '-' .
                str_replace(' ', '-', $file->getClientOriginalName());

                $file->move(public_path('uploads/multiple'), $filename);

                Multipleupload::create([
                    'ref_table' => $request->ref_table,
                    'ref_id'    => $request->ref_id,
                    'filename'  => $filename,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    /* DELETE FILE */
    public function deleteFile(string $fileId)
    {
        $file = Multipleupload::findOrFail($fileId);

        $path = public_path('uploads/multiple/' . $file->filename);
        if (file_exists($path)) {
            @unlink($path);
        }

        $file->delete();

        return redirect()->back()->with('success', 'Data berhasil di hapus!');
    }
}
