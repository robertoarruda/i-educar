<?php

namespace App\Listeners;

use App\Models\LegacyInstitution;
use App\Models\LegacySchoolClass;
use App\Models\LegacyStudent;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginLegacySession
{
    /**
     * @return int
     */
    private function getStudentsCount()
    {
        return LegacyStudent::query()->count();
    }

    /**
     * @return int
     */
    private function getTeachersCount()
    {
        return DB::table('pmieducar.servidor s')
            ->join('pmieducar.servidor_funcao sf', 'sf.ref_cod_servidor', '=', 's.cod_servidor')
            ->join('pmieducar.funcao f', 'f.cod_funcao', '=', 'sf.ref_cod_funcao')
            ->where('f.professor', 1)
            ->count();
    }

    /**
     * @return int
     */
    private function getClassesCount()
    {
        return LegacySchoolClass::query()->count();
    }

    /**
     * @param User $user
     *
     * @return object
     */
    private function getLoggedUserInfo($user)
    {
        $institution = app(LegacyInstitution::class);

        return (object) [
            'personId' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'institution' => $institution->name,
            'city' => $institution->city,
            'state' => $institution->state,
            'students_count' => $this->getStudentsCount(),
            'teachers_count' => $this->getTeachersCount(),
            'classes_count' => $this->getClassesCount(),
        ];
    }

    /**
     * Handle the event.
     *
     * @param object $event
     *
     * @return void
     */
    public function handle($event)
    {
        Session::put([
            'itj_controle' => 'logado',
            'id_pessoa' => $event->user->id,
            'pessoa_setor' => $event->user->employee->department_id,
            'tipo_menu' => $event->user->employee->menu_type,
            'nivel' => $event->user->type->level,
            'logged_user' => $this->getLoggedUserInfo($event->user),
        ]);
    }
}
