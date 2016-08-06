<?php

namespace AppBundle\Command\Api;

use GuzzleHttp\Psr7\Request;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use UMA\Psr7Hmac\Internal\MessageSerializer;
use UMA\Psr7Hmac\Signer;

class PlaceOrderCommand extends ApiCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('api:place-order')
            ->setDescription('Place a new product order through the HMAC API');
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
            'POST',
            'http://api.whalesale.com/orders',
            [
                'Api-Key' => $customer->getApiKey(),
                'Content-Type' => 'application/json'
            ],
            json_encode([
                'product_reference' => '#66666',
                'quantity' => 10
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
