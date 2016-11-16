<?php
/**
 * Created by PhpStorm.
 * User: othma
 * Date: 16.11.2016
 * Time: 14:08
 */

namespace App\Controller;
use App\Model\Entity\Event;
use Cake\ORM\TableRegistry;


class CaptureController extends AppController
{
    public function index()
    {
        $events = TableRegistry::get('Events');
        $query = $events->find();
        foreach ($query as $event) {
            echo $event->title . " " . "</br>";
        }

        $newE = new Event([
            'title' => 'New Entity Test KoE',
            'description' => 'Entity Test KoE'
        ]);

        #$events->save($newE);
/*        $newEvent = $events->newEntity();

        $newEvent->title = 'New event occured';
        $newEvent->description = 'New event description';

        if ($events->save($newEvent)) {
            // The $article entity contains the id now
            $id = $newEvent->id;
            echo $newEvent;
        }*/


    }
}