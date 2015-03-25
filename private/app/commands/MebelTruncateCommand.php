<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MebelTruncateCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'mebel:truncate';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Truncate related table products.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		// delete seo url
		$urlAlias = UrlAlias::where('query','like','product_id=%')->get();
		foreach ($urlAlias as $ua) {
			$ua->delete();
		}
		// truncate products
		ProductDescription::truncate();
		ProductReward::truncate();
		ProductToCategory::truncate();
		ProductToStore::truncate();
		ProductToLayout::truncate();
		Product::truncate();
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			//array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			//array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
