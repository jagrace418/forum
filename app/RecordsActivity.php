<?php


namespace App;


use ReflectionException;

trait RecordsActivity {

	/**
	 * Will be called for all models with the trait
	 */
	protected static function bootRecordsActivity () {
		if (auth()->guest()) return;
		foreach (self::getActivitiesToRecord() as $event) {
			static::created(function ($model) use ($event) {
				$model->recordActivity($event);
			});
		}
	}

	protected static function getActivitiesToRecord () {
		return ['created'];
	}

	protected function recordActivity ($event) {
		//this is one way to do it
//		Activity::create([
//			'user_id'      => auth()->id(),
//			'type'         => $this->getActivityType($event),
//			'subject_id'   => $this->id,
//			'subject_type' => get_class($this),
//		]);
		//but using the morph many below allows this
		$this->activity()->create([
			'user_id' => auth()->id(),
			'type'    => $this->getActivityType($event),
		]);
	}

	/**
	 * @return mixed
	 */
	public function activity () {
		return $this->morphMany(Activity::class, 'subject');
	}

	/**
	 * @param $event
	 *
	 * @return string
	 */
	protected function getActivityType ($event): string {
		$type = '';
		try {
			$type = strtolower((new \ReflectionClass($this))->getShortName());
		} catch (ReflectionException $e) {
			//TODO: do something
		}

		return "{$event}_{$type}";
	}
}