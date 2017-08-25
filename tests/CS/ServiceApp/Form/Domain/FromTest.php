<?php

namespace Tests\CS\ServiceApp\Form\Domain;

use CS\ServiceApp\Call\Domain\Call;
use CS\ServiceApp\Form\Domain\Form;
use PHPUnit\Framework\TestCase;

class FormTest extends TestCase
{
    /**
     * @test
     */
    public function canBeCreatedAndReceiveQuestion()
    {
        $call = new Call('newCall','555','444','in','1',new \DateTime());
        $form = new Form($call);

        $form->setQuestion('question?');

        $this->assertSame('question?', $form->getQuestion());
    }

    /**
     * @test
     */
    public function canBeMarkedAsAnswered()
    {
        $call = new Call('newCall','555','444','in','1',new \DateTime());
        $form = new Form($call);

        $form->setQuestion('question?');

        $this->assertFalse($form->isAnswered());

        $date =  \DateTime::createFromFormat('Y-m-d H:i:s', '2017-08-24 10:00:00');
        $form->receivedAnswer($date);

        $this->assertTrue($form->isAnswered());
        $this->assertEquals('2017-08-24 10:00:00', $form->getAnswerDate()->format('Y-m-d H:i:s'));
    }
}
