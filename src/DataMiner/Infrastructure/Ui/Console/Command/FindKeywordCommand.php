<?php

namespace Mpwar\DataMiner\Infrastructure\Ui\Console\Command;

use Mpwar\DataMiner\Application\Service\FindKeyword;
use Mpwar\DataMiner\Domain\Keyword;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FindKeywordCommand extends Command
{
    private $finder;

    public function __construct(FindKeyword $finder)
    {
        parent::__construct();
        $this->finder = $finder;
    }

    protected function configure()
    {
        $this->addOption('keyword', 'k', InputOption::VALUE_REQUIRED, 'Keyword to search', null);
        $this
            ->setName('app:find')
            ->setDescription('Find keywords registered in services');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $option = $input->getOption('keyword');
        if ($option === null) {
            $output->writeln("You should provide keyword to find");
            return;
        }
        $this->finder->find(new Keyword($option));
    }
}
