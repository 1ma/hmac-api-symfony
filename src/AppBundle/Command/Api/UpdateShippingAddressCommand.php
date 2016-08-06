<?php

namespace AppBundle\Command\Api;

use GuzzleHttp\Psr7\Request;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use UMA\Psr7Hmac\Internal\MessageSerializer;
use UMA\Psr7Hmac\Signer;

class UpdateShippingAddressCommand extends ApiCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('api:update-shipping-address')
            ->setDescription('Update a Customer shipping address through the HMAC API');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // print available usernames & select one
        $customer = $this->chooseApiClient($input, $output);

        // assemble psr7 request
        $request = new Request(
            'PUT',
            'http://api.whalesale.com/shipping-address',
            [
                'Api-Key' => $customer->getApiKey(),
                'Content-Type' => 'application/json',
            ],
            json_encode([
                'country' => 'ES',
                'city' => 'Barcelona',
                'place' => 'el camp de la bota',
            ])
        );

        // sign it
        $signer = new Signer($customer->getSharedSecret());
        $signedRequest = $signer->sign($request);

        // show it in terminal
        dump(MessageSerializer::serialize($signedRequest));

        // dispatch it
        $response = $this->httpClient->send($signedRequest);

        // show the response in terminal
        dump(MessageSerializer::serialize($response));
    }
}
