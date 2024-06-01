<?php

namespace App\Traits;

trait ModelTrait
{
    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters ?? [];
    }

    /**
     * @return array
     */
    public function getFilterModels(): array
    {
        return $this->filterModels ?? [];
    }

    public function getDefinedRelations()
    {
        return $this->definedRelations ?? [];
    }



}
