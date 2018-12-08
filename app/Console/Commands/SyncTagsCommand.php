<?php

namespace App\Console\Commands;

use App\Domain\Post\Actions\SyncTagAction;
use Domain\Post\Models\Tag;
use Illuminate\Console\Command;
use Symfony\Component\Yaml\Yaml;

class SyncTagsCommand extends Command
{

    protected $signature = 'sync:tags';

    protected $description = 'Sync tags from their YAML definition';

    /** @var \App\Domain\Post\Actions\SyncTagAction */
    private $syncTagAction;

    public function __construct(SyncTagAction $syncTagAction)
    {
        parent::__construct();

        $this->syncTagAction = $syncTagAction;
    }

    public function handle()
    {
        $definition = Yaml::parse(file_get_contents(app_path('tags.yaml')));

        foreach ($definition['tags'] as $name => $item) {
            $tag = $this->syncTagAction->__invoke($name, $item['color'], $item['keywords']);

            $this->comment("Synced tag {$tag->name}");
        }
    }
}
