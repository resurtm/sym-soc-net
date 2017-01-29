<?php

namespace Tests\AppBundle\Cabinet\PasswordChange;

use AppBundle\Cabinet\PasswordChange\Model;

class ModelTest extends \PHPUnit_Framework_TestCase
{
    public function testGettersAndSetters()
    {
        $model = new Model();
        $password = '123123';

        $this->assertSame($model->setOldPassword($password), $model);
        $this->assertSame($model->getOldPassword(), $password);

        $this->assertSame($model->setNewPassword($password), $model);
        $this->assertSame($model->getNewPassword(), $password);
    }
}
