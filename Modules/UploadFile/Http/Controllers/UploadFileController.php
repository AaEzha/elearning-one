<?php

namespace Modules\UploadFile\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\UploadFile\Entities\UploadFile;

class UploadFileController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $title = "Upload File";
        $files = UploadFile::where('user_id', Auth::id())->select('url','filename')->get();
        return view('uploadfile::index', compact('title', 'files'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('uploadfile::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'filename' => 'required',
            'berkas' => 'required'
        ]);

        $path = "public/" . date('Y') . "/" . Auth::id();
        $name = time() . "." . $request->file('berkas')->extension();

        $file = $request->file('berkas')->storeAs(
            $path, $name
        );

        if($file) {
            // input ke tabel
            UploadFile::create([
                'filename' => $request->filename,
                'path' => $path . "/" . $name,
                'user_id' => Auth::id()
            ]);
            return redirect()->route('upload.index')->with('success', 'File berhasil diupload');
        } else {
            return redirect()->route('upload.index')->with('success', 'File gagal diupload');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(UploadFile $uploadfile)
    {
        if(Storage::exists($uploadfile->path)) {
            return Storage::download($uploadfile->path);
        } else {
            // abort(404);
            return redirect()->route('upload.index')->with('success', 'File tidak ditemukan');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('uploadfile::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
