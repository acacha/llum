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

/**
 * Class InitCommand
 * @package Acacha\Llum\Console
 */
class InitCommand extends LlumCommand
{

    /**
     * Github api service class.
     *
     * @var GithubAPI
     */
    protected $api;

    /**
     * Filesystem.
     *
     * @var Filesystem
     */
    protected $filesystem;

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

    /**
     * Github username
     *
     * @var
     */
    protected $github_username;

    /**
     * Github token.
     *
     * @var string
     */
    protected $github_token = "";

    /**
     * Get path to stub.
     *
     * @return string
     */
    protected function getStubPath() {
        return __DIR__ . '/stubs/llumrc.stub';
    }


    /**
     * InitCommand constructor.
     *
     * @param Filesystem $filesystem
     * @param RCFileCompiler $compiler
     * @param GithubAPI $api
     */
    public function __construct(Filesystem $filesystem, RCFileCompiler $compiler, GithubAPI $api)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
        $this->compiler = $compiler;
        $this->api = $api;
    }

    /**
     * init command.
     */
    public function init(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->executeWizard($input,$output);
            $this->filesystem->overwrite(
                (new LlumRCFile())->path(),
                $this->compiler->compile(
                    $this->filesystem->get($this->getStubPath()),
                    $this->data));
        } catch (\Exception $e) {
            print_r($e->xdebug_message);
        }
    }

    /**
     * Executes wizard.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function executeWizard(InputInterface $input, OutputInterface $output){

        $this->askGithubUsername($input,$output);
        $this->askGithubToken($input,$output);

        $this->data = [
            "GITHUB_USERNAME" => $this->github_username,
            "GITHUB_TOKEN" => $this->github_token,
            "GITHUB_TOKEN_NAME" => $this->api->tokenName(),
        ];
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function askGithubUsername(InputInterface $input, OutputInterface $output)
    {
        $defaultusername = $this->defaultUsername();
        $question = new Question('<info>Please enter your github username (' . $defaultusername . ') ? </info>', $defaultusername);
        $this->github_username = $this->getHelper('question')->ask($input, $output, $question);
    }

    /**
     * @return string
     */
    protected function defaultUsername()
    {
        return get_current_user();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function askGithubToken(InputInterface $input, OutputInterface $output)
    {
        $question = new ConfirmationQuestion('<info>Do you want to use our assistant to obtain token via Github API (Y/n)? </info>', true);
        if ($this->getHelper('question')->ask($input, $output, $question)) {
            $this->github_token =$this->api->getPersonalToken(
                $this->github_username,
                $this->askGithubPassword($input,$output));
        }
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     */
    protected function askGithubPassword(InputInterface $input, OutputInterface $output) {
        $question = new Question('<info>Github password? </info>');
        $question->setHidden(true);
        $question->setHiddenFallback(false);

        return $this->getHelper('question')->ask($input, $output, $question);
    }
}