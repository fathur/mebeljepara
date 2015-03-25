<?php

class Product extends \Eloquent {
	protected $guarded = ['product_id'];
	protected $primaryKey = 'product_id';
	protected $table = 'product';
	public $timestamps = false;

	public function descriptions()
	{
		return $this->hasMany('ProductDescription');
	}

	public function rewards()
	{
		return $this->hasMany('ProductReward');
	}

	public function categories()
	{
		return $this->hasMany('ProductToCategory');
	}

	public function layouts()
	{
		return $this->hasMany('ProductToLayout');
	}

	public function stores()
	{
		return $this->hasMany('ProductToStore');
	}
}