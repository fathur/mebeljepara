<?php

class ProductReward extends \Eloquent {
	protected $primaryKey = 'product_reward_id';
	protected $table = 'product_reward';
	protected $fillable = ['customer_group_id'];
	public $timestamps = false;

	public function product()
	{
		return $this->hasOne('Product');
	}
}