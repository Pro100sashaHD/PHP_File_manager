<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{   

    public function store(Request $request)
    {
        if (Auth::user()->role === 'admin') {
            return back()->withErrors(['msg' => 'Администраторам запрещена загрузка файлов']);
        }

        $request->validate([
            'file' => 'required|file|max:16384',
        ]);

        $uploadedFile = $request->file('file');
        
        $fileData = file_get_contents($uploadedFile->getRealPath());

        File::create([
            'user_id' => Auth::id(),
            'name' => $uploadedFile->getClientOriginalName(),
            'path' => 'db_storage', 
            'size' => $uploadedFile->getSize(),
            'mime_type' => $uploadedFile->getMimeType(),
            'content' => $fileData,
        ]);

        return back()->with('success', 'Файл успешно сохранен в базу данных!');
    }

    public function download($id)
    {
        $user = Auth::user();

        $file = ($user->role === 'admin') 
            ? File::findOrFail($id) 
            : File::where('user_id', $user->id)->findOrFail($id);

        $content = is_resource($file->content) 
            ? stream_get_contents($file->content) 
            : $file->content;

        return response($content)
            ->header('Content-Type', $file->mime_type)
            ->header('Content-Disposition', 'attachment; filename="' . $file->name . '"');
    }

    public function destroy($id)
    {
        $user = Auth::user();

        $file = ($user->role === 'admin') 
            ? File::findOrFail($id) 
            : File::where('user_id', $user->id)->findOrFail($id);
        
        $file->delete();

        return back()->with('success', 'Файл успешно удален.');
    }
}
