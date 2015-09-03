<?php

namespace AppBundle\Command;

use AppBundle\Service\Api;
use AppBundle\Service\PointCalculationLogic;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CalculateScoresCommand
 **/
class CalculateScoresCommand extends ContainerAwareCommand
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('basic:calculate_scores')
            ->setDescription('Calculates user and team scores');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var PointCalculationLogic $pcl */
        $pcl = $this->getContainer()->get('basic.pcl');
        $pcl->calculateAllPoints();

        /** @var Api $api */
        $api = $this->getContainer()->get('basic.api');
        if ($api->isGameDone()) {
            $pcl->setWinners();
        }

        $output->writeln('DONE.');

        return 0;
    }
}
