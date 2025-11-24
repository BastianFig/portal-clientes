<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class OcController extends Controller
{
   
    public function listarFft($folio): JsonResponse
    {
        $proyecto = Proyecto::where('orden', $folio)->first();

        if (!$proyecto || !$proyecto->id_fasediseno) {
            return response()->json([
                'success' => false,
                'message' => 'FFT no disponible'
            ], Response::HTTP_NOT_FOUND);
        }

        // Obtener TODOS los archivos (no solo el primero)
        $mediaFiles = \Spatie\MediaLibrary\MediaCollections\Models\Media::where('model_type', 'App\\Models\\FaseDiseno')
            ->where('model_id', $proyecto->id_fasediseno)
            ->where('collection_name', 'imagenes')
            ->get(); // Cambiar first() por get()

        if ($mediaFiles->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No hay FFT adjuntados'
            ], Response::HTTP_NOT_FOUND);
        }

        // Mapear los archivos con su información
        $archivos = $mediaFiles->map(function ($media) use ($folio) {
            return [
                'id' => $media->id,
                'nombre' => $media->file_name,
                'size' => $media->size,
                'mime_type' => $media->mime_type,
                'url' => url("/api/descargar-fft/{$folio}/{$media->id}"),
                'created_at' => $media->created_at->format('d-m-Y H:i')
            ];
        });

        return response()->json([
            'success' => true,
            'folio' => $folio,
            'total' => $archivos->count(),
            'archivos' => $archivos
        ]);
    }

    public function descargarFft($folio, $id = null)
    {
        $proyecto = Proyecto::where('orden', $folio)->first();

        if (!$proyecto || !$proyecto->id_fasediseno) {
            abort(Response::HTTP_NOT_FOUND, 'FFT no disponible');
        }

        $query = \Spatie\MediaLibrary\MediaCollections\Models\Media::where('model_type', 'App\\Models\\FaseDiseno')
            ->where('model_id', $proyecto->id_fasediseno)
            ->where('collection_name', 'imagenes');

        if ($id) {
            $media = $query->where('id', $id)->first();
        } else {
            $media = $query->first();
        }

        if (!$media) {
            abort(Response::HTTP_NOT_FOUND, 'FFT no adjuntado');
        }

        $filePath = storage_path('app/public/' . $media->id . '/' . $media->file_name);
        
        if (!file_exists($filePath)) {
            abort(Response::HTTP_NOT_FOUND, 'Archivo FFT no encontrado en el servidor');
        }

        $mimeType = mime_content_type($filePath);
        
        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $media->file_name . '"',
        ]);
    }

    
    public function listarOc($folio): JsonResponse
    {
        $proyecto = Proyecto::where('orden', $folio)->first();

        if (!$proyecto || !$proyecto->id_fasecomercial) {
            return response()->json([
                'success' => false,
                'message' => 'OC no disponible'
            ], Response::HTTP_NOT_FOUND);
        }

        $mediaFiles = \Spatie\MediaLibrary\MediaCollections\Models\Media::where('model_type', 'App\\Models\\Fasecomercial')
            ->where('model_id', $proyecto->id_fasecomercial)
            ->where('collection_name', 'oc')
            ->get(); 

        if ($mediaFiles->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No hay OC adjuntadas'
            ], Response::HTTP_NOT_FOUND);
        }

        $archivos = $mediaFiles->map(function ($media) use ($folio) {
            return [
                'id' => $media->id,
                'nombre' => $media->file_name,
                'size' => $media->size,
                'mime_type' => $media->mime_type,
                'url' => url("/api/descargar-oc/{$folio}/{$media->id}"),
                'created_at' => $media->created_at->format('d-m-Y H:i')
            ];
        });

        return response()->json([
            'success' => true,
            'folio' => $folio,
            'total' => $archivos->count(),
            'archivos' => $archivos
        ]);
    }

    public function descargarOc($folio, $id = null)
    {
        $proyecto = Proyecto::where('orden', $folio)->first();

        if (!$proyecto || !$proyecto->id_fasecomercial) {
            abort(Response::HTTP_NOT_FOUND, 'OC no disponible');
        }

        $query = \Spatie\MediaLibrary\MediaCollections\Models\Media::where('model_type', 'App\\Models\\Fasecomercial')
            ->where('model_id', $proyecto->id_fasecomercial)
            ->where('collection_name', 'oc');

        if ($id) {
            $media = $query->where('id', $id)->first();
        } else {
            $media = $query->first();
        }

        if (!$media) {
            abort(Response::HTTP_NOT_FOUND, 'OC no adjuntada');
        }

        $filePath = storage_path('app/public/' . $media->id . '/' . $media->file_name);
        
        if (!file_exists($filePath)) {
            abort(Response::HTTP_NOT_FOUND, 'Archivo OC no encontrado en el servidor');
        }

        $mimeType = mime_content_type($filePath);
        
        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $media->file_name . '"',
        ]);
    }
}