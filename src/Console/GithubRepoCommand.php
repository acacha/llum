<?php

namespace Acacha\Llum\Console;

use Acacha\Llum\Github\GithubAPI;
use Acacha\Llum\Parser\LlumRCParser;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GithubRepoCommand.
 *
 * @package Acacha\Llum\Console
 */
class GithubRepoCommand extends LlumCommand
{

    use GithubCommand;

    /**
     * Github api service class.
     *
     * @var GithubAPI
     */
    protected $api;

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
    protected $commandName = 'github:repo';

    /**
     * Command description.
     *
     * @var string
     */
    protected $commandDescription = 'Creates a github repo';

    /**
     * Method to execute.
     *
     * @var string
     */
    protected $method = 'githubCreateRepo';

    /**
     * GithubRepoCommand constructor.
     * @param GithubAPI $api
     * @param LlumRCParser $parser
     */
    public function __construct(GithubAPI $api, LlumRCParser $parser)
    {
        parent::__construct();
        $this->api = $api;
        $this->parser = $parser;
    }


    /**
     * Github create repo command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function githubCreateRepo(InputInterface $input, OutputInterface $output)
    {
        $this->api->setCredentials($this->getCredentials($output));
        $name = $this->repoName($input);
        try {
            $this->api->createRepo($name,$this->repoDescription($input));
        } catch (ServerException $se) {
            //TODO
            $output->writeln('<error>Server exception thrown</error>');
            die();
        } catch (ClientException $ce) {
            $this->showError( $ce , $output );
        }
        $output->writeln('<info>Repository ' . $name . ' created</info>');
    }



    /**
     * Show error.
     * @param ClientException $ce
     * @param OutputInterface $output
     */
    protected function showError(ClientException $ce, OutputInterface $output)
    {
        if ($ce->getResponse()->getStatusCode() == 422) {
            $output->writeln('<error>Repository already exists</error>');
            die();
        }
        $output->writeln('<error>Client Request exception thrown</error>');
        die();
    }


    /**
     * Get credentials.
     *
     * @param OutputInterface $input
     * @return array
     */
    public function getCredentials(OutputInterface $output)
    {
        $credentials = $this->parser->getCredentials();
        if ( is_null($credentials)) {
            $this->showErrorRunLlumInitFirst($output,"Credentials");
        };
        return $credentials;
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
     * Obtain repo description.
     *
     * @param InputInterface $input
     * @return mixed|string
     */
    protected function repoDescription(InputInterface $input) {
        $description = $input->getArgument('description');
        return isset($description) ? $description : "";
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
            ->addArgument('description', InputArgument::OPTIONAL, 'Repository description')
        ;
    }

}