<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class SeminarController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $errorMessage = session('error');
            $successMessage = session('success');
            $seminar = Seminar::where('user_id', Auth::user()->getAuthIdentifier())->paginate(10);
            return view('seminar.seminar', [
                'seminar' => $seminar,
                'errorMessage' => $errorMessage,
                'successMessage' =>  $successMessage,
            ]);
        } else {
            return redirect('/login');
        }
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            if (Auth::check()) {
                $this->validate($request, [
                    'mahasiswa_nim'         => 'string|required',
                    'mahasiswa_nama'        => 'string|required',
                    'waktu_seminar'         => 'date|required',
                    'tahun_ajaran'          => 'required|min:0',
                    'no_berita_acara'       => 'required|min:0',
                    'path_foto_kegiatan'    => 'required|max:10000|mimes:pdf,jpg,png,doc,docx',
                    'path_lampiran'         => 'required|max:10000|mimes:pdf,jpg,png,doc,docx',
                ]);

                $waktu = Carbon::createFromFormat('d-m-Y', $request->waktu_seminar)->format('Y-m-d');
                
                // Upload image
                $files = $request->file('path_lampiran');
                $files->storeAs('public', $files->hashName());
                $files2 = $request->file('path_foto_kegiatan');
                $files2->storeAs('public', $files2->hashName());

                // Create post
                Seminar::create([
                    'mahasiswa_nim'         => $request->mahasiswa_nim,
                    'mahasiswa_nama'        => $request->mahasiswa_nama,
                    'tahun_ajaran'          => $request->tahun_ajaran,
                    'waktu_seminar'         => $waktu,
                    'no_berita_acara'       => $request->no_berita_acara,
                    'path_lampiran'         => $files->hashName(),
                    'path_foto_kegiatan'    => $files2->hashName(),
                    'user_id'               => Auth::user()->getAuthIdentifier(),
                ]);

                // Redirect to index
                return redirect('/seminar')->with(['success' => 'Data Berhasil Disimpan!']);
            }
        } catch (ValidationException $e) {
            return redirect()->back()->with('error', $e->errors());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function delete(Request $request): RedirectResponse
    {
        try {
            $seminarId = $request->input('seminar_id');
            $seminar = Seminar::find($seminarId);

            if (Auth::check() && $seminar && $seminar->user_id === Auth::user()->getAuthIdentifier()) {
                // Delete files associated with the seminar (lampiran and foto_kegiatan)
                Storage::delete('public/' . $seminar->path_lampiran);
                Storage::delete('public/' . $seminar->path_foto_kegiatan);

                // Delete the seminar
                $seminar->delete();

                return redirect('/seminar')->with('success', 'Data berhasil dihapus!');
            } else {
                return redirect('/seminar')->with('error', 'Anda tidak memiliki izin untuk menghapus data ini.');
            }
        } catch (\Exception $e) {
            return redirect('/seminar')->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
?>
@foreach ($seminar as $item)
    <!-- Tampilkan data seminar -->

    <!-- Tombol Hapus -->
    <form action="{{ route('seminar.delete') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
        @csrf
        <input type="hidden" name="seminar_id" value="{{ $item->id }}">
        <button type="submit" class="btn btn-danger">Hapus</button>
    </form>
@endforeach
?>
Route::post('/seminar/delete', [SemMaaf, tetapi tampaknya ada kesalahan dalam menggabungkan kode. Berikut adalah kode yang telah diperbaiki:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class SeminarController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $errorMessage = session('error');
            $successMessage = session('success');
            $seminar = Seminar::where('user_id', Auth::user()->getAuthIdentifier())->paginate(10);
            return view('seminar.seminar', [
                'seminar' => $seminar,
                'errorMessage' => $errorMessage,
                'successMessage' =>  $successMessage,
            ]);
        } else {
            return redirect('/login');
        }
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            if (Auth::check()) {
                $this->validate($request, [
                    'mahasiswa_nim'         => 'string|required',
                    'mahasiswa_nama'        => 'string|required',
                    'waktu_seminar'         => 'date|required',
                    'tahun_ajaran'          => 'required|min:0',
                    'no_berita_acara'       => 'required|min:0',
                    'path_foto_kegiatan'    => 'required|max:10000|mimes:pdf,jpg,png,doc,docx',
                    'path_lampiran'         => 'required|max:10000|mimes:pdf,jpg,png,doc,docx',
                ]);

                $waktu = Carbon::createFromFormat('d-m-Y', $request->waktu_seminar)->format('Y-m-d');
                
                // Upload image
                $files = $request->file('path_lampiran');
                $files->storeAs('public', $files->hashName());
                $files2 = $request->file('path_foto_kegiatan');
                $files2->storeAs('public', $files2->hashName());

                // Create post
                Seminar::create([
                    'mahasiswa_nim'         => $request->mahasiswa_nim,
                    'mahasiswa_nama'        => $request->mahasiswa_nama,
                    'tahun_ajaran'          => $request->tahun_ajaran,
                    'waktu_seminar'         => $waktu,
                    'no_berita_acara'       => $request->no_berita_acara,
                    'path_lampiran'         => $files->hashName(),
                    'path_foto_kegiatan'    => $files2->hashName(),
                    'user_id'               => Auth::user()->getAuthIdentifier(),
                ]);

                // Redirect to index
                return redirect('/seminar')->with(['success' => 'Data Berhasil Disimpan!']);
            }
        } catch (ValidationException $e) {
            return redirect()->back()->with('error', $e->errors());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function delete(Request $request): RedirectResponse
    {
        try {
            $seminarId = $request->input('seminar_id');
            $seminar = Seminar::find($seminarId);

            if (Auth::check() && $seminar && $seminar->user_id === Auth::user()->getAuthIdentifier()) {
                // Delete files associated with the seminar (lampiran and foto_kegiatan)
                Storage::delete('public/' . $seminar->path_lampiran);
                Storage::delete('public/' . $seminar->path_foto_kegiatan);

                // Delete the seminar
                $seminar->delete();

                return redirect('/seminar')->with('success', 'Data berhasil dihapus!');
            } else {
                return redirect('/seminar')->with('error', 'Anda tidak memiliki izin untuk menghapus data ini.');
            }
        } catch (\Exception $e) {
            return redirect('/seminar')->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
?>
@extends('layouts.app')

@section('content')
@foreach ($seminar as $item)
    <!-- Tampilkan data seminar -->

    <!-- Tombol Hapus -->
    <form action="{{ route('seminar.delete') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
        @csrf
        <input type="hidden" name="seminar_id" value="{{ $item->id }}">
        <button type="submit"