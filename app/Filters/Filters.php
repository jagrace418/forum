<?php


namespace App\Filters;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class Filters {

	/**
	 * @var Request
	 */
	protected $request;

	/**
	 * @var Builder
	 */
	protected $builder;

	/**
	 * @var array
	 */
	protected $filters = [];

	/**
	 * Filters constructor.
	 *
	 * @param Request $request
	 */
	public function __construct (Request $request) {
		$this->request = $request;
	}

	/**
	 * @param Builder $builder
	 *
	 * @return Builder
	 */
	public function apply (Builder $builder) {
		$this->builder = $builder;

		foreach ($this->getFilters() as $filter => $value) {
			if (method_exists($this, $filter)) {
				$this->$filter($value);
			}
		}

		return $this->builder;
	}

	/**
	 * @return array
	 */
	public function getFilters (): array {
		return $this->request->only($this->filters);
	}
}