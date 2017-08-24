<?php

namespace CS\ServiceApp\Form\Domain;

interface FormRepository
{
    public function load($id);

    public function store(Form $form);
}
