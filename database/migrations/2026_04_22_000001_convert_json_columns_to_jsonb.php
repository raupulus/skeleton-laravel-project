<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Convierte todas las columnas json a jsonb en PostgreSQL.
 * jsonb soporta operadores de igualdad, lo que permite SELECT DISTINCT
 * y operaciones de índice que json no soporta.
 */
return new class extends Migration
{
    /**
     * Columnas json a convertir por tabla.
     *
     * @var array<string, string[]>
     */
    protected array $tables = [
        'categories' => ['name', 'description'],
        'pages'      => ['title', 'content', 'excerpt', 'seo_title', 'seo_description', 'seo_keywords'],
        'posts'      => ['title', 'content', 'excerpt', 'seo_title', 'seo_description', 'seo_keywords'],
        'slides'     => ['title', 'content'],
        'sections'   => ['title', 'description', 'content'],
        'sent_emails'=> ['metadata'],
    ];

    /**
     * Ejecuta la migración: convierte json → jsonb en PostgreSQL.
     */
    public function up(): void
    {
        // Solo aplica en PostgreSQL; MySQL y SQLite no tienen este problema
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        foreach ($this->tables as $table => $columns) {
            foreach ($columns as $column) {
                DB::statement("ALTER TABLE \"{$table}\" ALTER COLUMN \"{$column}\" TYPE jsonb USING \"{$column}\"::jsonb");
            }
        }
    }

    /**
     * Revierte la migración: convierte jsonb → json.
     */
    public function down(): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        foreach ($this->tables as $table => $columns) {
            foreach ($columns as $column) {
                DB::statement("ALTER TABLE \"{$table}\" ALTER COLUMN \"{$column}\" TYPE json USING \"{$column}\"::json");
            }
        }
    }
};
