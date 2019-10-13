<?php

namespace Language;

use Language\Adapters\LogAdapter;
use Language\Adapters\ConfigAdapter;
use Language\Language\LanguageFactory;

/**
 * Business logic related to generating language files.
 */
class LanguageBatchBo
{

	private $config;
	private $logger;
	private $factory;
	
	public function __construct(
		LogAdapter $logger = null,
		ConfigAdapter $config = null,
		LanguageFactory $factory = null
	) {
		$this->config = $config;
		if (is_null($config)) {
			$this->config = new ConfigAdapter();
		}
		$this->logger = $logger;
		if (is_null($logger)) {
			$this->logger = new LogAdapter();
		}
		$this->factory = $factory;
		if(is_null($factory)) {
			$this->factory = new LanguageFactory($this->config);
		}
	}

	/**
	 * Contains the applications which ones require translations.
	 *
	 * @var array
	 */
	protected $applications = array();

	/**
	 * Starts the language file generation.
	 *
	 * @return void
	 */
	public function generateLanguageFiles()
	{
		// The applications where we need to translate.
		$this->applications = $this->config->get('system.translated_applications');

		$this->logger->log("\nGenerating language files\n");

		$normalLanguage = $this->factory->makeNormal();

		foreach ($this->applications as $application => $languages) {
			$this->logger->log("[APPLICATION: " . $application . "]\n");
			foreach ($languages as $language) {
				$this->logger->log("\t[LANGUAGE: " . $language . "]");
				if ($normalLanguage->getFile($application, $language)) {
					$this->logger->log(" OK\n");
				}
				else {
					throw new \Exception('Unable to generate language file!');
				}
			}
		}
	}

	/**
	 * Gets the language files for the applet and puts them into the cache.
	 *
	 * @throws Exception   If there was an error.
	 *
	 * @return void
	 */
	public function generateAppletLanguageXmlFiles()
	{
		$applet = $this->factory->makeApplet();

		// List of the applets [directory => applet_id].
		$applets = array(
			'memberapplet' => 'JSM2_MemberApplet',
		);

		$this->logger->log("\nGetting applet language XMLs..\n");

		foreach ($applets as $appletDirectory => $appletLanguageId) {
			$this->logger->log(" Getting > $appletLanguageId ($appletDirectory) language xmls..\n");
			$languages = $applet->get($appletLanguageId);
			if (empty($languages)) {
				throw new \Exception('There is no available languages for the ' . $appletLanguageId . ' applet.');
			}
			else {
				$this->logger->log(' - Available languages: ' . implode(', ', $languages) . "\n");
			}
			$path = $this->config->get('system.paths.root') . '/cache/flash';
			foreach ($languages as $language) {
				$xmlContent = $applet->getFile($appletLanguageId, $language);
				$xmlFile    = $path . '/lang_' . $language . '.xml';
				if (strlen($xmlContent) == $this->logger->addFile($xmlFile, $xmlContent)) {
					$this->logger->log(" OK saving $xmlFile was successful.\n");
				}
				else {
					throw new \Exception('Unable to save applet: (' . $appletLanguageId . ') language: (' . $language
						. ') xml (' . $xmlFile . ')!');
				}
			}
			$this->logger->log(" < $appletLanguageId ($appletDirectory) language xml cached.\n");
		}

		$this->logger->log("\nApplet language XMLs generated.\n");
	}
}
