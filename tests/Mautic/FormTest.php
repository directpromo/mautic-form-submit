<?php

namespace Escopecz\MauticFormSubmit\Test\Mautic;

use Escopecz\MauticFormSubmit\Mautic;
use Escopecz\MauticFormSubmit\Mautic\Form;

class MauticTest extends \PHPUnit_Framework_TestCase
{
    private $baseUrl = 'https://mymautic.com';

    function test_get_id()
    {
        $mautic = new Mautic($this->baseUrl);
        $formId = 3434;
        $form = new Form($mautic, $formId);

        $this->assertSame($formId, $form->getId());
    }

    function test_prepare_request()
    {
        $mautic = new Mautic($this->baseUrl);
        $formId = 3434;
        $form = new Form($mautic, $formId);
        $data = [
            'email' => 'john@doe.email',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ];
        $request = $form->prepareRequest($data);

        $this->assertSame($this->baseUrl.'/form/submit?formId='.$formId, $request['url']);
        $this->assertSame($data['email'], $request['data']['mauticform']['email']);
        $this->assertSame($data['first_name'], $request['data']['mauticform']['first_name']);
        $this->assertSame($data['last_name'], $request['data']['mauticform']['last_name']);
        $this->assertSame($formId, $request['data']['mauticform']['formId']);
        $this->assertSame('', $request['data']['mauticform']['return']);
    }
}