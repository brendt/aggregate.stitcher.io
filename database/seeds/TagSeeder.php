<?php

use App\Domain\Post\Actions\SyncTagAction;
use Illuminate\Database\Seeder;
use Symfony\Component\Yaml\Yaml;

class TagSeeder extends Seeder
{
    /** @var \App\Domain\Post\Actions\SyncTagAction */
    private $syncTagAction;

    public function __construct()
    {
        $this->syncTagAction = app(SyncTagAction::class);
    }

    public function run()
    {
        $definition = Yaml::parse(file_get_contents(app_path('tags.yaml')));

        foreach ($definition['tags'] as $name => $item) {
            $this->syncTagAction->__invoke($name, $item['color'], $item['keywords']);
        }
    }
}
