<?php
// From : https://laracasts.com/discuss/channels/laravel/how-to-use-binary16-uuids-as-foreign-keys
/*
 * @Author: Ferdhika Yudira 
 * @Website: http://dika.web.id 
 * @Date:   2018-07-18 15:30:02 
 * @Email: fer@dika.web.id 
 */
namespace App\Traits;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait BinarySchemaTrait {

    public function createBinaryColumn($table, $column, $isPrimaryKey = TRUE, $nullable = FALSE) {
        if (!$nullable) {
            DB::statement("ALTER TABLE $table ADD $column BINARY(16) NOT NULL FIRST;");
        }
        else {
            DB::statement("ALTER TABLE $table ADD $column BINARY(16) NULL FIRST;");
        }

        if ($isPrimaryKey) {
            DB::statement("ALTER TABLE $table ADD PRIMARY KEY ($column);");

            $index = $table . '_' . $column;
            DB::statement("CREATE UNIQUE INDEX $index ON $table ($column);");
        }

    }

    public function setForeignKey($tableName, $column, $foreignTable, $foreignColumn) {
        Schema::table($tableName, function (Blueprint $table) use ($column, $foreignTable, $foreignColumn) {
            $table->foreign($column)
                ->references($foreignColumn)
                ->on($foreignTable)
                // ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}