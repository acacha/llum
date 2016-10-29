<?php

namespace Acacha\Llum\Console;

use Acacha\Llum\Compiler\RCFileCompiler;
use Acacha\Llum\Filesystem\Filesystem;
use Acacha\Llum\Github\GithubAPI;
use Acacha\Llum\LlumRCFile;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

require __DIR__ . "../passwords.php";

/**
 * Class InitCommand
 * @package Acacha\Llum\Console
 */
class InitCommand extends LlumCommand
{

    protected $githubapi;

    /**
     * Filesystem.
     *
     * @var Filesystem
     */
    protected $filesytem;

    /**
     * Compiler for llumrc file.
     *
     * @var RCFileCompiler
     */
    protected $compiler;

    /**
     * Command name.
     *
     * @var string
     */
    protected $commandName = 'init';

    /**
     * Command description.
     *
     * @var string
     */
    protected $commandDescription = 'Create ~/.llumrc file with llum configuration data';

    /**
     * Method to execute.
     *
     * @var string
     */
    protected $method = 'init';

    protected $github_username;

    protected $github_token = "";

    /**
     * InitCommand constructor.
     *
     * @param $filesytem
     * @param $compiler
     */
    public function __construct(Filesystem $filesytem, RCFileCompiler $compiler, GithubAPI $githubapi)
    {
        parent::__construct();
        $this->filesytem = $filesytem;
        $this->compiler = $compiler;
        $this->githubapi = $githubapi;
    }

    /**
     * init command.
     */
    public function init(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->executeWizard($input,$output);
            $this->filesytem->overwrite(
                (new LlumRCFile())->path(),
                $this->compiler->compile(
                    $this->filesytem->get($this->getStubPath()),
                    $this->data));
        } catch (\Exception $e) {
            print_r($e->xdebug_message);
        }
    }

    protected function executeWizard(InputInterface $input, OutputInterface $output){

        $this->askGithubUsername($input,$output);
        $this->askGithubToken($input,$output);

        $this->data = [
            "GITHUB_USERNAME" => $this->github_username,
            "GITHUB_TOKEN" => $this->github_token,
        ];
    }

    public function askGithubUsername(InputInterface $input, OutputInterface $output)
    {
        $question = new Question('Please enter your github username? ');
        $this->github_username = $this->getHelper('question')->ask($input, $output, $question);
    }

    public function askGithubToken(InputInterface $input, OutputInterface $output)
    {
        $question = new ConfirmationQuestion('Do you want to use our assistant to obtain token via Github API?', true);
        if ($this->getHelper('question')->ask($input, $output, $question)) {
            $this->github_token =$this->githubapi->getPersonalToken(
                $this->github_username,
                $this->askGithubPassword($input,$output));
        }
    }

    protected function askGithubPassword(InputInterface $input, OutputInterface $output) {
        $question = new Question('What is your github password?');
        $question->setHidden(true);
        $question->setHiddenFallback(false);

        return $this->getHelper('question')->ask($input, $output, $question);
    }

    /**
     * Get path to stub.
     *
     * @return string
     */
    protected function getStubPath() {
        return __DIR__ . '/stubs/llumrc.stub';
    }
}