<?php

namespace Yajra\CMS\Presenters;

use Laracasts\Presenter\Presenter;
use Yajra\CMS\Widgets\EloquentRepository;

class WidgetPresenter extends Presenter
{
    /**
     * Get widget's view template.
     *
     * @return string
     */
    public function template()
    {
        return $this->entity->template === 'custom' ? $this->entity->custom_template : $this->entity->template;
    }

    /**
     * Get widget type FQCN.
     *
     * @return string
     * @throws \Exception
     */
    public function type()
    {
        /** @var EloquentRepository $repository */
        $repository = app('widgets');

        return $repository->findOrFail($this->entity->type)->class;
    }
}
