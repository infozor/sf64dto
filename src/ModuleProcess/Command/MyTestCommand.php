<?php

namespace App\ModuleProcess\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use App\ModuleProcess\Aion\Test2;
use App\ModuleProcess\Aion\IonLog;

#[AsCommand(
    //name: 'MyTestCommand',
    name: 'app:test-command',
    description: 'Add a short description for your command',
)]
class MyTestCommand extends Command
{
    /*	
    public function __construct()
    {
        parent::__construct();
    }
    */

    private string $projectDir;
    private IonLog $IonLog;

    public function __construct(string $projectDir)
    {
        $this->IonLog = new IonLog($projectDir);
        $a[123] = 0;

        $zzz = '1';

        $vvv = $zzz;

        $this->projectDir = $projectDir;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $status_text = '123';

        $message = date('d.m.Y H:i:s') . ' ' . $status_text . "\n";
        $this->IonLog->log('a123_', $message);


        $Test = new Test2($output);
        $Test->do_it();


        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
            $option = $input->getOption('option1');
            $a = 1;
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');


        return Command::SUCCESS;
    }
}
