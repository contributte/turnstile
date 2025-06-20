<?php declare(strict_types = 1);

namespace Contributte\Turnstile\DI;

use Nette\DI\Definitions\Statement;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use stdClass;

/**
 * @property-read stdClass $config
 */
class TurnstileExtension extends AbstractExtension
{

	public function getConfigSchema(): Schema
	{
		return Expect::structure([
			'mapping' => Expect::arrayOf('string')->required(),
			'fileExtension' => Expect::string(XmlDriver::DEFAULT_FILE_EXTENSION),
			'simple' => Expect::bool(false),
		]);
	}

	public function loadConfiguration(): void
	{
		
	}

}
