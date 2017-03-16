<?php namespace Limoncello\Flute\Contracts\Api;

/**
 * Copyright 2015-2017 info@neomerx.com
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

use Limoncello\Flute\Contracts\Models\PaginatedDataInterface;
use Limoncello\Flute\Http\Query\FilterParameterCollection;

/**
 * @package Limoncello\Flute
 */
interface CrudInterface
{
    /**
     * @param FilterParameterCollection|null $filterParams
     * @param array|null                     $sortParams
     * @param array|null                     $includePaths
     * @param array|null                     $pagingParams
     *
     * @return ModelsDataInterface
     */
    public function index(
        FilterParameterCollection $filterParams = null,
        array $sortParams = null,
        array $includePaths = null,
        array $pagingParams = null
    );

    /**
     * @param FilterParameterCollection|null $filterParams
     * @param array|null                     $sortParams
     *
     * @return array
     */
    public function indexResources(FilterParameterCollection $filterParams = null, array $sortParams = null);

    /**
     * @param int|string                     $index
     * @param FilterParameterCollection|null $filterParams
     * @param array|null                     $includePaths
     *
     * @return ModelsDataInterface
     */
    public function read($index, FilterParameterCollection $filterParams = null, array $includePaths = null);

    /**
     * @param int|string                     $index
     * @param FilterParameterCollection|null $filterParams
     *
     * @return mixed|null
     */
    public function readResource($index, FilterParameterCollection $filterParams = null);

    /**
     * @param int|string $index
     *
     * @return int
     */
    public function delete($index);

    /**
     * @param null|string $index
     * @param array       $attributes
     * @param array       $toMany
     *
     * @return string
     */
    public function create($index, array $attributes, array $toMany = []);

    /**
     * @param int|string $index
     * @param array      $attributes
     * @param array      $toMany
     *
     * @return int
     */
    public function update($index, array $attributes, array $toMany = []);

    /**
     * @param int|string                     $index
     * @param string                         $relationshipName
     * @param FilterParameterCollection|null $filterParams
     * @param array|null                     $sortParams
     * @param array|null                     $pagingParams
     *
     * @return PaginatedDataInterface
     */
    public function readRelationship(
        $index,
        $relationshipName,
        FilterParameterCollection $filterParams = null,
        array $sortParams = null,
        array $pagingParams = null
    );

    /**
     * @param int|string $parentId
     * @param string     $name
     * @param int|string $childId
     *
     * @return bool
     */
    public function hasInRelationship($parentId, $name, $childId);

    /**
     * @param int|string $index
     *
     * @return array|null
     */
    public function readRow($index);

    /**
     * @param FilterParameterCollection|null $filterParams
     *
     * @return int|null
     */
    public function count(FilterParameterCollection $filterParams = null);
}
