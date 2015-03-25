<?php

class ProductToLayout extends \Eloquent {
	protected $table = 'product_to_layout';
	protected $fillable = ['store_id','layout_id'];
	public $timestamps = false;

	public function product()
	{
		return $this->hasOne('Product');
	}
}