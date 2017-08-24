<?php
declare(strict_types=1);

namespace CS\ServiceApp\Form\Application;

use CS\ServiceApp\Call\Domain\Call;
use CS\ServiceApp\Form\Domain\Form;

class FormFactory
{
    /**
     * @param Call $call
     *
     * @return Form
     */
    public static function create(Call $call): Form
    {
        $form = new Form($call);
        $form->setCreatedAt(new \DateTime());
        $form->setUpdatedAt(new \DateTime());

        return $form;
    }
}
