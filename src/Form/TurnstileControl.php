<?php declare(strict_types = 1);

namespace Contributte\Turnstile\Forms;

use Nette\Forms\Container;

class TurnstileControl extends \Nette\Forms\Controls\BaseControl
{

    public const TURNSTILE_CDN = 'https://challenges.cloudflare.com/turnstile/v0/api.js';

	public function __construct(
        protected ?string $label = null, 
        protected ?string $message = null
    )
	{
		parent::__construct($label);

		$this->setOmitted(true);
		$this->control = Html::el('div');
		$this->control->addClass('cf-turnstile');
	}

	public function loadHttpData(): void
	{
		$form = $this->getForm();
		assert($form !== null);

		$this->setValue($form->getHttpData(Form::DATA_TEXT, 'cf-turnstile-response'));
	}

	public function setMessage(string $message): self
	{
		$this->message = $message;

		return $this;
	}

	public function validate(): void
	{
		parent::validate();

        
	}

	public function getControl(): Html
	{
		$this->configureValidation();

		$el = parent::getControl();
		$el->addAttributes([
			'id' => $this->getHtmlId(),
			'name' => $this->getHtmlName(),
			'data-sitekey' => $this->provider->getSiteKey(),
		]);

		return $el;
	}

	public static function bind(ReCaptchaProvider $provider): void
	{
		Container::extensionMethod('addTurnstile', function (Container $container, string $name = 'recaptcha', string $label = 'ReCaptcha', bool|string $required = true, ?string $message = null) use ($provider): ReCaptchaField {
			$field = new ReCaptchaField($provider, $label, $message);
			$field->setRequired($required);
			$container[$name] = $field;

			return $field;
		});
	}

    public static function use(Form $form, string $name = 'turnstile'): TurnstileControl
    {
        return $form->addTurnstile($name);
    }

}