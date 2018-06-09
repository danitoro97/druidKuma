<?php

/**
 * Test para la pagina de Noticias
 */
class NoticiasFormCest
{
    public function _before(\FunctionalTester $I)
    {
        $I->amOnRoute('noticias/index');
    }

    /**
     * Puedes entrar en la pagina de noticias
     * @param  FunctionalTester $I [description]
     * @return [type]              [description]
     */
    public function openNoticiasPage(\FunctionalTester $I)
    {
        $I->see('Noticias', 'h1');

    }

    /**
     * Me logeo y comprueba que puedo ver las noticias
     * @param  FunctionalTester $I [description]
     * @return [type]              [description]
     */
    public function internalLoginById(\FunctionalTester $I)
    {
        $I->amLoggedInAs(\app\models\Usuarios::findOne(['nombre' => 'toro']));
        $I->amOnRoute('noticias/index');
        $I->see('Noticias', 'h1');

    }

    /**
     * Comprueba que alguien no logeado no pueda crear noticias
     * @param  FunctionalTester $I [description]
     * @return [type]              [description]
     */
    public function crearNoticiaSinLog(\FunctionalTester $I)
    {
        $I->amOnRoute('/noticias/create');
        $I->amOnPage('/site/login');
    }

    /**
     * Cualquiera puede ver una noticias y sus comentarios
     * @param  FunctionalTester $I [description]
     * @return [type]              [description]
     */
    public function verNoticia(\FunctionalTester $I)
    {
        $I->amOnRoute('/noticias/view',['id'=>1]);
        $I->see('El betis gana la Champions');
        $I->see('Ver comentarios');
    }

    /**
     * Si no estas logeado no puedes ver el boton de comentar noticias
     * @param  FunctionalTester $I [description]
     * @return [type]              [description]
     */
    public function comentarNoticiaSinLog(\FunctionalTester $I)
    {
        $I->amOnRoute('/noticias/view',['id'=>1]);
        $I->see('El betis gana la Champions');
        $I->see('Ver comentarios');
        $I->dontSee('Comentar',['css'=>'#botonComentario']);
    }
}
