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
class UpdateUsersCommand extends ContainerAwareCommand
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('basic:users_update')
            ->setDescription('Updates users from given file.')
            ->addArgument('usersFile', InputArgument::REQUIRED)
            ->addOption('decrypt');
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

        $fileContent = file_get_contents($input->getArgument('usersFile'));

        if ($input->hasOption('decrypt')) {
            $fileContent = $this->getContainer()->get('basic.encryptor')->decrypt($fileContent);
        }

        $usersService->updateUsers(
            json_decode($fileContent)
        );

        $output->writeln('DONE.');

        return 0;
    }
}
