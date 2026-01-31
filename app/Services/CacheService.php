<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    /**
     * Tiempo de caché por defecto (en minutos)
     */
    private const DEFAULT_TTL = 60; // 1 hora

    /**
     * Tiempos de caché por tipo de dato
     */
    private const TTL_CONFIG = [
        'categories' => 1440,      // 24 horas (datos casi estáticos)
        'category_features' => 720, // 12 horas
        'alliances' => 360,        // 6 horas
        'company_info' => 1440,    // 24 horas (cambia raramente)
        'about_info' => 1440,      // 24 horas
        'social_media' => 720,     // 12 horas
        'donations' => 360,        // 6 horas
        'central_images' => 180,   // 3 horas
    ];

    /**
     * Obtener datos con caché
     * 
     * @param string $key Clave única del caché
     * @param callable $callback Función que obtiene los datos si no están en caché
     * @param int|null $ttl Tiempo de vida en minutos (null = usar default)
     * @param string|null $type Tipo de dato para TTL automático
     * @return mixed
     */
    public function remember(string $key, callable $callback, ?int $ttl = null, ?string $type = null)
    {
        // Determinar TTL
        if ($type && isset(self::TTL_CONFIG[$type])) {
            $ttl = self::TTL_CONFIG[$type];
        } elseif ($ttl === null) {
            $ttl = self::DEFAULT_TTL;
        }

        // Obtener de caché o ejecutar callback
        return Cache::remember($key, $ttl * 60, $callback);
    }

    /**
     * Invalidar caché específico
     * 
     * @param string $key
     * @return bool
     */
    public function forget(string $key): bool
    {
        return Cache::forget($key);
    }

    /**
     * Invalidar caché por patrón
     * 
     * @param string $pattern Ej: 'categories:*'
     * @return void
     */
    public function forgetByPattern(string $pattern): void
    {
        $this->getKeysByPattern($pattern);
    }

    /**
     * Invalidar múltiples cachés por tipo
     * 
     * @param string $type Ej: 'categories', 'alliances'
     * @return void
     */
    public function invalidateType(string $type): void
    {
        $this->forgetByPattern("{$type}:*");
    }

    /**
     * Limpiar TODO el caché
     * USAR CON PRECAUCIÓN
     * 
     * @return bool
     */
    public function flush(): bool
    {
        return Cache::flush();
    }

    /**
     * Verificar si existe en caché
     * 
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return Cache::has($key);
    }

    /**
     * Obtener keys por patrón (helper interno)
     * 
     * @param string $pattern
     * @return array
     */
    private function getKeysByPattern(string $pattern): void
    {
        // Para file cache de Laravel, buscar y borrar directamente
        $cacheDir = storage_path('framework/cache/data');

        if (!is_dir($cacheDir)) {
            return;
        }

        $files = @scandir($cacheDir);
        if (!$files) {
            return;
        }

        // Convertir patrón a regex: 'alliances:*' -> 'alliances:.*'
        $patternRegex = str_replace('*', '.*', preg_quote($pattern, '/'));

        foreach ($files as $file) {
            if ($file === '.' || $file === '..' || $file === 'README.md') {
                continue;
            }

            $filePath = $cacheDir . '/' . $file;
            if (!is_file($filePath)) {
                continue;
            }

            try {
                $content = @file_get_contents($filePath);
                if (!$content) {
                    continue;
                }

                // Buscar si la clave coincide con el patrón en el contenido
                // Laravel serializa las claves dentro del archivo
                if (preg_match('/' . $patternRegex . '/', $content)) {
                    @unlink($filePath);
                }
            } catch (\Exception $e) {
                // Ignorar errores de lectura
                continue;
            }
        }
    }

    /**
     * Generar clave de caché consistente
     * 
     * @param string $prefix
     * @param array $params
     * @return string
     */
    public static function generateKey(string $prefix, array $params = []): string
    {
        if (empty($params)) {
            return $prefix;
        }

        ksort($params);
        $paramString = http_build_query($params);

        return $prefix . ':' . md5($paramString);
    }
}
