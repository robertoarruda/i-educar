<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateAlimentosEventoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(
            '
                SET default_with_oids = true;
                
                CREATE TABLE alimentos.evento (
                    ideve integer DEFAULT nextval(\'alimentos.evento_ideve_seq\'::regclass) NOT NULL,
                    idcad integer NOT NULL,
                    mes integer NOT NULL,
                    dia integer NOT NULL,
                    dia_util character(1) NOT NULL,
                    descricao character varying(50) NOT NULL,
                    CONSTRAINT ck_evento_dia_util CHECK (((dia_util = \'S\'::bpchar) OR (dia_util = \'N\'::bpchar)))
                );
            '
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alimentos.evento');
    }
}