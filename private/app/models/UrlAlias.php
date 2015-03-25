<?php

class UrlAlias extends \Eloquent {
	protected $table = 'url_alias';
	protected $primaryKey = 'url_alias_id';
	protected $fillable = ['query','keyword'];
	public $timestamps = false;
}