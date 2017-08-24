<?php

namespace Tests\CS\ServiceApp\Implementation\Repository;

use CS\ServiceApp\Form\Domain\Form;
use CS\ServiceApp\Form\Domain\FormRepository;

class InMemoryFormRepository implements FormRepository
{
    private $forms;

    public function load($id)
    {
        if(!isset($this->forms[$id])) {
            return null;
        }

        return $this->forms[$id];
    }

    public function store(Form $form)
    {
        $this->forms[$form->getId()] = $form;
    }
}
