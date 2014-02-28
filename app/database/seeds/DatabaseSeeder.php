<?php

class DatabaseSeeder extends Seeder {

	public $faker;
	
	public function getFaker(){
			
		if(empty($this->faker)){
			$this->faker = Faker\Factory::create();
			$this->faker->addProvider(new Faker\Provider\Base($this->faker));
			$this->faker->addProvider(new Faker\Provider\Lorem($this->faker));
			$this->faker->addProvider(new Faker\Provider\en_US\Address($this->faker));
		}
		
		return $this->faker;
		
	}
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		
		$this->call('AccountTableSeeder');
		$this->command->info('Account table seeded!');
		
		$this->call('AccountChannelTableSeeder');
		$this->command->info('AccountChannel table seeded!');
		
		$this->call('FiveGProductTableSeeder');
		$this->command->info('FiveGProduct table seeded!');
		
		$this->call('FiveGProductAttributeTableSeeder');
		$this->command->info('FiveGProductAttribute table seeded!');
		
		$this->call('FiveGVariantTableSeeder');
		$this->command->info('FiveGVariant table seeded!');
		
		$this->call('ChannelProductLUTableSeeder');
		$this->command->info('ChannelProductLU table seeded!');

	}

}