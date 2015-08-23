<?php

namespace AppBundle\Command;

use AppBundle\Teams\Generator;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GenerateTeamsCommand
 **/
class GenerateTeamsCommand extends ContainerAwareCommand
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('basic:generate_teams')
            ->setDescription('Generates teams from active users');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var Generator $generator */
        $generator = $this->getContainer()->get('basic.teams.generator');
        $generator->generate();

        $output->writeln('DONE.');

        return 0;
    }
}
