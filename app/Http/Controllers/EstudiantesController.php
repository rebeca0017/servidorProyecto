<?php

namespace App\Http\Controllers;

use App\Estudiante;
use App\InformacionEstudiante;
use App\Matricula;
use App\PeriodoLectivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstudiantesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getOne(Request $request)
    {

        $estudiante = Estudiante::findOrFail($request->id);
        $periodoLectivoActual = PeriodoLectivo::where('estado', 'ACTUAL')->first();
        $matricula = Matricula::where('estudiante_id', $request->id)
            ->where('periodo_lectivo_id', $periodoLectivoActual->id)
            ->first();
        $informacionEstudiante = InformacionEstudiante::where('matricula_id', $matricula->id)->first();

        return response()->json([
            'estudiante' => $estudiante,
            'informacion_estudiante' => $informacionEstudiante
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->json()->all();
        $dataEstudiante = $data['estudiante'];
        $dataInformacionEstudiante = $data['estudiante'];
        $parameters = [
            $dataEstudiante['pais_nacionalidad_id'],
            $dataEstudiante['pais_residencia_id'],
            $dataEstudiante['identificacion'],
            $dataEstudiante['nombre1'],
            $dataEstudiante['nombre2'],
            $dataEstudiante['apellido1'],
            $dataEstudiante['apellido2'],
            $dataEstudiante['fecha_nacimiento'],
            $dataEstudiante['correo_personal'],
            $dataEstudiante['correo_institucional'],
            $dataEstudiante['sexo'],
            $dataEstudiante['etnia'],
            $dataEstudiante['tipo_sangre'],
            $dataEstudiante['tipo_documento'],
            $dataEstudiante['tipo_colegio'],
        ];
        $sql = 'SELECT estudiantes.* 
                FROM 
                  matriculas inner join informacion_estudiantes on matriculas.id = informacion_estudiantes.matricula_id 
	              inner join estudiantes on matriculas.estudiante_id = estudiantes.id 
	            WHERE matriculas.periodo_lectivo_id = 1 and matriculas.estudiante_id =1';
        $estudiante = DB::select($sql, null);

        $sql = 'SELECT informacion_estudiantes.* 
                FROM 
                  matriculas inner join informacion_estudiantes on matriculas.id = informacion_estudiantes.matricula_id 
	              inner join estudiantes on matriculas.estudiante_id = estudiantes.id 
	            WHERE matriculas.periodo_lectivo_id = 1 and matriculas.estudiante_id =1';
        $informacionEstudiante = DB::select($sql, null);
        return response()->json([
            'estudiante' => $estudiante,
            'informacion_estudiante' => $informacionEstudiante
        ]);
    }
}
