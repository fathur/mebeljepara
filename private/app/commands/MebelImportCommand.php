<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use \Carbon\Carbon;
use \PHPExcel;
use \PHPExcel_IOFactory as IO_Factory;
use \PHPExcel_Cell as Cell;
use \PHPExcel_Cell_DataType as DataType;

class MebelImportCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'mebel:import';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Import products from excel to database.';

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
		$path = $this->option('path');
		$file = $this->option('file');
		$sheet = $this->option('sheet');
		if (null == $file) 
			die('ERROR: Hayo lo.. File nggak diinput!!!');

		$objPHPExcel = IO_Factory::load( $path . $file);
		$worksheets = $objPHPExcel->getWorksheetIterator();
		//dd($worksheets);
		//$worksheet = $worksheets[(int) $sheet];
		foreach ($worksheets as $worksheet) {
			$worksheetTitle     = $worksheet->getTitle();
			$highestRow         = $worksheet->getHighestRow(); // e.g. 10
			$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
			$highestColumnIndex = Cell::columnIndexFromString($highestColumn);

			// Import mulai dari baris nomor 3, heading tidak masuk
			for ($row = 3; $row <= $highestRow; $row++) { 

				$data = array(
					'name_id'				=> $worksheet->getCellByColumnAndRow(1-1, $row),
					'description_id' 		=> $worksheet->getCellByColumnAndRow(2-1, $row),
					'meta_title_id' 		=> $worksheet->getCellByColumnAndRow(3-1, $row),
					'meta_description_id' 	=> $worksheet->getCellByColumnAndRow(4-1, $row),
					'meta_keyword_id' 		=> $worksheet->getCellByColumnAndRow(5-1, $row),
					'tag_id' 				=> $worksheet->getCellByColumnAndRow(6-1, $row),
					'name_en' 				=> $worksheet->getCellByColumnAndRow(7-1, $row),
					'description_en' 		=> $worksheet->getCellByColumnAndRow(8-1, $row),
					'meta_title_en' 		=> $worksheet->getCellByColumnAndRow(9-1, $row),
					'meta_description_en' 	=> $worksheet->getCellByColumnAndRow(10-1, $row),
					'meta_keyword_en' 		=> $worksheet->getCellByColumnAndRow(11-1, $row),
					'tag_en' 				=> $worksheet->getCellByColumnAndRow(12-1, $row),
					'image' 				=> $worksheet->getCellByColumnAndRow(13-1, $row),
					'model'					=> $worksheet->getCellByColumnAndRow(14-1, $row),
					'sku' 					=> $worksheet->getCellByColumnAndRow(15-1, $row),
					/*'upc' 			=> $worksheet->getCellByColumnAndRow(16-1, $row),
					'ean' 				=> $worksheet->getCellByColumnAndRow(17-1, $row),
					'jan' 				=> $worksheet->getCellByColumnAndRow(18-1, $row),
					'isbn' 				=> $worksheet->getCellByColumnAndRow(19-1, $row),
					'mpn' 				=> $worksheet->getCellByColumnAndRow(20-1, $row),*/
					'location'			=> $worksheet->getCellByColumnAndRow(21-1, $row),
					'price' 			=> $worksheet->getCellByColumnAndRow(22-1, $row),
					'tax_class_id' 		=> $worksheet->getCellByColumnAndRow(23-1, $row),
					'quantity' 			=> $worksheet->getCellByColumnAndRow(24-1, $row),
					'minimum'			=> $worksheet->getCellByColumnAndRow(25-1, $row),
					'substract'			=> $worksheet->getCellByColumnAndRow(26-1, $row),
					'stock_status_id'	=> $worksheet->getCellByColumnAndRow(27-1, $row),
					'shipping'			=> $worksheet->getCellByColumnAndRow(28-1, $row),
					'url_slug' 			=> $worksheet->getCellByColumnAndRow(29-1, $row), 
					'length'			=> $worksheet->getCellByColumnAndRow(31-1, $row),
					'width' 			=> $worksheet->getCellByColumnAndRow(32-1, $row),
					'height'			=> $worksheet->getCellByColumnAndRow(33-1, $row),
					'length_class_id' 	=> $worksheet->getCellByColumnAndRow(34-1, $row),
					'weight'			=> $worksheet->getCellByColumnAndRow(35-1, $row),
					'weight_class_id'	=> $worksheet->getCellByColumnAndRow(36-1, $row),
					'status'			=> $worksheet->getCellByColumnAndRow(37-1, $row),
					'sort_order'		=> $worksheet->getCellByColumnAndRow(38-1, $row)
				);
	
				$this->insert($data);
			}
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
		//	array('argumen', InputArgument::REQUIRED, 'An example argument.'),
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
			array('file', null, InputOption::VALUE_REQUIRED, 'File yang mau di import', null),
			array('path', null, InputOption::VALUE_OPTIONAL, 'Lokasi file', 'storage/xls/'),
			array('sheet', null, InputOption::VALUE_OPTIONAL, 'Sheet number', 1)
		);
	}

	protected function insert(array $data)
	{
		$product = new Product;
		$product->model 			= $data['model'];
		$product->sku 				= $data['sku'];
		$product->location 			= $data['location'];
		$product->quantity 			= $data['quantity'];
		$product->stock_status_id 	= $data['stock_status_id'];
		$product->image 			= $data['image'];
		$product->price 			= $data['price'];
		$product->weight 			= $data['weight'];
		$product->weight_class_id 	= $data['weight_class_id'];
		$product->length 			= $data['length'];
		$product->width 			= $data['width'];
		$product->height 			= $data['height'];
		$product->length_class_id 	= $data['length_class_id'];
		$product->sort_order 		= $data['sort_order'];
		$product->status 			= $data['status'];
		$product->date_available 	= Carbon::now()->toDateString();
		$product->date_added 		= Carbon::now()->toDateString();
		$product->save();

		
		if ($product->save()) {
			
			$product->descriptions()->saveMany([
				// ENglish
				new ProductDescription([
					'language_id'		=> 1,
					'name'				=> $data['name_en'],
					'description'		=> $data['description_en'],
					'tag'				=> $data['tag_en'],
					'meta_title'		=> $data['meta_title_en'],
					'meta_description'	=> $data['meta_description_en'],
					'meta_keyword'		=> $data['meta_keyword_en']
				]),
				//InDonesia
				new ProductDescription([
					'language_id'		=> 2,
					'name'				=> $data['name_id'],
					'description'		=> $data['description_id'],
					'tag'				=> $data['tag_id'],
					'meta_title'		=> $data['meta_title_id'],
					'meta_description'	=> $data['meta_description_id'],
					'meta_keyword'		=> $data['meta_keyword_id']
				])
			]);

			$product->rewards()->save(new ProductReward([
				'customer_group_id'	=> 1
			]));

			// Bisa multiple category lo
			// Bisa dynamic category juga
			$product->categories()->saveMany([
				new ProductToCategory([
					'category_id'	=> 59
				])
			]);

			$product->layouts()->save(new ProductToLayout([
				'store_id'	=> 0,
				'layout_id'	=> 0
			]));

			$product->stores()->save(new ProductToStore([
				'store_id'	=> 0
			]));
	
			//echo $product->product_id;
			$seoUrl = new UrlAlias;
			$seoUrl->query = 'product_id=' . $product->product_id;
			$seoUrl->keyword = $data['url_slug'];
			$seoUrl->save();
		}
	}

}
