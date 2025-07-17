<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileAccessController extends Controller
{
    public function show(Request $request, $path)
    {
        // Log akses
        Log::info('Akses avatar', [
            'path' => $path,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'user_id' => auth()->check() ? auth()->id() : null,
        ]);

        // Cek file
        if (!Storage::disk('private')->exists($path)) {
            abort(404);
        }
        return Storage::disk('private')->response($path);
    }
}
