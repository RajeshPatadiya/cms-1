<?php

class DeviseSeeder extends \Devise\Support\DeviseSeeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// these things only need to be run once
		// the admin is able to change them afterwards
        $this->callOnlyOnce('DeviseLanguagesSeeder');
		$this->callOnlyOnce('DeviseGroupsSeeder');

		// pages is wired so that it will allow us
		// to keep cramming pages in there if we
		// need to add more. Same thing for menus
		$this->call('DevisePagesSeeder');
		$this->call('DeviseMenusSeeder');
		$this->call('DeviseTestModelSeeder');

		// has failsafes to make sure only old middleware values
		// will be updated
		$this->call('DeviseBeforeToMiddlewareSeeder');
	}
}