<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 16/8/21
 * Time: 下午10:31
 */

namespace Models;

use Phalcon\Mvc\Model;
use Phalcon\Events\Manager as EventsManager;

class Base extends Model
{
    public function initialize1()
    {
        $eventsManager = new EventsManager();
        $eventsManager->attach('model', function ($event, $robot) {
            if ($event->getType() == 'beforeSave') {
            }
            if ($event->getType() == 'afterCreate') {
                echo 'ssss';
            }

            return true;
        });

        $this->setEventsManager($eventsManager);
    }

}