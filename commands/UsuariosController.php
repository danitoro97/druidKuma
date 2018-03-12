<?php

namespace app\commands;

use app\models\Usuarios;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Comandos relaciones con el mantenimiento de los usuarios.
 */
class UsuariosController extends Controller
{
    /**
     * Elimina los usuarios que llevan mas de 48h sin validar.
     * @param mixed $dias
     */
    public function actionLimpiar($dias = 2)
    {
        $res = Usuarios::deleteAll(
            'token_val IS NOT NULL
                            AND :ahora - created_at >= :dias::interval',
            ['ahora' => date('Y-m-d H:i:s'),
            'dias' => "P{$dias}D",
            ]
        );
        echo "Se han eliminado $res usuarios. \n";
        return ExitCode::OK;
    }
}
