<?php declare(strict_types = 1);

namespace PHPStan\Type\Symfony;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use function PHPStan\Testing\assertType;

final class ExampleOptionLazyCommand extends Command
{

	protected static $defaultName = 'lazy-example-option';
	protected static $defaultDescription = 'lazy example description';

	protected function configure(): void
	{
		parent::configure();

		$this->addOption('a', null, InputOption::VALUE_NONE);
		$this->addOption('b', null, InputOption::VALUE_OPTIONAL);
		$this->addOption('c', null, InputOption::VALUE_REQUIRED);
		$this->addOption('d', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL);
		$this->addOption('e', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED);

		$this->addOption('bb', null, InputOption::VALUE_OPTIONAL, '', 1);
		$this->addOption('cc', null, InputOption::VALUE_REQUIRED, '', 1);
		$this->addOption('dd', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL, '', [1]);
		$this->addOption('ee', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED, '', [1]);
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		assertType('bool', $input->getOption('a'));
		assertType('string|null', $input->getOption('b'));
		assertType('string|null', $input->getOption('c'));
		assertType('array<int, string|null>', $input->getOption('d'));
		assertType('array<int, string>', $input->getOption('e'));

		assertType('1|string|null', $input->getOption('bb'));
		assertType('1|string', $input->getOption('cc'));
		assertType('array<int, 1|string|null>', $input->getOption('dd'));
		assertType('array<int, 1|string>', $input->getOption('ee'));
	}

}
