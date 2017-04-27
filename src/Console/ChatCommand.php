<?php

namespace Vulcan\Rivescript\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Vulcan\Rivescript\Rivescript;

class ChatCommand extends Command
{
    protected $rivescript;

    public function __construct(Rivescript $rivescript)
    {
        $this->rivescript = $rivescript;

        parent::__construct();
    }

    public function configure()
    {
        $this->setName('chat')
             ->setDescription('Load in a Rivescript brain instance to chat with')
             ->addArgument('brain', InputArgument::REQUIRED, 'Your Rivescript brain instance');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $brains = $this->parseFiles($input->getArgument('brain'));

        $this->rivescript->load($brains);

        $brain = explode('/', $input->getArgument('brain'));
        $brain = end($brain);

        $output->writeln('RiveScript Interpreter (PHP) -- Interactive Console v0.2');
        $output->writeln('--------------------------------------------------------');
        $output->writeln('RiveScript Version:       2.0');
        $output->writeln('Currently Loaded Brain:   '.$brain);
        $output->writeln('');
        $output->writeln('You are now chatting with the RiveScript bot. Type a message and press Return');
        $output->writeln('to send it. When finished, type "/quit" to exit the interactive console.');
        $output->writeln('');

        $this->waitForUserInput($input, $output);
    }

    protected function waitForUserInput($input, $output)
    {
        $helper = $this->getHelper('question');
        $question = new Question('<info>You > </info>');

        $message = $helper->ask($input, $output, $question);

        $this->parseConsoleCommands($input, $output, $message);

        $this->getBotResponse($input, $output, $message);
    }

    protected function getBotResponse($input, OutputInterface $output, $message)
    {
        $bot = 'Bot > ';
        $reply = $this->rivescript->reply(null, $message);
        $response = "<info>{$reply}</info>";

        $output->writeln($bot.$response);

        $this->waitForUserInput($input, $output);
    }

    protected function parseConsoleCommands($input, OutputInterface $output, $message)
    {
        if ($message === '/quit') {
            $output->writeln('Exiting...');
            die();
        }

        if ($message === '/reload') {
            return $this->execute($input, $output);
        }

        if ($message === '/help') {
            $output->writeln('');
            $output->writeln('<comment>Usage:</comment>');
            $output->writeln('  Type a message and press Return to send it.');
            $output->writeln('');
            $output->writeln('<comment>Commands:</comment>');
            $output->writeln('  <info>/help</info>        Show this text');
            $output->writeln('  <info>/reload</info>      Reload the interactive console');
            $output->writeln('  <info>/quit</info>        Quit the interactive console');
            $output->writeln('');

            $this->waitForUserInput($input, $output);
        }

        return 0;
    }

    private function parseFiles($files)
    {
        if (is_dir($files)) {
            $directory = realpath($files);
            $files = [];
            $brains = glob($directory.'/*.rive');

            foreach ($brains as $brain) {
                $files[] = $brain;
            }

            return $files;
        }

        return (array) $files;
    }
}
