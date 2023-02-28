<?php


namespace App\Listener;


use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class GenerateSlugListener
{

    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function prePersist(LifecycleEventArgs $event)
    {
        $this->generateSlug($event);
    }

    public function preUpdate(LifecycleEventArgs $event)
    {
        $this->generateSlug($event);
    }

    private function generateSlug(LifecycleEventArgs $event){
        $entity=$event->getObject();

        if (!in_array(get_class($entity),[Category::class,Product::class])){
            return;
        }

        $entity->computeSlug($this->slugger);
    }
}