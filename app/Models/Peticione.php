<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peticione extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'descripcion', 'destinatario', 'firmantes', 'estado'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function firmas()
    {
        return $this->belongsToMany(User::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    /**
     * URL de la imagen de la petición: la primera que se subió o,
     * si no tiene, una de las imágenes de ejemplo de public/img.
     * Uso: $peticion->imagen_url
     */
    public function getImagenUrlAttribute(): string
    {
        $file = $this->files->first();
        if ($file) {
            return asset('storage/' . $file->file_path);
        }

        return asset('img/peticion-' . ((($this->id ?? 1) - 1) % 12 + 1) . '.jpg');
    }
}
