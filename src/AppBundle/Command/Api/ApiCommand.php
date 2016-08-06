<?php

namespace AppBundle\Command\Api;

use AppBundle\Entity\Customer;
use AppBundle\Repository\CustomerRepository;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class ApiCommand extends Command
{
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * @var Client
     */
    protected $httpClient;

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
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return Customer
     */
    protected function chooseApiClient(InputInterface $input, OutputInterface $output)
    {
        // TODO findAll and let the command user choose one. You can create 'el_barto'
        // manually (bin/console app:manage-customers) or by running the unit tests.
        return $this->customerRepository
            ->findOneByUsername('el_barto');
    }
}
