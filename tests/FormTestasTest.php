<?php

namespace App\Tests;
use App\Controller\HelloPasauli;
use App\Entity\Users;
use App\Form\UsersFormType;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class FormTestasTest extends WebTestCase
{
    public function testSomething()
    {
        $user = new Users();
        $client = static::createClient();
        $crawler = $client->request('GET', '/uzduotis');
$form['name'] = 'Bronius';
$form['surname'] = 'Traktorystas';
        $form = $crawler->selectButton('Save')->form();


$crawler = $client->submit($form);
       $this->assertResponseIsSuccessful();
       $this->assertSelectorTextContains('', 'Sukurtas objektas, kurio ID yra: ' . $user->getId());

    }
}
