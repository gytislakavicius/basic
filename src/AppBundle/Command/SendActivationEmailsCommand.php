<?php

namespace AppBundle\Command;

use AppBundle\Service\Users;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UpdateUsersCommand
 **/
class SendActivationEmailsCommand extends ContainerAwareCommand
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('basic:send_activation_emails')
            ->setDescription('Sends activation emails to users for whom it was not yet sent');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var Users $usersService */
        $usersService = $this->getContainer()->get('basic.users');

        $usersService->sendActivationEmails();

        $output->writeln('DONE.');

        return 0;
    }
}
