<?php

namespace AcMarche\Patrimoine\Command;

use AcMarche\Patrimoine\Repository\PatrimoineRepository;
use AcMarche\Patrimoine\Repository\StatutRepository;
use AcMarche\Patrimoine\Repository\TypePatrimoineRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PatrimoineMigrationCommand extends Command
{
    protected static $defaultName = 'patrimoine:migration';
    /**
     * @var PatrimoineRepository
     */
    private $patrimoineRepository;
    /**
     * @var TypePatrimoineRepository
     */
    private $typePatrimoineRepository;
    /**
     * @var StatutRepository
     */
    private $statutRepository;

    public function __construct(
        PatrimoineRepository $patrimoineRepository,
        TypePatrimoineRepository $typePatrimoineRepository,
        StatutRepository $statutRepository,
        string $name = null
    ) {
        parent::__construct($name);
        $this->patrimoineRepository = $patrimoineRepository;
        $this->typePatrimoineRepository = $typePatrimoineRepository;
        $this->statutRepository = $statutRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        foreach ($this->patrimoineRepository->findAll() as $patrimoine) {
            if ($type = $this->typePatrimoineRepository->findOneBy(['nom' => $patrimoine->getTypeOld()])) {
                $patrimoine->setTypePatrimoine($type);
            }

            if ($statut = $this->statutRepository->findOneBy(['nom' => $patrimoine->getStatutOld()])) {
                $patrimoine->setStatut($statut);
            }
        }

        $this->patrimoineRepository->flush();
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return 0;
    }
}
