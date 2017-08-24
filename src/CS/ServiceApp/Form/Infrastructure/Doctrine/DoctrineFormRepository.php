<?php

namespace CS\ServiceApp\Form\Infrastructure\Doctrine;

use CS\ServiceApp\Form\Domain\Form;
use CS\ServiceApp\Form\Domain\FormRepository;
use Doctrine\ORM\EntityRepository;

class DoctrineFormRepository extends EntityRepository implements FormRepository
{

    public function load($id)
    {
        return $this->find($id);
    }

    public function store(Form $form)
    {
        $this->_em->persist($form);
        $this->_em->flush();
    }
}
