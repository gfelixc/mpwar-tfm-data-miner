<?php

namespace Mpwar\DataMiner\Infrastructure\Ui\Console\Command;

use Mpwar\DataMiner\Application\CommandHandler\ReadKeywords;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DataMinerCommand extends Command
{
    private $dataMiner;

    public function __construct(ReadKeywords $dataMiner)
    {
        parent::__construct();
        $this->dataMiner = $dataMiner;
    }

    protected function configure()
    {
        $this
            ->setName('miner:start')
            ->setDescription('Find keywords registered in services');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->dataMiner->execute();
    }
}
