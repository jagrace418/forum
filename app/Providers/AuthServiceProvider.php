<?php

namespace App\Providers;

use App\User;
use Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider {

	/**
	 * The policy mappings for the application.
	 * @var array
	 */
	protected $policies = [
		// 'App\Model' => 'App\Policies\ModelPolicy',
	];

	/**
	 * Register any authentication / authorization services.
	 * @return void
	 */
	public function boot () {
		$this->registerPolicies();

		//TODO: this is a very rudimentary way to do 'Admin' style things on an app level. Should be obv changed to not be based on a single username
		Gate::before(function (User $user) {
			if ($user->name == 'Joe') {
				return true;
			}
		});
	}
}
