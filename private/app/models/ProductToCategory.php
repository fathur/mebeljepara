<?php

class ProductToCategory extends \Eloquent {
	protected $table = 'product_to_category';
	protected $fillable = ['category_id'];
	public $timestamps = false;
	
	public function product()
	{
		return $this->hasOne('Product');
	}
}