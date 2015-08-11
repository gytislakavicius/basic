<?php

namespace AppBundle\Command;

use AppBundle\Encryptor\AES256Encryptor;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class EncodeUsersFilesCommand
 **/
class EncodeUsersFilesCommand extends ContainerAwareCommand
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('basic:encode_users_file')
            ->setDescription('Downloads file from input, encodes it and saves in destination given.')
            ->addArgument('inputSource', InputArgument::REQUIRED, 'Input source')
            ->addArgument('output', InputArgument::REQUIRED, 'Output source');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inSource       = $input->getArgument('inputSource');
        $outDestination = $input->getArgument('output');

        /** @var AES256Encryptor $encryptorService */
        $encryptorService = $this->getContainer()->get('basic.encryptor');

        $encryptedContent = $encryptorService->encrypt(file_get_contents($inSource));

        file_put_contents($outDestination, $encryptedContent);

        $output->writeln('DONE.');
    }
}
