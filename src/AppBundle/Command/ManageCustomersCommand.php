<?php

namespace AppBundle\Command;

use AppBundle\Entity\Customer;
use AppBundle\Repository\CustomerRepository;
use AppBundle\UseCase\CreateCustomerUseCase;
use AppBundle\UseCase\Exception\UsernameTakenException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class ManageCustomersCommand extends Command
{
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * @var CreateCustomerUseCase
     */
    private $creationUseCase;

    /**
     * @var QuestionHelper
     */
    private $questionHelper;

    /**
     * @param CreateCustomerUseCase $creationUseCase
     * @param CustomerRepository    $customerRepository
     */
    public function __construct(CreateCustomerUseCase $creationUseCase, CustomerRepository $customerRepository)
    {
        $this->creationUseCase = $creationUseCase;
        $this->customerRepository = $customerRepository;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:manage-customers')
            ->setDescription('List existing customers and create new ones');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->questionHelper = $this->getHelper('question');

        $this->assembleCustomerTable($output)->render();

        if ($this->questionHelper->ask(
            $input, $output,
            new ConfirmationQuestion('Do you want to create a new customer? ')
        )) {
            return $this->createCustomerFlow($input, $output);
        }

        return 0;
    }

    /**
     * @param OutputInterface $output
     *
     * @return Table
     */
    private function assembleCustomerTable(OutputInterface $output)
    {
        /** @var Customer[] $customers */
        $customers = $this->customerRepository
            ->findAll();

        $table = new Table($output);
        $table->setHeaders(['username', 'api key', 'shared secret']);
        foreach ($customers as $customer) {
            $table->addRow([
                $customer->getUsername(), $customer->getApiKey(), $customer->getSharedSecret(),
            ]);
        }

        return $table;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    private function createCustomerFlow(InputInterface $input, OutputInterface $output)
    {
        $username = $this->questionHelper->ask(
            $input, $output,
            new Question('Enter the new customer username: ')
        );

        try {
            $this->creationUseCase->execute($username);
        } catch (UsernameTakenException $e) {
            $output->writeln("Sorry, username <error>$username</error> is already in use");

            return 1;
        }

        $output->writeln("New customer <info>$username</info> successfully created");

        return 0;
    }
}
