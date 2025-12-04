<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BoardAssetController extends Controller
{
    /**
     * Handle uploads for TLDraw board assets.
     */
    public function store(Request $request, Project $project): JsonResponse
    {
        $data = $request->validate([
            'asset' => [
                'required',
                'file',
                'max:20480', // 20 MB
                'mimetypes:image/png,image/jpeg,image/jpg,image/webp,image/gif,image/svg+xml,video/mp4,video/quicktime,video/webm',
            ],
        ]);

        $file = $data['asset'];
        $directory = "projects/{$project->id}/board-assets";
        $path = $file->storePublicly($directory, ['disk' => 'gcs']);

        $url = Storage::disk('gcs')->url($path);

        return response()->json([
            'url' => $url,
            'path' => $path,
        ]);
    }
}

