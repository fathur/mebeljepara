<?php

class ProductToStore extends \Eloquent {
	protected $table = 'product_to_store';
	protected $fillable = ['store_id'];
	public $timestamps = false;

	public function product()
	{
		return $this->hasOne('Product');
	}
}