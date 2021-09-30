<?php

namespace Brickspace\Shopify\Actions;

use Brickspace\Shopify\Settings\ShopifySettings;
use Helix\Lego\Apps\Actions\Action;

class SkeletonAction extends Action
{
    public static function actionName() : string
    {
        return 'Skeleton action name';
    }

    public static function run() : mixed
    {
        return redirect()->back();
    }
}
