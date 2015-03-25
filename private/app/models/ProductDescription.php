<?php

class ProductDescription extends \Eloquent {
	protected $guarded = [];
	protected $table = 'product_description';
	public $timestamps = false;

	public function product()
	{
		return $this->hasOne('Product');
	}
}