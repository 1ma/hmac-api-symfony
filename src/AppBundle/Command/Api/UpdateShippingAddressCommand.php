<?php

namespace AppBundle\Command\Api;

use AppBundle\Entity\Customer;
use AppBundle\Repository\CustomerRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use UMA\Psr7Hmac\Internal\MessageSerializer;
use UMA\Psr7Hmac\Signer;

class UpdateShippingAddressCommand extends Command
{
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @param CustomerRepository    $customerRepository
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->httpClient = new Client([
            RequestOptions::HTTP_ERRORS => false
        ]);

        parent::__construct();
    }

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
                'Content-Type' => 'application/json'
            ],
            json_encode([
                'country' => 'ES',
                'city' => 'Barcelona',
                'place' => 'el camp de la bota'
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

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return Customer
     */
    private function chooseApiClient(InputInterface $input, OutputInterface $output)
    {
        // TODO findAll and let the command user choose one. You can create 'el_barto'
        // manually (bin/console app:manage-customers) or by running the unit tests.
        return $this->customerRepository
            ->findOneByUsername('el_barto');
    }
}
