<?php

namespace App\Links;

use Tempest\Database\Query;
use Tempest\Http\Responses\Redirect;
use Tempest\Router\Get;

final class LinkController
{
    #[Get('/links/{uuid}')]
    public function __invoke(string $uuid): Redirect
    {
        $link = Link::select()->where('uuid', $uuid)->first();

        new Query('UPDATE links SET visits = visits + 1 WHERE id = ?', [$link->id])->execute();

        return new Redirect($link->uri);
    }
}