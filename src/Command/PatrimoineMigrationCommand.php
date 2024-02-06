<?php

namespace AcMarche\Patrimoine\Command;

use AcMarche\Patrimoine\Repository\PatrimoineRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'patrimoine:migration',
    description: 'up',
)]
class PatrimoineMigrationCommand extends Command
{
    public function __construct(
        private PatrimoineRepository $patrimoineRepository,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        foreach ($this->patrimoineRepository->findAll() as $patrimoine) {
        }

        $this->patrimoineRepository->flush();
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return 0;
    }
}
