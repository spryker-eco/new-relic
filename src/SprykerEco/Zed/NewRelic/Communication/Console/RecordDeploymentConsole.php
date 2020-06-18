<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\NewRelic\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \SprykerEco\Zed\NewRelic\Business\NewRelicFacadeInterface getFacade()
 */
class RecordDeploymentConsole extends Console
{
    protected const COMMAND_NAME = 'newrelic:record-deployment';
    protected const DESCRIPTION = 'Send deployment notification to New Relic';

    protected const ARGUMENT_APPLICATION_NAME = 'app_name';
    protected const ARGUMENT_APPLICATION_NAME_DESCRIPTION = 'The name of the application in New Relic';

    protected const ARGUMENT_USER = 'user';
    protected const ARGUMENT_USER_DESCRIPTION = 'The name of the deployer';

    protected const ARGUMENT_REVISION = 'revision';
    protected const ARGUMENT_REVISION_DESCRIPTION = 'Revision number';

    protected const ARGUMENT_DESCRIPTION = 'description';
    protected const ARGUMENT_DESCRIPTION_DESCRIPTION = 'Deployment description';

    protected const ARGUMENT_CHANGELOG = 'changelog';
    protected const ARGUMENT_CHANGELOG_DESCRIPTION = 'Change log';

    /**
     * @return void
     */
    protected function configure(): void
    {
        parent::configure();

        $this->setName(static::COMMAND_NAME);
        $this->setDescription(static::DESCRIPTION);

        $this->addArgument(
            static::ARGUMENT_APPLICATION_NAME,
            InputArgument::REQUIRED,
            static::ARGUMENT_APPLICATION_NAME_DESCRIPTION
        );

        $this->addArgument(
            static::ARGUMENT_USER,
            InputArgument::REQUIRED,
            static::ARGUMENT_USER_DESCRIPTION
        );

        $this->addArgument(
            static::ARGUMENT_REVISION,
            InputArgument::REQUIRED,
            static::ARGUMENT_REVISION_DESCRIPTION
        );

        $this->addArgument(
            static::ARGUMENT_DESCRIPTION,
            InputArgument::OPTIONAL,
            static::ARGUMENT_DESCRIPTION_DESCRIPTION
        );

        $this->addArgument(
            static::ARGUMENT_CHANGELOG,
            InputArgument::OPTIONAL,
            static::ARGUMENT_CHANGELOG_DESCRIPTION
        );
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->getMessenger()->info(sprintf(
            'Send deployment notification to New Relic for %s',
            $input->getArgument(static::ARGUMENT_APPLICATION_NAME)
        ));

        $arguments = $input->getArguments();
        unset($arguments['command']);

        $this->getFacade()->recordDeployment($arguments);

        return 0;
    }
}
