<?php

namespace Acacha\Llum\Console;

use Acacha\Llum\Parser\LlumRCParser;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GithubInitCommand.
 *
 * @package Acacha\Llum\Console
 */
class GithubInitCommand extends LlumCommand
{

    use GithubCommand;

    /**
     * Symfony console output.
     *
     * @var OutputInterface
     */
    protected $output;

    /**
     * Llum rc file parser.
     *
     * @var LlumRCParser
     */
    protected $parser;

    /**
     * Command name.
     *
     * @var string
     */
    protected $commandName = 'github:init';

    /**
     * Command description.
     *
     * @var string
     */
    protected $commandDescription = 'Initializes current folder as a new git project';

    /**
     * Method to execute.
     *
     * @var string
     */
    protected $method = 'gitHubInitRepo';

    /**
     * GithubInitCommand constructor.
     *
     * @param LlumRCParser $parser
     */
    public function __construct(LlumRCParser $parser)
    {
        parent::__construct();
        $this->parser = $parser;
    }

    /**
     * Github init repo command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function gitHubInitRepo(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $this->runGitInit();
        $this->runGitAdd();
        $this->runGitCommit();
        $this->runGitCreateRepo();
        $this->runGitRemoteAddOrigin($this->getRepoURL($input,$output));
        $this->runGitPull();
        $this->runGitPush();
    }


    /**
     * Get github repo URL.
     *
     * @param OutputInterface $output
     * @param InputInterface $input
     * @return string
     */
    public function getRepoURL(InputInterface $input, OutputInterface $output)
    {
        return 'git@github.com:' . $this->gitHubUsername($input,$output) . '/' . $this->repoName($input) . '.git';
    }

    /**
     * Obtain repo name.
     *
     * @param InputInterface $input
     * @return mixed|string
     */
    protected function repoName(InputInterface $input) {
        $name = $input->getArgument('name');
        return isset($name) ? $name : basename(getcwd());
    }


    /**
     * Get github username.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return array|mixed
     */
    protected function gitHubUsername(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('github_username');
        return isset($username) ? $username : $this->getGithubUserNameFromConfig($output);
    }

    /**
     * Get github username from llum config.
     *
     * @param OutputInterface $output
     * @return array
     */
    protected function getGithubUserNameFromConfig(OutputInterface $output)
    {
        $username = $this->parser->getGitHubUsername();
        if (is_null($username)) {
            $this->showErrorRunLlumInitFirst($output,'username');
        }
        return $username;
    }

    /**
     * Run git init command.
     */
    protected function runGitInit(){
        $this->showMessageRunningCommand($this->output,'git init');
        passthru('git init');
    }

    /**
     * Run git add command.
     */
    protected function runGitAdd(){
        $this->showMessageRunningCommand($this->output,'git add .');
        passthru('git add .');
    }

    /**
     * Run git commit command.
     */
    protected function runGitCommit(){
        $this->showMessageRunningCommand($this->output,'git commit -a -m "Initial version"');
        passthru('git commit -a -m "Initial version"');
    }

    /**
     * Run llum github:repo command.
     */
    protected function runGitCreateRepo()
    {
        $this->showMessageRunningCommand($this->output,'llum github:repo');
        passthru('llum github:repo');
    }

    /**
     * Run git remote add origin.
     *
     * @param $url
     */
    protected function runGitRemoteAddOrigin($url){
        $this->showMessageRunningCommand($this->output,'git remote add origin ' . $url);
        passthru('git remote add origin ' . $url);
    }

    /**
     * Run git pull.
     */
    protected function runGitPull(){
        $this->showMessageRunningCommand($this->output,'git pull origin master');
        passthru('git pull origin master');
    }

    /**
     * Run git push.
     */
    protected function runGitPush(){
        $this->showMessageRunningCommand($this->output,'git push origin master');
        passthru('git push origin master');
    }

    /**
     * Configure command.
     */
    public function configure()
    {
        parent::configure();

        $this
            // configure an argument
            ->addArgument('name', InputArgument::OPTIONAL, 'Repository name')
            ->addArgument('github_username', InputArgument::OPTIONAL, 'Github username')
        ;
    }
}